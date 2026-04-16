<div class="card mb-4 border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold mb-1" style="color: #1e293b;">
                    <i class="fas fa-book me-2 text-primary"></i>Book Collection Management
                </h5>
                <p class="text-muted small mb-0">Manage all books in the library catalog</p>
            </div>
            <a href="?page=add" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Add New Book
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="datatablesSimple" style="width: 100%;">
                <thead class="bg-light">
                    <tr style="background: linear-gradient(135deg, #f8f9fc 0%, #f1f5f9 100%);">
                        <th class="px-3 py-3 fw-semibold text-secondary">#ID</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Book Title</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Author</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Cover</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Details</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Status</th>
                        <th class="px-3 py-3 fw-semibold text-secondary">Added On</th>
                        <th class="px-3 py-3 fw-semibold text-secondary text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM books_tbl ORDER BY book_id DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            $statusClass = $data['book_instock'] == 1 ? 'bg-success' : 'bg-danger';
                            $statusText = $data['book_instock'] == 1 ? 'In Stock' : 'Out of Stock';
                            $statusIcon = $data['book_instock'] == 1 ? 'fa-check-circle' : 'fa-times-circle';
                    ?>
                            <tr class="border-bottom">
                                <td class="px-3 py-3">
                                    <span class="fw-semibold text-primary">#<?= str_pad($data['book_id'], 4, '0', STR_PAD_LEFT) ?></span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="fw-semibold" style="color: #1e293b;"><?= htmlspecialchars($data['book_title']) ?></div>
                                    <small class="text-muted">ISBN: <?= htmlspecialchars($data['book_isbn']) ?></small>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-user-pen text-muted small"></i>
                                        <span><?= htmlspecialchars($data['book_author']) ?></span>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="position-relative" style="width: 60px; height: 75px;">
                                        <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                            alt="<?= htmlspecialchars($data['book_title']) ?>"
                                            class="rounded-3 shadow-sm"
                                            style="width: 60px; height: 75px; object-fit: cover;"
                                            onerror="this.src='../assets/books/default-book.png'">
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-light text-dark rounded-pill px-2 py-1">
                                            <i class="fas fa-arrows-rotate me-1"></i> <?= htmlspecialchars($data['book_edition']) ?>
                                        </span>
                                        <span class="badge bg-light text-dark rounded-pill px-2 py-1">
                                            <i class="fas fa-calendar me-1"></i> <?= htmlspecialchars($data['book_pyear']) ?>
                                        </span>
                                        <span class="badge bg-light text-dark rounded-pill px-2 py-1">
                                            <i class="fas fa-book-open me-1"></i> <?= htmlspecialchars($data['book_pages']) ?> pg
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fas <?= $statusIcon ?> me-1"></i>
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="small fw-medium"><?= date('d M Y', strtotime($data['created_at'])) ?></div>
                                    <small class="text-muted"><?= date('h:i A', strtotime($data['created_at'])) ?></small>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow-sm border-0 rounded-3">
                                            <li>
                                                <a class="dropdown-item small" href="#" data-bs-toggle="modal" data-bs-target="#viewBookModal<?= $data['book_id'] ?>">
                                                    <i class="fas fa-eye text-info me-2"></i> View Details
                                                </a>
                                            </li>
                                            <li>
                                                <!-- FIXED: Call editBook function instead of page redirect -->
                                                <a class="dropdown-item small" href="javascript:void(0)" onclick="editBook(
                                                    <?= $data['book_id'] ?>,
                                                    '<?= addslashes(htmlspecialchars($data['book_title'])) ?>',
                                                    '<?= addslashes(htmlspecialchars($data['book_author'])) ?>',
                                                    '<?= addslashes(htmlspecialchars($data['book_isbn'])) ?>',
                                                    '<?= addslashes(htmlspecialchars($data['book_edition'])) ?>',
                                                    <?= $data['book_pyear'] ?>,
                                                    <?= $data['book_pages'] ?>,
                                                    <?= $data['book_instock'] ?>
                                                )">
                                                    <i class="fas fa-edit text-warning me-2"></i> Edit Book
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item small text-danger" href="#" onclick="confirmDelete(<?= $data['book_id'] ?>, '<?= addslashes(htmlspecialchars($data['book_title'])) ?>')">
                                                    <i class="fas fa-trash-alt me-2"></i> Delete Book
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Book Details Modal -->
                            <div class="modal fade" id="viewBookModal<?= $data['book_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-0 bg-light">
                                            <h6 class="modal-title fw-bold">
                                                <i class="fas fa-book-open text-primary me-2"></i>Book Details
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-4 text-center">
                                                    <img src="../assets/books/<?= htmlspecialchars($data['book_image']) ?>"
                                                        alt="<?= htmlspecialchars($data['book_title']) ?>"
                                                        class="img-fluid rounded-3 shadow-lg"
                                                        style="max-height: 250px; object-fit: cover;"
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
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">ISBN Number</small>
                                                                <strong><?= htmlspecialchars($data['book_isbn']) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Edition</small>
                                                                <strong><?= htmlspecialchars($data['book_edition']) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Publishing Year</small>
                                                                <strong><?= htmlspecialchars($data['book_pyear']) ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Page Count</small>
                                                                <strong><?= htmlspecialchars($data['book_pages']) ?> pages</strong>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="bg-light rounded-3 p-2">
                                                                <small class="text-muted d-block">Added to Library</small>
                                                                <strong><?= date('d F Y, h:i A', strtotime($data['created_at'])) ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                            <a href="javascript:void(0)" onclick="editBook(
                                                <?= $data['book_id'] ?>,
                                                '<?= addslashes(htmlspecialchars($data['book_title'])) ?>',
                                                '<?= addslashes(htmlspecialchars($data['book_author'])) ?>',
                                                '<?= addslashes(htmlspecialchars($data['book_isbn'])) ?>',
                                                '<?= addslashes(htmlspecialchars($data['book_edition'])) ?>',
                                                <?= $data['book_pyear'] ?>,
                                                <?= $data['book_pages'] ?>,
                                                <?= $data['book_instock'] ?>
                                            )" class="btn btn-primary rounded-pill px-4">
                                                <i class="fas fa-edit me-1"></i> Edit Book
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No books found in the library</p>
                                <small class="text-muted">Click "Add New Book" to add your first book</small>
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
                <i class="fas fa-chart-line me-1"></i> Showing <?= mysqli_num_rows($result) ?> books in catalog
            </div>
        </div>
    </div>
