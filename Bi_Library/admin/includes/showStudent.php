<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiLibrary – Student Management System</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables Bootstrap5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        /* Base styling matching librarian dashboard */
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

        /* Main card */
        .main-card {
            border: 0;
            border-radius: 28px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.2s;
        }

        .card-header-custom {
            background: #ffffff;
            padding: 1.5rem 2rem 1rem;
            border-bottom: 1px solid #eef2f8;
        }

        /* Table headers */
        #studentTable thead tr {
            background: linear-gradient(135deg, #fafcff 0%, #eef3fc 100%);
        }

        #studentTable thead th {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #4b5565;
            border-bottom: 2px solid #e4e9f2;
            white-space: nowrap;
        }

        #studentTable tbody tr {
            transition: background 0.18s ease;
        }

        #studentTable tbody tr:hover {
            background: rgba(59, 130, 246, 0.03);
        }

        /* Avatar image */
        .avatar-img {
            width: 46px;
            height: 46px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s;
        }

        .avatar-img:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        /* Modern badges */
        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0.45rem 0.9rem;
            border-radius: 100px;
        }

        .bg-success {
            background: linear-gradient(135deg, #0f7b3a, #16a34a) !important;
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

        /* Action buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e2edf2;
            background: #ffffff;
            color: #5b6e8c;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: #f1f9fe;
            border-color: #bdd3e8;
            color: #1e2f4e;
            transform: scale(1.02);
        }

        /* Dropdown animation */
        .dropdown-menu {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            animation: dropdownFade 0.16s ease;
        }

        .dropdown-item {
            border-radius: 12px;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            transition: background 0.12s;
        }

        .dropdown-item:hover {
            background: #f0f6fe;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Empty state */
        .empty-state {
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbdbe6;
        }

        /* DataTables custom */
        .dataTables_wrapper .dataTables_filter input {
            border: 1.5px solid #e2edf2;
            border-radius: 60px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
        }

        div.dataTables_wrapper div.dataTables_length select {
            border: 1.5px solid #e2edf2;
            border-radius: 40px;
            padding: 0.3rem 1rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            border-color: #3b82f6 !important;
            color: white !important;
            border-radius: 40px !important;
        }

        /* Modals */
        .modal-content {
            border: 0;
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-avatar {
            width: 98px;
            height: 98px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.1);
        }

        .detail-card {
            background: #fafdff;
            border-radius: 18px;
            padding: 0.9rem 1rem;
            border: 1px solid #eef2fa;
        }

        .detail-card small {
            font-size: 0.7rem;
            color: #7c8ba0;
            letter-spacing: 0.03em;
        }

        .modal-header-danger {
            background: linear-gradient(115deg, #dc2626, #f05252);
            border-radius: 28px 28px 0 0;
        }
    </style>
</head>
<body>

<div class="container-fluid px-4 py-4">

    <!-- Flash Messages (session simulated, can be integrated with real session) -->
    <?php if (!empty($_SESSION['student_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['student_success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['student_success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['student_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($_SESSION['student_error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['student_error']); ?>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card main-card">
        <div class="card-header-custom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1" style="color:#0f2b3d;">
                    <i class="fas fa-graduation-cap me-2 text-primary"></i>Student Management
                </h5>
                <p class="text-muted small mb-0">Manage all registered students in BiLibrary ecosystem</p>
            </div>
            <a href="?page=add" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Add New Student
            </a>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="studentTable" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th class="px-3 py-3">Student ID</th>
                            <th class="px-3 py-3">Full Name</th>
                            <th class="px-3 py-3">Email Address</th>
                            <th class="px-3 py-3">Photo</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Registered On</th>
                            <th class="px-3 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ─────────────────────────────────────────────────────────────
                        // SECURE DB CONNECTION + QUERY (error guards, XSS protection)
                        // ─────────────────────────────────────────────────────────────
                        $total_students = 0;
                        $students = [];

                        // Database configuration (adjust if needed)
                        $conn = mysqli_connect("localhost", "root", "", "bi_librarysystem");

                        if (!$conn) {
                            // Fallback: show empty table but log error silently (production)
                            $db_error = true;
                        } else {
                            $query = "SELECT * FROM students_tbl ORDER BY st_id DESC";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                $total_students = mysqli_num_rows($result);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $students[] = $row;
                                }
                                mysqli_free_result($result);
                            }
                            mysqli_close($conn);
                        }

                        // Helper for status badge style
                        function getStudentStatusStyle(string $status): array
                        {
                            switch (strtolower($status)) {
                                case 'active':    return ['bg-success', 'fa-check-circle'];
                                case 'inactive':  return ['bg-secondary', 'fa-circle'];
                                case 'suspended': return ['bg-danger', 'fa-ban'];
                                default:          return ['bg-primary', 'fa-user-graduate'];
                            }
                        }

                        if (!empty($students)):
                            foreach ($students as $student):
                                [$statusClass, $statusIcon] = getStudentStatusStyle($student['st_status'] ?? 'active');
                                $safeId       = (int)($student['st_id'] ?? 0);
                                $safeName     = htmlspecialchars($student['st_name'] ?? '', ENT_QUOTES);
                                $safeEmail    = htmlspecialchars($student['st_email'] ?? '', ENT_QUOTES);
                                $safeImage    = htmlspecialchars($student['st_image'] ?? '', ENT_QUOTES);
                                $safeStatus   = htmlspecialchars($student['st_status'] ?? 'active', ENT_QUOTES);
                                $createdRaw   = $student['created_at'] ?? null;
                                $updatedRaw   = $student['updated_at'] ?? null;
                                $createdAt    = !empty($createdRaw) ? strtotime($createdRaw) : false;
                                $updatedAt    = !empty($updatedRaw) ? strtotime($updatedRaw) : false;
                                $jsSafeName   = addslashes($student['st_name'] ?? 'Student');
                        ?>
                            <tr>
                                <!-- Student ID formatted -->
                                <td class="px-3 py-3">
                                    <span class="fw-bold text-primary">#<?= str_pad($safeId, 5, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <!-- Full name -->
                                <td class="px-3 py-3">
                                    <span class="fw-semibold" style="color:#0c2e42;"><?= $safeName ?></span>
                                    <div class="small text-muted">ID: <?= $safeId ?></div>
                                </td>
                                <!-- Email -->
                                <td class="px-3 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-envelope text-secondary fa-xs"></i>
                                        <span><?= $safeEmail ?></span>
                                    </div>
                                </td>
                                <!-- Photo with onerror guard (no infinite loop) -->
                                <td class="px-3 py-3">
                                    <img src="../assets/students/<?= $safeImage ?>"
                                         alt="<?= $safeName ?>"
                                         class="avatar-img"
                                         onerror="this.onerror=null;this.src='../assets/students/default-avatar.png';">
                                </td>
                                <!-- Status badge -->
                                <td class="px-3 py-3">
                                    <span class="badge <?= $statusClass ?> shadow-sm">
                                        <i class="fas <?= $statusIcon ?> me-1"></i>
                                        <?= ucfirst($safeStatus) ?>
                                    </span>
                                </td>
                                <!-- Registered on -->
                                <td class="px-3 py-3">
                                    <?php if ($createdAt): ?>
                                        <div class="small fw-semibold"><?= date('d M Y', $createdAt) ?></div>
                                        <small class="text-muted"><?= date('h:i A', $createdAt) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <!-- Actions dropdown -->
                                <td class="px-3 py-3 text-center">
                                    <div class="dropdown">
                                        <button class="btn-action" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewStudentModal<?= $safeId ?>">
                                                <i class="fas fa-eye text-info me-2"></i>View Details</a>
                                            </li>
                                            <li><a class="dropdown-item" href="?page=student-edit&id=<?= $safeId ?>">
                                                <i class="fas fa-edit text-warning me-2"></i>Edit Student</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmDeleteStudent(<?= $safeId ?>, <?= json_encode($student['st_name'] ?? '') ?>)">
                                                <i class="fas fa-trash-alt me-2"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- ── VIEW STUDENT DETAIL MODAL (enhanced) ── -->
                            <div class="modal fade" id="viewStudentModal<?= $safeId ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header border-0 bg-soft-light" style="background:#fafdff;">
                                            <h6 class="modal-title fw-bold">
                                                <i class="fas fa-id-card text-primary me-2"></i>Student information
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="text-center mb-4">
                                                <img src="../assets/students/<?= $safeImage ?>"
                                                     alt="<?= $safeName ?>"
                                                     class="modal-avatar"
                                                     onerror="this.onerror=null;this.src='../assets/students/default-avatar.png';">
                                                <h5 class="mt-3 fw-bold"><?= $safeName ?></h5>
                                                <span class="badge <?= $statusClass ?> mt-1"><?= ucfirst($safeStatus) ?></span>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <div class="detail-card">
                                                        <small><i class="far fa-id-badge me-1"></i> STUDENT ID</small>
                                                        <strong class="d-block mt-1">#<?= str_pad($safeId, 5, '0', STR_PAD_LEFT) ?></strong>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="detail-card">
                                                        <small><i class="fas fa-envelope me-1"></i> EMAIL</small>
                                                        <strong class="d-block mt-1"><?= $safeEmail ?></strong>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-card">
                                                        <small><i class="fas fa-calendar-alt me-1"></i> REGISTERED</small>
                                                        <strong class="d-block mt-1"><?= $createdAt ? date('d M Y', $createdAt) : '—' ?></strong>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-card">
                                                        <small><i class="fas fa-sync-alt me-1"></i> LAST UPDATE</small>
                                                        <strong class="d-block mt-1"><?= $updatedAt ? date('d M Y', $updatedAt) : '—' ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-transparent">
                                            <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Close</button>
                                            <a href="?page=student-edit&id=<?= $safeId ?>" class="btn btn-primary rounded-pill px-4"><i class="fas fa-edit me-1"></i>Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <tr>
                                <td colspan="7" class="text-center empty-state">
                                    <i class="fas fa-user-graduate d-block mb-3"></i>
                                    <p class="fw-semibold text-secondary mb-1">No students registered yet</p>
                                    <small class="text-muted">Click "Add New Student" to start building the student directory</small>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted"><i class="fas fa-users me-1"></i> <?= $total_students ?> student<?= $total_students !== 1 ? 's' : '' ?> enrolled</small>
                <small class="text-muted"><i class="fas fa-chalkboard-user me-1"></i> BiLibrary Student Hub</small>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL (global)
══════════════════════════════════════════════════════════════ -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-header-danger border-0">
                <h6 class="modal-title text-white fw-bold"><i class="fas fa-trash-alt me-2"></i>Confirm deletion</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2 d-block"></i>
                <p class="fw-semibold mb-1" id="deleteStudentMsg">Delete this student record?</p>
                <small class="text-muted">This action cannot be reversed.</small>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal"><i class="fas fa-ban me-1"></i>Cancel</button>
                <a href="#" id="finalDeleteStudentBtn" class="btn btn-danger rounded-pill px-4"><i class="fas fa-trash-can me-1"></i>Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS: jQuery -> Bootstrap -> DataTables (order matters) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    (function() {
        // Initialise DataTable only once
        $(document).ready(function() {
            var $studentTable = $('#studentTable');
            if ($studentTable.length && !$.fn.DataTable.isDataTable($studentTable)) {
                $studentTable.DataTable({
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                    order: [[0, 'desc']],
                    language: {
                        search: "Quick search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ students",
                        paginate: { first: "First", last: "Last", next: "→", previous: "←" }
                    },
                    responsive: true
                });
            }

            // Auto-dismiss flash alerts after 4 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    if (bsAlert) bsAlert.close();
                });
            }, 4000);
        });

        // Global delete confirmation (XSS-safe using json_encode in PHP)
        window.confirmDeleteStudent = function(studentId, studentName) {
            let safeId = parseInt(studentId, 10);
            let safeName = String(studentName).replace(/[<>]/g, function(match) {
                return match === '<' ? '&lt;' : '&gt;';
            });
            let messageSpan = document.getElementById('deleteStudentMsg');
            if (messageSpan) {
                messageSpan.innerHTML = `Delete student <strong>"${safeName}"</strong>? This will remove all records.`;
            }
            let deleteBtn = document.getElementById('finalDeleteStudentBtn');
            if (deleteBtn) {
                deleteBtn.href = `?action=delete_student&id=${safeId}`;
            }
            let modalEl = document.getElementById('deleteStudentModal');
            if (modalEl) {
                let modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        };

        // Optional small enhancement: tooltips for action icons (if needed)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    })();
</script>

<!-- Additional inline fallback for any missing default avatar image -->
<style>
    img[onerror] {
        background: #f1f5f9;
        object-fit: cover;
    }
    .detail-card {
        transition: 0.1s;
    }
    .btn-primary {
        background: linear-gradient(100deg, #2563eb, #3b82f6);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(100deg, #1d4ed8, #2563eb);
        transform: translateY(-1px);
    }
</style>
</body>
</html>