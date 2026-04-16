<?php
include "includes/header.php";
include "includes/sidebar.php";

// total books
$tbQry = "SELECT COUNT(*) AS total_books FROM books_tbl";
$tbResult = mysqli_query($conn, $tbQry);
$tbdata = mysqli_fetch_assoc($tbResult);
// total students
$tsQry = "SELECT COUNT(*) AS total_students FROM students_tbl";
$tsResult = mysqli_query($conn, $tsQry);
$tsdata = mysqli_fetch_assoc($tsResult);
// pending request
$rpQry = "SELECT COUNT(*) AS pending_request FROM requests_tbl WHERE request_status='Pending'";
$rpResult = mysqli_query($conn, $rpQry);
$rpdata = mysqli_fetch_assoc($rpResult);
// rejectected request
$rrQry = "SELECT COUNT(*) AS rejected_request FROM requests_tbl WHERE request_status='Rejected'";
$rrResult = mysqli_query($conn, $rrQry);
$rrdata = mysqli_fetch_assoc($rrResult);
?>

<div class="container-fluid px-4 py-3">
    <!-- Modern Dashboard Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-1" style="color: #1e293b;">
                <i class="fas fa-chalkboard-user me-2 text-primary"></i>Dashboard
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active fw-semibold text-primary">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge bg-light text-dark rounded-pill px-3 py-2 shadow-sm">
                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                <?php echo date('l, F j, Y'); ?>
            </span>
        </div>
    </div>

    <!-- Modern Stats Cards Row -->
    <div class="row g-4 mb-5">
        <!-- Total Books Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 transition-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Total Books</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($tbdata['total_books']) ?></h1>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-book-open fs-1 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill" style="width: 75%;"></div>
                        </div>
                        <p class="text-white-50 small mt-2 mb-0"><i class="fas fa-chart-line"></i> Library Collection</p>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0 py-3 px-4">
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="books.php">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> Manage Books</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 transition-card" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Total Students</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($tsdata['total_students']) ?></h1>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-users fs-1 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill" style="width: 60%;"></div>
                        </div>
                        <p class="text-white-50 small mt-2 mb-0"><i class="fas fa-user-graduate"></i> Active Members</p>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0 py-3 px-4">
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="students.php">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> Manage Students</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 transition-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Pending Requests</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($rpdata['pending_request']) ?></h1>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-clock fs-1 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill" style="width: 40%;"></div>
                        </div>
                        <p class="text-white-50 small mt-2 mb-0"><i class="fas fa-hourglass-half"></i> Awaiting Approval</p>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0 py-3 px-4">
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="requests.php">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> View Requests</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Rejected Requests Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 transition-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Rejected Requests</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($rrdata['rejected_request']) ?></h1>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-times-circle fs-1 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill" style="width: 15%;"></div>
                        </div>
                        <p class="text-white-50 small mt-2 mb-0"><i class="fas fa-ban"></i> Declined Requests</p>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0 py-3 px-4">
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="requests.php">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> View Rejected</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section with Modern Design -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #1e293b;">
                                <i class="fas fa-chart-line me-2 text-primary"></i>Monthly Borrowing Trends
                            </h5>
                            <p class="text-muted small mb-0">Book requests & issues overview</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-calendar-alt me-1"></i> 2025 <i class="fas fa-chevron-down ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="myAreaChart" width="100%" height="40" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #1e293b;">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>Category Distribution
                            </h5>
                            <p class="text-muted small mb-0">Most borrowed book genres</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-pie-chart me-1"></i> This Year
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="myBarChart" width="100%" height="40" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Smooth card hover animations */
    .transition-card {
        transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    }

    .transition-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1.5rem 2.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .tracking-wide {
        letter-spacing: 0.5px;
    }

    /* Chart container responsive */
    canvas {
        max-height: 320px;
        width: 100%;
    }
</style>

<script>
    // Initialize Area Chart
    const ctxArea = document.getElementById('myAreaChart').getContext('2d');
    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Books Borrowed',
                data: [42, 58, 67, 83, 94, 102, 118, 125, 137, 145, 158, 172],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.08)',
                borderWidth: 3,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true
            }, {
                label: 'Books Returned',
                data: [35, 48, 59, 72, 81, 92, 103, 115, 124, 133, 142, 156],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                borderWidth: 3,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e2e8f0',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 40
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Initialize Bar Chart
    const ctxBar = document.getElementById('myBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Fiction', 'Science', 'History', 'Technology', 'Literature', 'Art', 'Philosophy'],
            datasets: [{
                label: 'Books Borrowed',
                data: [145, 98, 67, 156, 89, 54, 43],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.85)',
                    'rgba(16, 185, 129, 0.85)',
                    'rgba(245, 158, 11, 0.85)',
                    'rgba(239, 68, 68, 0.85)',
                    'rgba(139, 92, 246, 0.85)',
                    'rgba(6, 182, 212, 0.85)',
                    'rgba(100, 116, 139, 0.85)'
                ],
                borderRadius: 8,
                borderSkipped: false,
                barPercentage: 0.65,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#cbd5e1',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e2e8f0',
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 40
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    }
                }
            }
        }
    });
</script>

<!-- Bootstrap JS (if needed for dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<?php include "includes/footer.php"; ?>