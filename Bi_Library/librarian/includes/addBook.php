<?php
$msg = '';
if (isset($_POST['addBook'])) {
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_isbn = $_POST['book_isbn'];
    $book_description = mysqli_escape_string($conn, $_POST['book_description']);
    $book_edition = $_POST['book_edition'];
    $book_pyear = $_POST['book_pyear'];
    $book_pages = $_POST['book_pages'];
    $book_instock = $_POST['book_instock'] ?? 0;

    $book_imgname = time() . "_" . $_FILES['book_image']['name'];
    $book_tmpname = $_FILES['book_image']['tmp_name'];
    $lb_id = $_SESSION['lb_id'];


    $query = "INSERT INTO books_tbl (book_title, book_author, book_isbn, book_edition, book_description, book_image, book_pyear, book_pages, book_instock, librarian_id) VALUES('$book_title', '$book_author', '$book_isbn', '$book_edition', '$book_description', '$book_imgname', '$book_pyear', '$book_pages', '$book_instock', '$lb_id')";
    if (mysqli_query($conn, $query)) {
        move_uploaded_file($book_tmpname, '../assets/books/' . $book_imgname);
        $msg = '<div class="alert alert-success">Book Added Successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Book Added Failed!</div>';
    }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Modern Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-book-plus fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #1e293b;">Add New Book</h3>
                            <p class="text-muted small mb-0">Add a new book to the library catalog</p>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Message Display -->
                <?php if (isset($msg) && !empty($msg)): ?>
                    <div class="px-4 pt-3">
                        <div class="alert alert-modern alert-dismissible fade show d-flex align-items-center gap-2"
                            style="background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 16px;">
                            <i class="fas fa-check-circle text-success fs-5"></i>
                            <span class="small"><?= $msg ?></span>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Form Body -->
                <div class="card-body p-4 p-xl-5">
                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Book Title -->
                        <div class="mb-4">
                            <label for="book_title" class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-heading me-1 text-primary"></i> Book Title <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                    <i class="fas fa-book text-muted"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg border-start-0 rounded-end-3"
                                    id="book_title" name="book_title" placeholder="Enter book title"
                                    style="border: 1.5px solid #e2e8f0; padding: 0.75rem 1rem;"
                                    maxlength="255" required>
                            </div>
                        </div>

                        <!-- Author, ISBN, Edition Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="book_author" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-user-pen me-1 text-primary"></i> Author <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 rounded-end-3"
                                        id="book_author" name="book_author" placeholder="Enter author name"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.6rem 0.75rem;"
                                        maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="book_isbn" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-barcode me-1 text-primary"></i> ISBN
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-qrcode text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 rounded-end-3"
                                        id="book_isbn" name="book_isbn" placeholder="e.g. 978-3-16-148410-0"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.6rem 0.75rem;"
                                        maxlength="55">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="book_edition" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-arrows-rotate me-1 text-primary"></i> Edition
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-layer-group text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 rounded-end-3"
                                        id="book_edition" name="book_edition" placeholder="e.g. 3rd Edition"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.6rem 0.75rem;"
                                        maxlength="55">
                                </div>
                            </div>
                        </div>

                        <!-- Book Description -->
                        <div class="mb-4">
                            <label for="book_description" class="form-label fw-semibold text-secondary mb-2">
                                <i class="fas fa-align-left me-1 text-primary"></i> Description
                            </label>
                            <textarea class="form-control" id="book_description" name="book_description"
                                rows="4" placeholder="Enter book description..."
                                style="border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 0.75rem;"></textarea>
                            <small class="text-muted">Brief summary or description of the book</small>
                        </div>

                        <!-- Image, Year, Pages Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="book_image" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-image me-1 text-primary"></i> Book Cover
                                </label>
                                <div class="file-upload-wrapper" onclick="document.getElementById('book_image').click()">
                                    <input type="file" class="file-input-hidden" id="book_image" name="book_image" accept="image/*">
                                    <div class="upload-label text-center">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2 d-block"></i>
                                        <p class="mb-0 text-muted small">Click to upload cover image</p>
                                        <small class="text-muted">JPG, PNG (Max 2MB)</small>
                                    </div>
                                    <div id="imagePreview" class="mt-2 text-center"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="book_pyear" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-calendar-alt me-1 text-primary"></i> Publication Year
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-calendar text-muted"></i>
                                    </span>
                                    <input type="number" class="form-control border-start-0 rounded-end-3"
                                        id="book_pyear" name="book_pyear" placeholder="e.g. 2023"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.6rem 0.75rem;"
                                        min="1000" max="9999">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="book_pages" class="form-label fw-semibold text-secondary mb-2">
                                    <i class="fas fa-book-open me-1 text-primary"></i> Pages
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3">
                                        <i class="fas fa-file-alt text-muted"></i>
                                    </span>
                                    <input type="number" class="form-control border-start-0 rounded-end-3"
                                        id="book_pages" name="book_pages" placeholder="Number of pages"
                                        style="border: 1.5px solid #e2e8f0; padding: 0.6rem 0.75rem;"
                                        min="1">
                                </div>
                            </div>
                        </div>

                        <!-- In Stock Toggle Switch -->
                        <div class="mb-4 p-3 bg-light rounded-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="book_instock" name="book_instock" value="1" checked
                                    style="width: 50px; height: 25px; cursor: pointer;">
                                <label class="form-check-label fw-semibold ms-2" for="book_instock" style="color: #1e293b;">
                                    <i class="fas fa-check-circle text-success me-1"></i> In Stock
                                </label>
                                <small class="text-muted d-block mt-1 ms-2">Toggle off if the book is currently out of stock</small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" name="addBook" class="btn btn-gradient-primary btn-lg px-5 rounded-pill">
                                <i class="fas fa-save me-2"></i> Add Book
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-lg px-5 rounded-pill">
                                <i class="fas fa-undo-alt me-2"></i> Reset
                            </button>
                            <a href="?page=books" class="btn btn-light btn-lg px-4 rounded-pill ms-auto">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Card Footer with Info -->
                <div class="card-footer bg-white border-0 pb-4 px-4 px-xl-5">
                    <div class="d-flex align-items-center justify-content-center gap-4 flex-wrap">
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-shield-alt text-success"></i> Secure Entry
                        </small>
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-database text-info"></i> Auto-saved to catalog
                        </small>
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="fas fa-clock text-warning"></i> Instant availability
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Form styling */
    .form-control,
    .input-group-text {
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    /* Gradient button */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    }

    .btn-gradient-primary:active {
        transform: translateY(0);
    }

    /* File upload styling */
    .file-upload-wrapper {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 1rem;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #fafcff;
    }

    .file-upload-wrapper:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .file-input-hidden {
        display: none;
    }

    .upload-label {
        cursor: pointer;
    }

    .preview-image {
        max-width: 80px;
        max-height: 100px;
        margin-top: 0.75rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    /* Alert styling */
    .alert-modern {
        border-radius: 16px;
        padding: 0.875rem 1.25rem;
    }

    /* Switch styling */
    .form-check-input:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn-gradient-primary,
        .btn-outline-secondary,
        .btn-light {
            font-size: 0.85rem;
            padding: 0.5rem 1rem !important;
        }
    }
</style>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
    // Image preview functionality
    document.getElementById('book_image')?.addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.innerHTML = '';
        }
    });
</script>

<!-- Bootstrap JS for alerts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>