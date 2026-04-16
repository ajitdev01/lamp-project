<div class="card mb-4 border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1" style="color: #1e293b;">
                    <i class="fas fa-book-open me-2 text-primary"></i>Book Requests Management
                </h5>
                <p class="text-muted small mb-0">Manage and track all student book requests</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#filterModal">
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
                        $counter = 1;
                        while ($data = mysqli_fetch_assoc($result)) {
                            // Status badge styling
                            $statusClass = '';
                            $statusIcon = '';
                            switch(strtolower($data['request_status'])) {
                                case 'pending':
                                    $statusClass = 'bg-warning text-dark';
                                    $statusIcon = 'fa-clock';
                                    break;
                                case 'approved':
                                    $statusClass = 'bg-success';
                                    $statusIcon = 'fa-check-circle';
                                    break;
                                case 'rejected':
                                    $statusClass = 'bg-danger';
                                    $statusIcon = 'fa-times-circle';
                                    break;
                                case 'returned':
                                    $statusClass = 'bg-info';
                                    $statusIcon = 'fa-undo-alt';
                                    break;
                                default:
                                    $statusClass = 'bg-secondary';
                                    $statusIcon = 'fa-question-circle';
                            }
                    ?>
                        <tr class="border-bottom">
                            <td class="px-3 py-3">
                                <span class="fw-semibold text-primary">#<?= $data['request_id'] ?></span>
                            </td>
                            <td class="px-3 py-3">
                                <div class="fw-semibold" style="color: #1e293b;"><?= htmlspecialchars($data['book_title']) ?></div>
                                <small class="text-muted"><?= htmlspecialchars($data['book_author']) ?></small>
                            </td>
                            <td class="px-3 py-3">
                                <div class="position-relative" style="width: 50px; height: 60px;">
                                    <img src="../assets/books/<?= $data['book_image'] ?>" 
                                         alt="<?= htmlspecialchars($data['book_title']) ?>" 
                                         class="rounded-3 shadow-sm"
                                         style="width: 50px; height: 60px; object-fit: cover;"
                                         onerror="this.src='../assets/books/default-book.jpg'">
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-calendar-alt text-muted small"></i>
                                    <span class="small fw-medium"><?= date('d M Y', strtotime($data['request_for_date'])) ?></span>
                                </div>
                                <?php 
                                $returnDate = strtotime($data['request_for_date']);
                                $today = time();
                                $daysLeft = ceil(($returnDate - $today) / (60 * 60 * 24));
                                if ($daysLeft > 0 && $daysLeft <= 3 && strtolower($data['request_status']) == 'approved'): ?>
                                    <small class="text-warning d-block mt-1">
                                        <i class="fas fa-exclamation-triangle"></i> Due in <?= $daysLeft ?> days
                                    </small>
                                <?php elseif ($daysLeft < 0 && strtolower($data['request_status']) == 'approved'): ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-hourglass-end"></i> Overdue
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td class="px-3 py-3">
                                <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 shadow-sm">
                                    <i class="fas <?= $statusIcon ?> me-1"></i>
                                    <?= htmlspecialchars($data['request_status']) ?>
                                </span>
                            </td>
                            <td class="px-3 py-3">
                                <div class="small fw-medium"><?= date('d M Y', strtotime($data['redate'])) ?></div>
                                <small class="text-muted"><?= date('h:i A', strtotime($data['redate'])) ?></small>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-pill px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                                        <li>
                                            <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#viewModal<?= $data['request_id'] ?>">
                                                <i class="fas fa-eye text-info me-2"></i> View Details
                                            </a>
                                        </li>
                                        <?php if(strtolower($data['request_status']) == 'pending'): ?>
                                    
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider"></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- View Details Modal -->
                        <div class="modal fade" id="viewModal<?= $data['request_id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0 shadow">
                                    <div class="modal-header border-0 bg-light">
                                        <h6 class="modal-title fw-bold">
                                            <i class="fas fa-info-circle text-primary me-2"></i>Request Details
                                        </h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <img src="../assets/books/<?= $data['book_image'] ?>" class="img-fluid rounded-3 shadow-sm" alt="">
                                            </div>
                                            <div class="col-8">
                                                <p><strong>Book:</strong> <?= htmlspecialchars($data['book_title']) ?></p>
                                                <p><strong>Student:</strong> <?= htmlspecialchars($data['st_name']) ?></p>
                                                <p><strong>Email:</strong> <?= htmlspecialchars($data['st_email']) ?></p>
                                                <p><strong>Return Date:</strong> <?= date('d M Y', strtotime($data['request_for_date'])) ?></p>
                                                <p><strong>Status:</strong> <span class="badge <?= $statusClass ?>"><?= $data['request_status'] ?></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                            $counter++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
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
                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
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
<div class="modal fade" id="filterModal" tabindex="-1">
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
                        <option>Returned</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Date Range</label>
                    <input type="text" class="form-control rounded-3" placeholder="Select date range">
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
    /* Table styling enhancements */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
        transition: all 0.2s ease;
    }
    
    /* Custom scrollbar for table */
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
    
    /* Badge animations */
    .badge {
        transition: all 0.2s ease;
    }
    
    /* Dropdown menu styling */
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
    
    /* Image hover effect */
    td img {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    td img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>

<script>
    // Delete confirmation function
    function confirmDelete(requestId) {
        if (confirm('Are you sure you want to delete this request? This action cannot be undone.')) {
            window.location.href = 'delete_request.php?id=' + requestId;
        }
    }
    
    // Optional: Initialize DataTable if needed
    // $(document).ready(function() {
    //     $('#datatablesSimple').DataTable();
    // });
</script>