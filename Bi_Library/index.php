<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>BiLibrary | Modern Library Management System</title>
  <!-- Bootstrap 5.3 CSS + Icons (Bootstrap Icons for clean role icons) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
  <!-- Bootstrap Icons CDN for modern, scalable icons inside cards -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Optional: tiny custom smooth transition for lift/hover (no heavy CSS, only transitions & shadow overrides to ensure smoothness) 
         but using only utility classes + minimal style block for hover lift effect which is not fully achievable via utilities alone.
         We'll add a very minimal style block just for card hover transition & lift, matching the "no heavy custom CSS" spirit, but providing smooth UX.
         However the prompt says "Use Bootstrap utility classes only (no heavy custom CSS)" – but hover lift + shadow usually requires a tiny custom rule.
         To respect the spirit: we add only essential transition + transform, everything else is Bootstrap utilities. 
         Also gradient background uses inline style or custom? but we can set bg-gradient via Bootstrap? Bootstrap 5 has .bg-gradient class, but we need a soft gradient.
         We'll embed a minimal style for body gradient and card hover effect (lightweight, not "heavy"). 
         This ensures modern feel while staying within best practices. -->
  <style>
    /* Soft gradient background (modern, SaaS-like) - lightweight custom */
    body {
      background: linear-gradient(135deg, #f5f7ff 0%, #e9eefa 100%);
      min-height: 100vh;
      font-family: system-ui, 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
    }

    /* Card hover effect: lift + shadow enhancement - smooth transition */
    .card-hover {
      transition: transform 0.25s ease-in-out, box-shadow 0.3s ease;
    }

    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 1.5rem 2.5rem rgba(0, 0, 0, 0.12), 0 0.5rem 1rem -0.75rem rgba(0, 0, 0, 0.1) !important;
    }

    /* Additional subtle icon color transition optional, but not needed */
    .card-icon {
      transition: color 0.2s;
    }

    .card-hover:hover .card-icon {
      color: #0d6efd !important;
    }

    /* Ensuring consistent border radius for cards and container */
    .rounded-4 {
      border-radius: 1.5rem !important;
    }

    .rounded-5 {
      border-radius: 2rem !important;
    }

    /* make images/icons responsive, no extra heavy CSS */
  </style>
</head>

<body class="d-flex align-items-center py-5">
  <!-- main container with vertical centering & responsive padding -->
  <div class="container my-4 my-md-5">
    <!-- white background card container with soft rounded corners, shadow, and inner spacing -->
    <div class="bg-white rounded-5 shadow-lg p-4 p-md-5 p-xl-5 mx-auto">
      <!-- Heading section with bold typography and centered -->
      <div class="text-center mb-5 pb-2">
        <h1 class="display-5 fw-bold text-primary-emphasis mb-2">
          <i class="bi bi-book-half me-2 text-primary"></i>BiLibrary
        </h1>
        <p class="lead text-secondary fw-medium">Library Management System — Intelligent, seamless, modern</p>
        <div class="mx-auto mt-3" style="width: 70px; height: 4px; background: linear-gradient(90deg, #0d6efd, #6ea8fe); border-radius: 4px;"></div>
      </div>

      <!-- Three equal responsive cards row: Admin, Librarian, Student -->
      <div class="row g-4 g-lg-5">
        <!-- Admin Panel Card -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 card-hover bg-white">
            <div class="card-body text-center p-4 p-xl-5 d-flex flex-column align-items-center">
              <!-- Icon representing Admin role: shield-lock or person-badge -->
              <div class="card-icon mb-4">
                <i class="bi bi-shield-lock-fill" style="font-size: 4rem; color: #2c3e66;"></i>
              </div>
              <h3 class="card-title fw-semibold fs-2 mb-2">Admin Panel</h3>
              <p class="text-muted small mb-4 px-2">Full system control, user management & analytics</p>
              <a href="admin" class="btn btn-primary btn-lg rounded-pill px-5 mt-2 fw-semibold shadow-sm">
                Click Here <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Librarian Panel Card -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 card-hover bg-white">
            <div class="card-body text-center p-4 p-xl-5 d-flex flex-column align-items-center">
              <!-- Icon representing Librarian role: bookshelf or journal-bookmark -->
              <div class="card-icon mb-4">
                <i class="bi bi-journal-bookmark-fill" style="font-size: 4rem; color: #2c3e66;"></i>
              </div>
              <h3 class="card-title fw-semibold fs-2 mb-2">Librarian Panel</h3>
              <p class="text-muted small mb-4 px-2">Manage catalogs, borrow/return & inventory</p>
              <a href="librarian" class="btn btn-outline-primary btn-lg rounded-pill px-5 mt-2 fw-semibold border-2">
                Click Here <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Student Panel Card -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm rounded-4 card-hover bg-white">
            <div class="card-body text-center p-4 p-xl-5 d-flex flex-column align-items-center">
              <!-- Icon representing Student role: graduation cap or person-walking -->
              <div class="card-icon mb-4">
                <i class="bi bi-mortarboard-fill" style="font-size: 4rem; color: #2c3e66;"></i>
              </div>
              <h3 class="card-title fw-semibold fs-2 mb-2">Student Panel</h3>
              <p class="text-muted small mb-4 px-2">Browse books, reservations & reading history</p>
              <a href="student" class="btn btn-outline-primary btn-lg rounded-pill px-5 mt-2 fw-semibold border-2">
                Click Here <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Optional subtle footer note: modern touch -->
      <div class="text-center mt-5 pt-4 border-top">
        <p class="small text-secondary mb-0 d-flex align-items-center justify-content-center gap-2 flex-wrap">
          <i class="bi bi-building"></i> Central Library ·
          <i class="bi bi-clock"></i> 24/7 Digital Access ·
          <i class="bi bi-shield-check"></i> Secure Role-Based Portals
        </p>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS bundle (for any potential toggles, not mandatory for layout but best practice) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>