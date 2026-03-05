<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo $_SESSION['user_name'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Welcome Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-megaphone-fill fs-4 me-3 text-primary"></i>
                        <div>
                            <strong>Welcome back!</strong> Here's what's happening with your account today.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-envelope-fill text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Messages</h6>
                                <h3 class="mb-0">12 <small class="text-success"><i class="bi bi-arrow-up"></i> +3</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-people-fill text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Followers</h6>
                                <h3 class="mb-0">1,482 <small class="text-success"><i class="bi bi-arrow-up"></i> +28</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="bi bi-star-fill text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-secondary mb-1">Points</h6>
                                <h3 class="mb-0">2,547</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&size=128&background=0D6EFD&color=fff&bold=true"
                                alt="Profile"
                                class="rounded-circle border border-4 border-white shadow-sm"
                                width="100">
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
                        </div>
                        <h4 class="mt-3 mb-1"><?php echo $_SESSION['user_name'] ?></h4>
                        <p class="text-secondary mb-3">Premium Member</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Pro</span>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Verified</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-sm" type="button">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Recent Activity</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Messages</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex gap-3 py-3 border-0 border-bottom">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <div>
                                    <h6 class="mb-1">Welcome to your dashboard</h6>
                                    <small class="text-secondary">Just now</small>
                                </div>
                            </div>
                            <div class="list-group-item d-flex gap-3 py-3 border-0 border-bottom">
                                <i class="bi bi-star-fill text-warning fs-5"></i>
                                <div>
                                    <h6 class="mb-1">You earned a new badge</h6>
                                    <small class="text-secondary">2 hours ago</small>
                                </div>
                            </div>
                            <div class="list-group-item d-flex gap-3 py-3 border-0 border-bottom">
                                <i class="bi bi-person-plus-fill text-primary fs-5"></i>
                                <div>
                                    <h6 class="mb-1">New follower: John Doe</h6>
                                    <small class="text-secondary">Yesterday</small>
                                </div>
                            </div>
                            <div class="list-group-item d-flex gap-3 py-3 border-0">
                                <i class="bi bi-envelope-fill text-info fs-5"></i>
                                <div>
                                    <h6 class="mb-1">Unread messages: 3</h6>
                                    <small class="text-secondary">2 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pb-4">
                        <a href="#" class="btn btn-link text-decoration-none p-0">View all activity <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-upload fs-4 text-primary me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Upload Files</h6>
                                        <small class="text-secondary">Share documents</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-chat-dots-fill fs-4 text-success me-3"></i>
                                    <div>
                                        <h6 class="mb-0">Send Message</h6>
                                        <small class="text-secondary">Chat with team</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>