<?php
$msg = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $ref = $_GET['ref'];
    $request_id = $_GET['rid'];
    if ($action == 'approve') {
        $aQry = "UPDATE issued_tbl SET isd_status = 'Returned' WHERE isd_id = $ref";

        if (mysqli_query($conn, $aQry)) {
            $rsQry = "UPDATE requests_tbl SET request_status = 'Returned' WHERE request_id = $request_id";
            mysqli_query($conn, $rsQry);
            echo $msg = '<div class="alert alert-success">Status Marked as Returned!</div>';
        } else {
            echo  $msg = '<div class="alert alert-danger">Failed!</div>';
        }
    }
}
?>
<div class="card mb-4 border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1" style="color: #1e293b;">
                    <i class="fas fa-book-reader me-2 text-primary"></i>Issued Books Management
                </h5>
                <p class="text-muted small mb-0">Track and manage all currently issued books to students</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#filterIssuedModal">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="datatablesSimple" style="width: 100%;">
                <thead class="bg-light">
                    <tr style="background: linear-gradient(135deg, #f8f9fc 0%, #f1f5f9 100%);">
                        <th class="px-3 py-3 fw-semibold text-secondary">#ID</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Book Title</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Cover</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Return Date</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Student Details</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Status</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Issued On</th>
                        <th class="px-3 py-3 fw-semibold text-secondary text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT 
                                i.*,
                                s.*,
                                b.*,
                                i.created_at AS redate
                                FROM issued_tbl i
                                JOIN students_tbl s ON s.st_id = i.isd_st_id
                                JOIN books_tbl b ON b.book_id = i.isd_book_id
                                ORDER BY i.created_at DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            // Status badge styling
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = $data['isd_status'];
                            switch (strtolower($data['isd_status'])) {
                                case 'issued':
                                    $statusClass = 'bg-primary';
                                    $statusIcon = 'fa-book-open';
                                    $statusText = 'Issued';
                                    break;
                                case 'returned':
                                    $statusClass = 'bg-success';
                                    $statusIcon = 'fa-check-circle';
                                    $statusText = 'Returned';
                                    break;
                                case 'overdue':
                                    $statusClass = 'bg-danger';
                                    $statusIcon = 'fa-exclamation-triangle';
                                    $statusText = 'Overdue';
                                    break;
                                case 'lost':
                                    $statusClass = 'bg-dark';
                                    $statusIcon = 'fa-times-circle';
                                    $statusText = 'Lost';
                                    break;
                                default:
                                    $statusClass = 'bg-secondary';
                                    $statusIcon = 'fa-question-circle';
                            }

                            // Calculate days remaining or overdue
                            $returnDate = strtotime($data['isd_return_date']);
                            $today = time();
                            $daysDiff = ceil(($returnDate - $today) / (60 * 60 * 24));

                            // Check if overdue
                            $isOverdue = false;
                            $overdueMessage = '';
                            if (strtolower($data['isd_status']) == 'issued') {
                                if ($daysDiff < 0) {
                                    $isOverdue = true;
                                    $overdueMessage = 'Overdue by ' . abs($daysDiff) . ' days';
                                    $statusClass = 'bg-danger';
                                    $statusIcon = 'fa-exclamation-triangle';
                                    $statusText = 'Overdue';
                                } elseif ($daysDiff == 0) {
                                    $overdueMessage = 'Last day to return';
                                } elseif ($daysDiff <= 3) {
                                    $overdueMessage = 'Due in ' . $daysDiff . ' days';
                                }
                            }
                    ?>
                            <tr class="border-bottom <?= $isOverdue ? 'table-danger' : '' ?>">
                                <td class="px-3 py-3">
                                    <span class="fw-semibold text-primary">#<?= str_pad($data['isd_id'], 5, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-semibold" style="color: #1e293b;"><?= htmlspecialchars($data['book_title']) ?></div>
                                    <small class="text-muted">by <?= htmlspecialchars($data['book_author']) ?></small>
                                    <div class="small text-muted mt-1">
                                        <i class="fas fa-barcode me-1"></i> ISBN: <?= htmlspecialchars($data['book_isbn']) ?>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="position-relative" style="width: 55px; height: 65px;">
                                        <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                            alt="<?= htmlspecialchars($data['book_title']) ?>"
                                            class="rounded-3 shadow-sm"
                                            style="width: 55px; height: 65px; object-fit: cover;"
                                            onerror="this.src='../assets/books/default-book.png'">
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-alt text-muted small"></i>
                                            <span class="small fw-medium"><?= date('d M Y', strtotime($data['isd_return_date'])) ?></span>
                                        </div>
                                        <?php if (strtolower($data['isd_status']) == 'issued'): ?>
                                            <?php if ($daysDiff < 0): ?>
                                                <small class="text-danger mt-1 fw-semibold">
                                                    <i class="fas fa-exclamation-circle me-1"></i> <?= $overdueMessage ?>
                                                </small>
                                            <?php elseif ($daysDiff == 0): ?>
                                                <small class="text-warning mt-1 fw-semibold">
                                                    <i class="fas fa-hourglass-end me-1"></i> <?= $overdueMessage ?>
                                                </small>
                                            <?php elseif ($daysDiff <= 3): ?>
                                                <small class="text-warning mt-1">
                                                    <i class="fas fa-hourglass-half me-1"></i> <?= $overdueMessage ?>
                                                </small>
                                            <?php else: ?>
                                                <small class="text-success mt-1">
                                                    <i class="fas fa-clock me-1"></i> <?= $daysDiff ?> days remaining
                                                </small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 45px; height: 45px;">
                                            <img src="../assets/students/<?= htmlspecialchars($data['st_image']) ?>"
                                                alt="<?= htmlspecialchars($data['st_name']) ?>"
                                                class="rounded-circle shadow-sm"
                                                style="width: 45px; height: 45px; object-fit: cover;"
                                                onerror="this.src='../assets/students/default-avatar.png'">
                                        </div>
                                        <div>
                                            <div class="fw-semibold small" style="color: #1e293b;"><?= htmlspecialchars($data['st_name']) ?></div>
                                            <small class="text-muted">ID: <?= $data['st_id'] ?></small><br>
                                            <small class="text-muted"><?= htmlspecialchars($data['st_email']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas <?= $statusIcon ?> me-1"></i>
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="small fw-medium"><?= date('d M Y', strtotime($data['redate'])) ?></div>
                                    <small class="text-muted"><?= date('h:i A', strtotime($data['redate'])) ?></small>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <?php if (strtolower($data['isd_status']) != 'returned'): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                                                <li>
                                                    <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#viewIssuedModal<?= $data['isd_id'] ?>">
                                                        <i class="fas fa-eye text-info me-2"></i> View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small text-success" href="#" onclick="confirmReturn(<?= $data['isd_id'] ?>, <?= $data['isd_request_id'] ?>)">
                                                        <i class="fas fa-undo-alt me-2"></i> Mark as Returned
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#extendModal<?= $data['isd_id'] ?>">
                                                        <i class="fas fa-calendar-plus text-warning me-2"></i> Extend Due Date
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">Completed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- View Issued Details Modal -->
                            <div class="modal fade" id="viewIssuedModal<?= $data['isd_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 bg-light">
                                            <h6 class="modal-title fw-bold">
                                                <i class="fas fa-info-circle text-primary me-2"></i>Issued Book Details
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-4 text-center">
                                                    <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                                        alt="<?= htmlspecialchars($data['book_title']) ?>"
                                                        class="img-fluid rounded-3 shadow-lg w-100"
                                                        style="max-height: 200px; object-fit: cover;"
                                                        onerror="this.src='../assets/books/default-book.png'">
                                                    <div class="mt-3">
                                                        <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2">
                                                            <i class="fas <?= $statusIcon ?> me-1"></i> <?= $statusText ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <h4 class="fw-bold mb-2"><?= htmlspecialchars($data['book_title']) ?></h4>
                                                    <p class="text-muted mb-3"><i class="fas fa-user-pen me-1"></i> by <?= htmlspecialchars($data['book_author']) ?></p>
                                                    <div class="bg-light rounded-3 p-3 mb-3">
                                                        <div class="d-flex align-items-center gap-3 mb-2">
                                                            <img src="../assets/students/<?= htmlspecialchars($data['st_image']) ?>"
                                                                class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;"
                                                                onerror="this.src='../assets/students/default-avatar.png'">
                                                            <div>
                                                                <strong><?= htmlspecialchars($data['st_name']) ?></strong><br>
                                                                <small class="text-muted"><?= htmlspecialchars($data['st_email']) ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Issue ID</small>
                                                                <strong>#<?= str_pad($data['isd_id'], 5, '0', STR_PAD_LEFT) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Return Date</small>
                                                                <strong><?= date('d M Y', strtotime($data['isd_return_date'])) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Issued On</small>
                                                                <strong><?= date('d M Y', strtotime($data['redate'])) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">ISBN</small>
                                                                <strong><?= htmlspecialchars($data['book_isbn']) ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                            <?php if (strtolower($data['isd_status']) != 'returned'): ?>
                                                <a href="#" onclick="confirmReturn(<?= $data['isd_id'] ?>, <?= $data['isd_request_id'] ?>)" class="btn btn-success rounded-pill px-4">
                                                    <i class="fas fa-undo-alt me-1"></i> Mark as Returned
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Extend Due Date Modal -->
                            <?php if (strtolower($data['isd_status']) != 'returned'): ?>
                                <div class="modal fade" id="extendModal<?= $data['isd_id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                                <h6 class="modal-title fw-bold text-white">
                                                    <i class="fas fa-calendar-plus me-2"></i>Extend Due Date
                                                </h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="" method="post">
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="isd_id" value="<?= $data['isd_id'] ?>">
                                                    <input type="hidden" name="request_id" value="<?= $data['isd_request_id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold small">Current Due Date</label>
                                                        <input type="text" class="form-control rounded-3 bg-light" value="<?= date('d M Y', strtotime($data['isd_return_date'])) ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold small">New Due Date</label>
                                                        <input type="date" name="new_due_date" class="form-control rounded-3"
                                                            min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                                            max="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
                                                        <small class="text-muted">Maximum extension: 30 days from today</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold small">Extension Reason</label>
                                                        <textarea name="reason" class="form-control rounded-3" rows="2" placeholder="Reason for extension (optional)"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="extend_due_date" class="btn btn-warning rounded-pill px-4">
                                                        <i class="fas fa-save me-1"></i> Extend Date
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No issued books found</p>
                                <small class="text-muted">Issued books will appear here</small>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="small text-muted">
                <i class="fas fa-chart-line me-1"></i> Showing <?= mysqli_num_rows($result) ?> issued records
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-chevron-left me-1"></i> Previous
                </button>
                <button class="btn btn-sm btn-primary rounded-pill px-3">
                    Next <i class="fas fa-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterIssuedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Issued Books</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status</label>
                    <select class="form-select rounded-3">
                        <option>All</option>
                        <option>Issued</option>
                        <option>Returned</option>
                        <option>Overdue</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Date Range</label>
                    <input type="text" class="form-control rounded-3" placeholder="Select date range">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Student Name</label>
                    <input type="text" class="form-control rounded-3" placeholder="Search by student">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Apply Filter</button>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.03);
        transition: all 0.2s ease;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .badge {
        transition: all 0.2s ease;
    }

    .dropdown-menu {
        animation: fadeInUp 0.2s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    td img {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    td img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .bg-success {
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .bg-danger {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .bg-primary {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
    }

    .bg-secondary {
        background: linear-gradient(135deg, #64748b, #94a3b8);
    }

    .table-danger {
        background-color: rgba(220, 38, 38, 0.05) !important;
    }
</style>

<script>
    function confirmReturn(issueId, requestId) {
        if (confirm('Are you sure you want to mark this book as returned? This action cannot be undone.')) {
            window.location.href = '?action=approve&ref=' + issueId + '&rid=' + requestId;
        }
    }
</script>