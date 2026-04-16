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
                <button class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Export
                </button>
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#filterIssuedModal">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addIssuedModal">
                    <i class="fas fa-plus-circle me-1"></i> New Issue
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
                        <th class="px-3 py-3 fw-semibold text-secondary">Student</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Return Date</th>
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
                            switch (strtolower($data['isd_status'])) {
                                case 'issued':
                                    $statusClass = 'bg-primary';
                                    $statusIcon = 'fa-book-open';
                                    break;
                                case 'returned':
                                    $statusClass = 'bg-success';
                                    $statusIcon = 'fa-check-circle';
                                    break;
                                case 'overdue':
                                    $statusClass = 'bg-danger';
                                    $statusIcon = 'fa-exclamation-triangle';
                                    break;
                                case 'lost':
                                    $statusClass = 'bg-dark';
                                    $statusIcon = 'fa-times-circle';
                                    break;
                                default:
                                    $statusClass = 'bg-secondary';
                                    $statusIcon = 'fa-question-circle';
                            }

                            // Calculate days remaining or overdue
                            $returnDate = strtotime($data['isd_return_date']);
                            $today = time();
                            $daysDiff = ceil(($returnDate - $today) / (60 * 60 * 24));

                            // Update status to overdue if needed (optional logic)
                            if ($daysDiff < 0 && strtolower($data['isd_status']) == 'issued') {
                                $statusClass = 'bg-danger';
                                $statusIcon = 'fa-exclamation-triangle';
                                $data['isd_status'] = 'Overdue';
                            }
                    ?>
                            <tr class="border-bottom">
                                <td class="px-3 py-3">
                                    <span class="fw-semibold text-primary">#<?= $data['isd_id'] ?></span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-semibold" style="color: #1e293b;"><?= htmlspecialchars($data['book_title']) ?></div>
                                    <small class="text-muted">by <?= htmlspecialchars($data['book_author']) ?></small>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="position-relative" style="width: 55px; height: 65px;">
                                        <img src="../assets/books/<?= $data['book_image'] ?>"
                                            alt="<?= htmlspecialchars($data['book_title']) ?>"
                                            class="rounded-3 shadow-sm"
                                            style="width: 55px; height: 65px; object-fit: cover;"
                                            onerror="this.src='../assets/books/default-book.jpg'">
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-semibold small" style="color: #1e293b;"><?= htmlspecialchars($data['st_name']) ?></div>
                                    <small class="text-muted d-flex align-items-center gap-1">
                                        <i class="fas fa-envelope fa-xs"></i> <?= htmlspecialchars($data['st_email']) ?>
                                    </small>
                                    <small class="text-muted d-flex align-items-center gap-1">
                                        <i class="fas fa-id-card fa-xs"></i> ID: <?= $data['st_id'] ?>
                                    </small>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-calendar-alt text-muted small"></i>
                                            <span class="small fw-medium"><?= date('d M Y', strtotime($data['isd_return_date'])) ?></span>
                                        </div>
                                        <?php if (strtolower($data['isd_status']) == 'issued'): ?>
                                            <?php if ($daysDiff >= 0 && $daysDiff <= 3): ?>
                                                <small class="text-warning mt-1">
                                                    <i class="fas fa-hourglass-half"></i> Due in <?= $daysDiff ?> days
                                                </small>
                                            <?php elseif ($daysDiff < 0): ?>
                                                <small class="text-danger mt-1">
                                                    <i class="fas fa-exclamation-circle"></i> Overdue by <?= abs($daysDiff) ?> days
                                                </small>
                                            <?php else: ?>
                                                <small class="text-success mt-1">
                                                    <i class="fas fa-clock"></i> <?= $daysDiff ?> days left
                                                </small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas <?= $statusIcon ?> me-1"></i>
                                        <?= ucfirst(htmlspecialchars($data['isd_status'])) ?>
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="small fw-medium"><?= date('d M Y', strtotime($data['redate'])) ?></div>
                                    <small class="text-muted"><?= date('h:i A', strtotime($data['redate'])) ?></small>
                                </td>
                                <td class="px-3 py-3 text-center">
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
                                            <?php if (strtolower($data['isd_status']) == 'issued'): ?>
                                                <li>
                                                    <a class="dropdown-item small" href="return_book.php?id=<?= $data['isd_id'] ?>&book_id=<?= $data['isd_book_id'] ?>">
                                                        <i class="fas fa-undo-alt text-success me-2"></i> Return Book
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#extendModal<?= $data['isd_id'] ?>">
                                                        <i class="fas fa-calendar-plus text-warning me-2"></i> Extend Due Date
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item small text-danger" href="#" onclick="confirmDeleteIssued(<?= $data['isd_id'] ?>)">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete Record
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Details Modal -->
                            <div class="modal fade" id="viewIssuedModal<?= $data['isd_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 bg-light">
                                            <h6 class="modal-title fw-bold">
                                                <i class="fas fa-info-circle text-primary me-2"></i>Issued Book Details
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <img src="../assets/books/<?= $data['book_image'] ?>" class="img-fluid rounded-3 shadow-sm w-100" alt="">
                                                </div>
                                                <div class="col-8">
                                                    <p><strong>Book:</strong> <?= htmlspecialchars($data['book_title']) ?></p>
                                                    <p><strong>Author:</strong> <?= htmlspecialchars($data['book_author']) ?></p>
                                                    <p><strong>Student:</strong> <?= htmlspecialchars($data['st_name']) ?></p>
                                                    <p><strong>Email:</strong> <?= htmlspecialchars($data['st_email']) ?></p>
                                                    <p><strong>Issued Date:</strong> <?= date('d M Y', strtotime($data['redate'])) ?></p>
                                                    <p><strong>Return Date:</strong> <?= date('d M Y', strtotime($data['isd_return_date'])) ?></p>
                                                    <p><strong>Status:</strong> <span class="badge <?= $statusClass ?>"><?= $data['isd_status'] ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                            <?php if (strtolower($data['isd_status']) == 'issued'): ?>
                                                <a href="return_book.php?id=<?= $data['isd_id'] ?>&book_id=<?= $data['isd_book_id'] ?>" class="btn btn-success rounded-pill px-4">
                                                    <i class="fas fa-undo-alt me-1"></i> Return Book
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Extend Due Date Modal -->
                            <?php if (strtolower($data['isd_status']) == 'issued'): ?>
                                <div class="modal fade" id="extendModal<?= $data['isd_id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-0">
                                                <h6 class="modal-title fw-bold">
                                                    <i class="fas fa-calendar-plus text-warning me-2"></i>Extend Due Date
                                                </h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="extend_due_date.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="isd_id" value="<?= $data['isd_id'] ?>">
                                                    <input type="hidden" name="book_id" value="<?= $data['isd_book_id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Current Due Date</label>
                                                        <input type="text" class="form-control rounded-3" value="<?= date('d M Y', strtotime($data['isd_return_date'])) ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">New Due Date</label>
                                                        <input type="date" name="new_due_date" class="form-control rounded-3" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                                                        <small class="text-muted">Maximum extension: 14 days</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-warning rounded-pill px-4">Extend Date</button>
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
                                <small class="text-muted">Click "New Issue" to lend a book to a student</small>
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
                        <option>Lost</option>
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

