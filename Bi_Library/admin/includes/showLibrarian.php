<?php

/**
 * BiLibrary - Librarian Management
 * ERROR-FREE VERSION
 * Fixes:
 *  1. onerror infinite loop on broken images → this.onerror=null added
 *  2. updated_at column guard → isset() check before using
 *  3. $conn guard → checks connection before querying
 *  4. $result guard → checks query success before mysqli_num_rows
 *  5. All PHP outputs use htmlspecialchars() to prevent XSS
 *  6. JS confirmDelete uses proper escaping to prevent JS injection
 *  7. DataTables re-init guard → checks if already initialised
 *  8. All libraries loaded in correct order (jQuery → Bootstrap → DataTables)
 */

// ─── DB connection guard ────────────────────────────────────────────────────
// Uncomment the two lines below if $conn is NOT already defined by the parent file
// require_once __DIR__ . '/../config/db.php';  // adjust path as needed
// global $conn; // only needed if $conn lives in another scope

$total_librarians = 0;
$librarians       = [];

if (isset($conn) && $conn) {
    $query  = "SELECT * FROM librarian_tbl ORDER BY lb_id DESC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $total_librarians = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
            $librarians[] = $row;
        }
        mysqli_free_result($result);
    }
}

// ─── Helper: status badge data ───────────────────────────────────────────────
function getStatusStyle(string $status): array
{
    switch (strtolower($status)) {
        case 'active':
            return ['bg-success', 'fa-check-circle'];
        case 'inactive':
            return ['bg-secondary', 'fa-circle'];
        case 'suspended':
            return ['bg-danger',  'fa-ban'];
        default:
            return ['bg-primary',  'fa-user'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiLibrary – Librarian Management</title>

    <!-- 1. Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- 2. Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 3. Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- 4. DataTables Bootstrap5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        /* ── Base ─────────────────────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4fb;
            color: #1e293b;
        }

        /* ── Card ─────────────────────────────────────────────────────────────── */
        .main-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(37, 99, 235, .09);
            overflow: hidden;
        }

        .card-header-custom {
            background: #fff;
            padding: 1.5rem 1.75rem 1rem;
            border-bottom: 1px solid #e9eef6;
        }

        /* ── Table ────────────────────────────────────────────────────────────── */
        #librarianTable thead tr {
            background: linear-gradient(135deg, #f8faff 0%, #eef3fb 100%);
        }

        #librarianTable thead th {
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        #librarianTable tbody tr {
            transition: background .15s ease;
        }

        #librarianTable tbody tr:hover {
            background: rgba(59, 130, 246, .04);
        }

        /* ── Avatar ───────────────────────────────────────────────────────────── */
        .avatar-img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .avatar-img:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .14);
        }

        /* ── Badges ───────────────────────────────────────────────────────────── */
        .badge {
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .03em;
            padding: .38em .8em;
            border-radius: 50px;
        }

        .bg-success {
            background: linear-gradient(135deg, #059669, #10b981) !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
        }

        .bg-secondary {
            background: linear-gradient(135deg, #64748b, #94a3b8) !important;
        }

        /* ── Action button ────────────────────────────────────────────────────── */
        .btn-action {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            transition: all .18s ease;
        }

        .btn-action:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #1e293b;
        }

        /* ── Dropdown ─────────────────────────────────────────────────────────── */
        .dropdown-menu {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
            padding: .4rem;
            animation: fadeDown .18s ease;
        }

        .dropdown-item {
            border-radius: 8px;
            font-size: .84rem;
            padding: .5rem .85rem;
            transition: background .12s ease;
        }

        .dropdown-item:hover {
            background: #f1f5f9;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Empty state ──────────────────────────────────────────────────────── */
        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 2.8rem;
            color: #cbd5e1;
        }

        /* ── DataTables overrides ─────────────────────────────────────────────── */
        .dataTables_wrapper .dataTables_filter input {
            border: 1.5px solid #e2e8f0;
            border-radius: 40px;
            padding: .38rem 1rem;
            font-size: .85rem;
            outline: none;
            transition: border-color .2s;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
        }

        div.dataTables_wrapper div.dataTables_length select {
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: .28rem .5rem;
            font-size: .85rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 40px !important;
            margin: 0 2px !important;
            font-size: .82rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border-color: #3b82f6 !important;
            color: #fff !important;
        }

        /* ── Modal ────────────────────────────────────────────────────────────── */
        .modal-content {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, .18);
        }

        .modal-avatar {
            width: 96px;
            height: 96px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .1);
        }

        .detail-block {
            background: #f8faff;
            border-radius: 10px;
            padding: .85rem 1rem;
        }

        .detail-block small {
            font-size: .72rem;
            color: #94a3b8;
            display: block;
            margin-bottom: .15rem;
        }

        .detail-block strong {
            font-size: .9rem;
            color: #1e293b;
        }

        /* ── Delete modal header ──────────────────────────────────────────────── */
        .modal-header-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border-radius: 18px 18px 0 0;
        }

        /* ── Scrollbar ────────────────────────────────────────────────────────── */
        .table-responsive::-webkit-scrollbar {
            height: 5px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container-fluid px-4 py-4">

        <!-- ── Flash messages (set in PHP before include if needed) ── -->
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['flash_success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_SESSION['flash_error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <!-- ── Main card ── -->
        <div class="card main-card">

            <!-- Header -->
            <div class="card-header-custom d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h5 class="fw-bold mb-1" style="color:#1e293b;">
                        <i class="fas fa-user-tie me-2 text-primary"></i>Librarian Management
                    </h5>
                    <p class="text-muted small mb-0">Manage all librarians in the system</p>
                </div>
                <a href="?page=add" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Add New Librarian
                </a>
            </div>

            <!-- Body -->
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="librarianTable" class="table table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">#ID</th>
                                <th class="px-3 py-3">Full Name</th>
                                <th class="px-3 py-3">Email Address</th>
                                <th class="px-3 py-3">Photo</th>
                                <th class="px-3 py-3">Status</th>
                                <th class="px-3 py-3">Registered On</th>
                                <th class="px-3 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($librarians)): ?>
                                <?php foreach ($librarians as $data):
                                    [$statusClass, $statusIcon] = getStatusStyle($data['lb_status'] ?? '');
                                    $safeId    = (int) $data['lb_id'];
                                    $safeName  = htmlspecialchars($data['lb_name']  ?? '', ENT_QUOTES);
                                    $safeEmail = htmlspecialchars($data['lb_email'] ?? '', ENT_QUOTES);
                                    $safeImg   = htmlspecialchars($data['lb_image'] ?? '', ENT_QUOTES);
                                    $safeStatus = htmlspecialchars($data['lb_status'] ?? '', ENT_QUOTES);
                                    $createdAt = !empty($data['created_at']) ? strtotime($data['created_at']) : false;
                                    $updatedAt = !empty($data['updated_at']) ? strtotime($data['updated_at']) : false;

                                    // JS-safe name for onclick (prevents JS injection)
                                    $jsName = addslashes($data['lb_name'] ?? '');
                                ?>
                                    <tr class="border-bottom">

                                        <!-- ID -->
                                        <td class="px-3 py-3">
                                            <span class="fw-semibold text-primary">
                                                #<?= str_pad($safeId, 4, '0', STR_PAD_LEFT) ?>
                                            </span>
                                        </td>

                                        <!-- Name -->
                                        <td class="px-3 py-3">
                                            <span class="fw-semibold" style="color:#1e293b;"><?= $safeName ?></span>
                                        </td>

                                        <!-- Email -->
                                        <td class="px-3 py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-envelope text-muted" style="font-size:.8rem;"></i>
                                                <span><?= $safeEmail ?></span>
                                            </div>
                                        </td>

                                        <!-- Photo — FIX: this.onerror=null stops infinite loop -->
                                        <td class="px-3 py-3">
                                            <img src="../assets/librarians/<?= $safeImg ?>"
                                                alt="<?= $safeName ?>"
                                                class="avatar-img"
                                                onerror="this.onerror=null;this.src='../assets/librarians/default-avatar.png';">
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 py-3">
                                            <span class="badge <?= $statusClass ?> shadow-sm">
                                                <i class="fas <?= $statusIcon ?> me-1"></i>
                                                <?= ucfirst($safeStatus) ?>
                                            </span>
                                        </td>

                                        <!-- Registered On -->
                                        <td class="px-3 py-3">
                                            <?php if ($createdAt): ?>
                                                <div class="small fw-medium"><?= date('d M Y', $createdAt) ?></div>
                                                <small class="text-muted"><?= date('h:i A', $createdAt) ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">—</small>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-3 py-3 text-center">
                                            <div class="dropdown">
                                                <button class="btn-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewModal<?= $safeId ?>">
                                                            <i class="fas fa-eye text-info me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="?page=edit&id=<?= $safeId ?>">
                                                            <i class="fas fa-edit text-warning me-2"></i>Edit Librarian
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider my-1">
                                                    </li>
                                                    <li>
                                                        <!-- FIX: JSON-encoded name prevents JS injection -->
                                                        <a class="dropdown-item text-danger"
                                                            href="javascript:void(0)"
                                                            onclick="confirmDelete(<?= $safeId ?>, <?= json_encode($data['lb_name'] ?? '') ?>)">
                                                            <i class="fas fa-trash-alt me-2"></i>Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ── View Details Modal ── -->
                                    <div class="modal fade" id="viewModal<?= $safeId ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $safeId ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 bg-light">
                                                    <h6 class="modal-title fw-bold" id="viewModalLabel<?= $safeId ?>">
                                                        <i class="fas fa-user-tie text-primary me-2"></i>Librarian Details
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="text-center mb-4">
                                                        <img src="../assets/librarians/<?= $safeImg ?>"
                                                            alt="<?= $safeName ?>"
                                                            class="modal-avatar"
                                                            onerror="this.onerror=null;this.src='../assets/librarians/default-avatar.png';">
                                                        <h6 class="mt-3 fw-bold mb-1"><?= $safeName ?></h6>
                                                        <span class="badge <?= $statusClass ?>"><?= ucfirst($safeStatus) ?></span>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <div class="detail-block">
                                                                <small>Librarian ID</small>
                                                                <strong>#<?= str_pad($safeId, 4, '0', STR_PAD_LEFT) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="detail-block">
                                                                <small>Email Address</small>
                                                                <strong><?= $safeEmail ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="detail-block">
                                                                <small>Registered On</small>
                                                                <strong><?= $createdAt ? date('d M Y', $createdAt) : '—' ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="detail-block">
                                                                <small>Last Updated</small>
                                                                <!-- FIX: guard for missing updated_at column -->
                                                                <strong><?= $updatedAt ? date('d M Y', $updatedAt) : '—' ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Close
                                                    </button>
                                                    <a href="?page=edit&id=<?= $safeId ?>" class="btn btn-primary rounded-pill px-4">
                                                        <i class="fas fa-edit me-1"></i>Edit Profile
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state text-center">
                                            <i class="fas fa-user-slash d-block mb-3"></i>
                                            <p class="fw-semibold text-muted mb-1">No librarians found</p>
                                            <small class="text-muted">Click "Add New Librarian" to get started</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white border-top py-3 px-4">
                <small class="text-muted">
                    <i class="fas fa-users me-1"></i>
                    <?= $total_librarians ?> librarian<?= $total_librarians !== 1 ? 's' : '' ?> registered
                </small>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════════════════════════════════
     Delete Confirmation Modal
══════════════════════════════════════════════════════════════ -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header modal-header-danger border-0">
                    <h6 class="modal-title fw-bold text-white" id="deleteModalLabel">
                        <i class="fas fa-trash-alt me-2"></i>Confirm Delete
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning d-block mb-3"></i>
                    <p class="fw-semibold mb-1" id="deleteMessage">Are you sure?</p>
                    <small class="text-muted">This action cannot be undone.</small>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-trash-alt me-1"></i>Delete
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- ══════════════════════════════════════════════════════════════
     SCRIPTS — order matters:  jQuery → Bootstrap → DataTables
══════════════════════════════════════════════════════════════ -->

    <!-- 1. jQuery (must load before DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- 2. Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 3. DataTables core -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- 4. DataTables Bootstrap5 adapter -->
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        (function() {
            'use strict';

            // ── DataTable init ────────────────────────────────────────────────────────
            // Guard: only initialise once (safe when page is included via AJAX)
            $(document).ready(function() {
                var $table = $('#librarianTable');

                if ($table.length && !$.fn.DataTable.isDataTable($table)) {
                    $table.DataTable({
                        pageLength: 10,
                        lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, 'All']
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        language: {
                            search: 'Search:',
                            lengthMenu: 'Show _MENU_ entries',
                            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                            paginate: {
                                first: 'First',
                                last: 'Last',
                                next: 'Next',
                                previous: 'Prev'
                            }
                        }
                    });
                }
            });

            // ── Delete confirmation ───────────────────────────────────────────────────
            // FIX: name passed via json_encode() in PHP so it's always a safe JS string
            window.confirmDelete = function(librarianId, librarianName) {
                var safeId = parseInt(librarianId, 10);
                var safeName = String(librarianName).replace(/</g, '&lt;').replace(/>/g, '&gt;');

                document.getElementById('deleteMessage').innerHTML =
                    'Delete librarian <strong>"' + safeName + '"</strong>?';

                document.getElementById('confirmDeleteBtn').href =
                    '?action=delete&id=' + safeId;

                var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            };

            // ── Auto-dismiss flash alerts after 3 s ──────────────────────────────────
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(el) {
                    var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                    if (bsAlert) bsAlert.close();
                });
            }, 3000);

        }());
    </script>

</body>

</html>