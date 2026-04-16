<?php
$msg = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $ref = $_GET['ref'];
    if ($action == 'reject') {
        $aQry = "UPDATE requests_tbl SET request_status = 'Rejected' WHERE request_id = $ref";

        if (mysqli_query($conn, $aQry)) {
            echo $msg = '<div class="alert alert-success">Status Marked as Rejected!</div>';
        } else {
            echo  $msg = '<div class="alert alert-danger">Failed!</div>';
        }
    }
    if ($action == 'queue') {
        $aQry = "UPDATE requests_tbl SET request_status = 'Queue' WHERE request_id = $ref";

        if (mysqli_query($conn, $aQry)) {
            echo $msg = '<div class="alert alert-success">Status Marked as Queue!</div>';
        } else {
            echo  $msg = '<div class="alert alert-danger">Failed!</div>';
        }
    }
    if ($action == 'approve') {

        $rfQry = "SELECT * FROm requests_tbl WHERE request_id=$ref";
        $rfResult = mysqli_query($conn, $rfQry);
        $rfdata = mysqli_fetch_assoc($rfResult);
        $rb_id = $rfdata['request_book_id'];
        $rst_id = $rfdata['request_st_id'];
        $rtdate = $rfdata['request_for_date'];

        $isuQry = "INSERT INTO issued_tbl(isd_request_id, isd_book_id, isd_st_id, isd_return_date, isd_status) VALUES ('$ref','$rb_id','$rst_id','$rtdate','Issued')";

        if (mysqli_query($conn, $isuQry)) {
            $aQry = "UPDATE requests_tbl SET request_status = 'Issued' WHERE request_id = $ref";

            if (mysqli_query($conn, $aQry)) {
                echo $msg = '<div class="alert alert-success">Status Marked as Issued!</div>';
            } else {
                echo  $msg = '<div class="alert alert-danger">Failed!</div>';
            }
        } else {
            echo "Issued Query Failed";
        }
    }
}
?>
<div class="card mb-4 border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1" style="color: #1e293b;">
                    <i class="fas fa-clipboard-list me-2 text-primary"></i>Book Requests Management
                </h5>
                <p class="text-muted small mb-0">Manage and track all student book requests</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#filterRequestsModal">
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
                        <th class="px-3 py-3 fw-semibold text-secondary">Requested On</th>
                        <th class="px-3 py-3 fw-semibold text-secondary text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT 
                                r.*,
                                s.*,
                                b.*,
                                r.created_at AS redate
                                FROM requests_tbl r
                                JOIN students_tbl s ON s.st_id = r.request_st_id
                                JOIN books_tbl b ON b.book_id = r.request_book_id
                                ORDER BY r.created_at DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            // Status badge styling
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = $data['request_status'];
                            switch (strtolower($data['request_status'])) {
                                case 'pending':
                                    $statusClass = 'bg-warning text-dark';
                                    $statusIcon = 'fa-clock';
                                    $statusText = 'Pending';
                                    break;
                                case 'approved':
                                case 'issued':
                                    $statusClass = 'bg-success';
                                    $statusIcon = 'fa-check-circle';
                                    $statusText = 'Approved';
                                    break;
                                case 'rejected':
                                    $statusClass = 'bg-danger';
                                    $statusIcon = 'fa-times-circle';
                                    $statusText = 'Rejected';
                                    break;
                                case 'queue':
                                    $statusClass = 'bg-info text-dark';
                                    $statusIcon = 'fa-hourglass-half';
                                    $statusText = 'In Queue';
                                    break;
                                default:
                                    $statusClass = 'bg-secondary';
                                    $statusIcon = 'fa-question-circle';
                            }

                            // Calculate days remaining
                            $returnDate = strtotime($data['request_for_date']);
                            $today = time();
                            $daysLeft = ceil(($returnDate - $today) / (60 * 60 * 24));
                    ?>
                            <tr class="border-bottom">
                                <td class="px-3 py-3">
                                    <span class="fw-semibold text-primary">#<?= str_pad($data['request_id'], 5, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-semibold" style="color: #1e293b;"><?= htmlspecialchars($data['book_title']) ?></div>
                                    <small class="text-muted">by <?= htmlspecialchars($data['book_author']) ?></small>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="position-relative" style="width: 50px; height: 60px;">
                                        <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                            alt="<?= htmlspecialchars($data['book_title']) ?>"
                                            class="rounded-3 shadow-sm"
                                            style="width: 50px; height: 60px; object-fit: cover;"
                                            onerror="this.src='../assets/books/default-book.png'">
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-alt text-muted small"></i>
                                            <span class="small fw-medium"><?= date('d M Y', strtotime($data['request_for_date'])) ?></span>
                                        </div>
                                        <?php if (strtolower($data['request_status']) == 'approved' || strtolower($data['request_status']) == 'issued'): ?>
                                            <?php if ($daysLeft >= 0 && $daysLeft <= 3): ?>
                                                <small class="text-warning mt-1">
                                                    <i class="fas fa-hourglass-half"></i> Due in <?= $daysLeft ?> days
                                                </small>
                                            <?php elseif ($daysLeft < 0): ?>
                                                <small class="text-danger mt-1">
                                                    <i class="fas fa-exclamation-circle"></i> Overdue by <?= abs($daysLeft) ?> days
                                                </small>
                                            <?php else: ?>
                                                <small class="text-success mt-1">
                                                    <i class="fas fa-clock"></i> <?= $daysLeft ?> days left
                                                </small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px;">
                                            <img src="../assets/students/<?= htmlspecialchars($data['st_image']) ?>"
                                                alt="<?= htmlspecialchars($data['st_name']) ?>"
                                                class="rounded-circle shadow-sm"
                                                style="width: 40px; height: 40px; object-fit: cover;"
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
                                    <?php if ($data['request_status'] != 'Issued' && $data['request_status'] != 'Rejected'): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                                                <li>
                                                    <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#viewRequestModal<?= $data['request_id'] ?>">
                                                        <i class="fas fa-eye text-info me-2"></i> View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="?action=approve&ref=<?= $data['request_id'] ?>">
                                                        <i class="fas fa-check-circle text-success me-2"></i> Approve Request
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small <?= $data['request_status'] == 'Queue' ? 'disabled' : '' ?>"
                                                        href="?action=queue&ref=<?= $data['request_id'] ?>">
                                                        <i class="fas fa-hourglass-half text-info me-2"></i> Add to Queue
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small text-danger" href="#" onclick="confirmReject(<?= $data['request_id'] ?>)">
                                                        <i class="fas fa-times-circle me-2"></i> Reject Request
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">No actions</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- View Request Details Modal -->
                            <div class="modal fade" id="viewRequestModal<?= $data['request_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 bg-light">
                                            <h6 class="modal-title fw-bold">
                                                <i class="fas fa-clipboard-list text-primary me-2"></i>Request Details
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-5 text-center">
                                                    <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                                        alt="<?= htmlspecialchars($data['book_title']) ?>"
                                                        class="img-fluid rounded-3 shadow-lg"
                                                        style="max-height: 200px; object-fit: cover;"
                                                        onerror="this.src='../assets/books/default-book.png'">
                                                    <div class="mt-3">
                                                        <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2">
                                                            <i class="fas <?= $statusIcon ?> me-1"></i> <?= $statusText ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
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
                                                                <small class="text-muted d-block">Request ID</small>
                                                                <strong>#<?= str_pad($data['request_id'], 5, '0', STR_PAD_LEFT) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Return Date</small>
                                                                <strong><?= date('d M Y', strtotime($data['request_for_date'])) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Requested On</small>
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
                                            <?php if ($data['request_status'] != 'Issued' && $data['request_status'] != 'Rejected'): ?>
                                                <a href="?action=approve&ref=<?= $data['request_id'] ?>" class="btn btn-success rounded-pill px-4">
                                                    <i class="fas fa-check-circle me-1"></i> Approve
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No requests found</p>
                                <small class="text-muted">New requests will appear here</small>
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
                <i class="fas fa-chart-line me-1"></i> Showing <?= mysqli_num_rows($result) ?> requests
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
<div class="modal fade" id="filterRequestsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Requests</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status</label>
                    <select class="form-select rounded-3">
                        <option>All</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                        <option>In Queue</option>
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

    .bg-warning {
        background: linear-gradient(135deg, #d97706, #f59e0b);
    }

    .bg-info {
        background: linear-gradient(135deg, #0891b2, #06b6d4);
    }
</style>

<script>
    function confirmReject(requestId) {
        if (confirm('Are you sure you want to reject this request?')) {
            window.location.href = '?action=reject&ref=' + requestId;
        }
    }
</script>