<!-- Add New Issue Modal -->
<div class="modal fade" id="addIssuedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 bg-primary text-white">
                <h6 class="modal-title fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Issue New Book
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="add_issued.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Select Student</label>
                        <select name="student_id" class="form-select rounded-3" required>
                            <option value="">Choose student...</option>
                            <?php
                            $studentsQuery = "SELECT st_id, st_name, st_email FROM students_tbl ORDER BY st_name";
                            $studentsResult = mysqli_query($conn, $studentsQuery);
                            while ($student = mysqli_fetch_assoc($studentsResult)) {
                                echo "<option value='{$student['st_id']}'>{$student['st_name']} ({$student['st_email']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Select Book</label>
                        <select name="book_id" class="form-select rounded-3" required>
                            <option value="">Choose book...</option>
                            <?php
                            $booksQuery = "SELECT book_id, book_title, book_author, book_instock FROM books_tbl WHERE book_instock > 0 ORDER BY book_title";
                            $booksResult = mysqli_query($conn, $booksQuery);
                            while ($book = mysqli_fetch_assoc($booksResult)) {
                                echo "<option value='{$book['book_id']}'>{$book['book_title']} by {$book['book_author']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Return Date</label>
                        <input type="date" name="return_date" class="form-control rounded-3" min="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                        <small class="text-muted">Standard lending period: 14 days</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Issue Book</button>
                </div>
            </form>
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Status-specific styles */
    .bg-danger {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .bg-success {
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .bg-primary {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
    }
</style>

<script>
    // Delete confirmation function
    function confirmDeleteIssued(issuedId) {
        if (confirm('Are you sure you want to delete this issued record? This action cannot be undone and may affect inventory tracking.')) {
            window.location.href = 'delete_issued.php?id=' + issuedId;
        }
    }
</script>