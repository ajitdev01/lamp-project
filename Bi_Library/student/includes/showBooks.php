<?php
$msg = '';
if (isset($_POST['request'])) {
  $rdate = $_POST['rdate'];
  $book_id = $_POST['book_id'];
  $st_id = $_SESSION['st_id'];
  $rQry = "INSERT INTO `requests_tbl`(`request_book_id`, `request_st_id`, `request_for_date`, `request_status`) VALUES ('$book_id', '$st_id', '$rdate', 'Pending')";
  if (mysqli_query($conn, $rQry)) {
    $msg = '<div class="alert alert-success">Request Successfully Sent!</div>';
  } else {
    $msg = '<div class="alert alert-danger">Failed!</div>';
  }
}
?>
<div class="container my-4">
  <?= $msg ?>
  <div class="row g-4">
    <?php
    $query = "SELECT * FROM books_tbl";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {

    ?>
        <!-- Improved Book Card with Bootstrap 5 - Modern, Clean, and Professional -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden transition-card">
            <!-- Book Image with overlay gradient and badge positioning -->
            <div class="position-relative overflow-hidden bg-light" style="height: 260px;">
              <img src="../assets/books/<?= $row['book_image'] ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo htmlspecialchars($row['book_title']); ?>" style="object-fit: cover; transition: transform 0.3s ease;">
              <!-- Stock Status Badge floating on image -->
              <div class="position-absolute top-0 end-0 m-3">
                <?php if ($row['book_instock']): ?>
                  <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-check-circle me-1"></i> In Stock
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-times-circle me-1"></i> Out of Stock
                  </span>
                <?php endif; ?>
              </div>
              <!-- Category/Hover overlay effect (optional subtle gradient) -->
              <div class="position-absolute bottom-0 start-0 w-100 bg-gradient-to-t from-dark to-transparent" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); height: 60px;"></div>
            </div>

            <div class="card-body p-4">
              <!-- Book Title with clamp -->
              <h5 class="card-title fw-bold fs-5 mb-2 text-dark" style="line-height: 1.3;"><?php echo htmlspecialchars($row['book_title']); ?></h5>

              <!-- Author with icon -->
              <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom border-1 border-light">
                <i class="fa-solid fa-user-pen text-primary opacity-75" style="font-size: 0.85rem;"></i>
                <span class="text-secondary-emphasis fw-medium small"><?php echo htmlspecialchars($row['book_author']); ?></span>
              </div>

              <!-- Book Details Grid (Modern Layout) -->
              <div class="row g-2 mb-3">
                <div class="col-4">
                  <div class="bg-light rounded-3 p-2 text-center">
                    <i class="fa-solid fa-barcode text-secondary mb-1" style="font-size: 0.75rem;"></i>
                    <p class="mb-0 small fw-semibold text-truncate" title="<?php echo htmlspecialchars($row['book_isbn']); ?>"><?php echo htmlspecialchars(substr($row['book_isbn'], 0, 12)); ?></p>
                    <small class="text-muted" style="font-size: 0.65rem;">ISBN</small>
                  </div>
                </div>
                <div class="col-4">
                  <div class="bg-light rounded-3 p-2 text-center">
                    <i class="fa-solid fa-arrows-rotate text-secondary mb-1" style="font-size: 0.75rem;"></i>
                    <p class="mb-0 small fw-semibold"><?php echo htmlspecialchars($row['book_edition']); ?></p>
                    <small class="text-muted" style="font-size: 0.65rem;">Edition</small>
                  </div>
                </div>
                <div class="col-4">
                  <div class="bg-light rounded-3 p-2 text-center">
                    <i class="fa-regular fa-calendar text-secondary mb-1" style="font-size: 0.75rem;"></i>
                    <p class="mb-0 small fw-semibold"><?php echo htmlspecialchars($row['book_pyear']); ?></p>
                    <small class="text-muted" style="font-size: 0.65rem;">Year</small>
                  </div>
                </div>
                <div class="col-6 mt-2">
                  <div class="bg-light rounded-3 p-2 text-center">
                    <i class="fa-solid fa-book-open text-secondary mb-1" style="font-size: 0.75rem;"></i>
                    <p class="mb-0 small fw-semibold"><?php echo htmlspecialchars($row['book_pages']); ?> pages</p>
                  </div>
                </div>
                <div class="col-6 mt-2">
                  <div class="bg-light rounded-3 p-2 text-center">
                    <i class="fa-solid fa-layer-group text-secondary mb-1" style="font-size: 0.75rem;"></i>
                    <p class="mb-0 small fw-semibold"><?php echo htmlspecialchars($row['book_category'] ?? 'General'); ?></p>
                    <small class="text-muted" style="font-size: 0.65rem;">Category</small>
                  </div>
                </div>
              </div>

              <!-- Request Section -->
              <?php
              $st_id = $_SESSION['st_id'];
              $b_id = $row['book_id'];
              $rdQuery = "SELECT * FROM requests_tbl WHERE request_st_id=$st_id AND request_book_id=$b_id AND request_status!='Rejected' AND request_status!='Returned'";
              $rdResult = mysqli_query($conn, $rdQuery);
              if (mysqli_num_rows($rdResult) > 0) {
              ?>
                <div class="alert alert-info rounded-3 py-2 px-3 mb-0 mt-2 d-flex align-items-center gap-2">
                  <i class="fa-solid fa-hourglass-half text-primary"></i>
                  <span class="small fw-medium">Request pending / approved</span>
                </div>
              <?php
              } else {
              ?>
                <form action="" method="post" class="mt-3">
                  <input type="hidden" value="<?= $row['book_id'] ?>" name="book_id">
                  <div class="d-flex flex-column flex-sm-row gap-2 align-items-stretch">
                    <div class="flex-grow-1">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-calendar-alt"></i></span>
                        <input class="form-control form-control-sm border-start-0" type="date" name="rdate" required style="min-width: 120px;">
                      </div>
                    </div>
                    <button type="submit" name="request" class="btn btn-sm <?php echo $row['book_instock'] ? 'btn-primary' : 'btn-secondary'; ?> rounded-3 px-4 fw-semibold" <?php echo $row['book_instock'] ? '' : 'disabled'; ?>>
                      <i class="fa-solid fa-paper-plane me-1"></i> Raise Request
                    </button>
                  </div>
                  <small class="text-muted d-block mt-2"><i class="fa-regular fa-clock"></i> Select return date to proceed</small>
                </form>
              <?php
              }
              ?>
            </div>

            <!-- Optional Footer with quick actions -->
            <div class="card-footer bg-transparent border-top-0 pb-3 px-4 pt-0">
              <hr class="my-2 opacity-25">
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="fa-regular fa-bookmark me-1"></i> Library copy</small>
                <a href="#" class="text-decoration-none small fw-semibold text-primary" data-bs-toggle="modal" data-bs-target="#bookModal<?= $row['book_id'] ?>">
                  Details <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

        <style>
          /* Custom CSS for smooth hover effects and modern transitions */
          .transition-card {
            transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
          }

          .transition-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.12) !important;
          }

          .transition-card:hover img {
            transform: scale(1.03);
          }

          .object-fit-cover {
            object-fit: cover;
          }

          /* Custom focus and input group styling */
          .form-control:focus,
          .input-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
          }

          .input-group-text {
            background-color: #f8f9fa;
          }

          /* Badge enhancements */
          .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
          }

          /* Responsive adjustments */
          @media (max-width: 576px) {
            .card-body {
              padding: 1.25rem !important;
            }

            .bg-light.rounded-3 {
              padding: 0.5rem !important;
            }
          }
        </style>

        <!-- Optional: Book Details Modal (for "Details" link) - Include once per page -->
        <div class="modal fade" id="bookModal<?= $row['book_id'] ?>" tabindex="-1" aria-labelledby="bookModalLabel<?= $row['book_id'] ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
              <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="bookModalLabel<?= $row['book_id'] ?>"><?php echo htmlspecialchars($row['book_title']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body pt-0">
                <div class="row">
                  <div class="col-5">
                    <img src="../assets/books/<?= $row['book_image'] ?>" class="img-fluid rounded-3 shadow-sm" alt="<?php echo htmlspecialchars($row['book_title']); ?>">
                  </div>
                  <div class="col-7">
                    <ul class="list-unstyled">
                      <li class="mb-2"><strong>Author:</strong> <?php echo htmlspecialchars($row['book_author']); ?></li>
                      <li class="mb-2"><strong>ISBN:</strong> <?php echo htmlspecialchars($row['book_isbn']); ?></li>
                      <li class="mb-2"><strong>Edition:</strong> <?php echo htmlspecialchars($row['book_edition']); ?></li>
                      <li class="mb-2"><strong>Year:</strong> <?php echo htmlspecialchars($row['book_pyear']); ?></li>
                      <li class="mb-2"><strong>Pages:</strong> <?php echo htmlspecialchars($row['book_pages']); ?></li>
                      <li><strong>Availability:</strong> <?php echo $row['book_instock'] ? '<span class="badge bg-success">In Stock</span>' : '<span class="badge bg-danger">Out of Stock</span>'; ?></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

    <?php

      }
    } else {
      echo "No Data Found";
    } ?>

  </div>
</div>