</div>

<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                <h6 class="modal-title fw-bold text-white">
                    <i class="fas fa-edit me-2"></i>Edit Book Details
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" name="book_id" id="edit_book_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Book Title</label>
                            <input type="text" name="book_title" id="edit_book_title" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Author Name</label>
                            <input type="text" name="book_author" id="edit_book_author" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">ISBN</label>
                            <input type="text" name="book_isbn" id="edit_book_isbn" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Edition</label>
                            <input type="text" name="book_edition" id="edit_book_edition" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Publishing Year</label>
                            <input type="number" name="book_pyear" id="edit_book_pyear" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Pages</label>
                            <input type="number" name="book_pages" id="edit_book_pages" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Stock Status</label>
                            <select name="book_instock" id="edit_book_instock" class="form-select rounded-3">
                                <option value="1">In Stock</option>
                                <option value="0">Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Change Image (optional)</label>
                            <input type="file" name="book_image" class="form-control rounded-3" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_book" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> Update Book
                    </button>
                </div>
            </form>
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
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }
</style>

<script>
    function confirmDelete(bookId, bookTitle) {
        if (confirm(`Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`)) {
            window.location.href = `?page=delete&id=${bookId}`;
        }
    }

    function editBook(bookId, title, author, isbn, edition, pyear, pages, instock) {
        document.getElementById('edit_book_id').value = bookId;
        document.getElementById('edit_book_title').value = title;
        document.getElementById('edit_book_author').value = author;
        document.getElementById('edit_book_isbn').value = isbn;
        document.getElementById('edit_book_edition').value = edition;
        document.getElementById('edit_book_pyear').value = pyear;
        document.getElementById('edit_book_pages').value = pages;
        document.getElementById('edit_book_instock').value = instock;
        
        var editModal = new bootstrap.Modal(document.getElementById('editBookModal'));
        editModal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>