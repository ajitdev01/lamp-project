<?php
include "includes/header.php";
include "includes/sidebar.php";

// Fetch dashboard statistics
$totalBooksQuery = "SELECT COUNT(*) as total FROM books_tbl";
$totalBooksResult = mysqli_query($conn, $totalBooksQuery);
$totalBooks = mysqli_fetch_assoc($totalBooksResult)['total'];

$totalStudentsQuery = "SELECT COUNT(*) as total FROM students_tbl";
$totalStudentsResult = mysqli_query($conn, $totalStudentsQuery);
$totalStudents = mysqli_fetch_assoc($totalStudentsResult)['total'];

$pendingRequestsQuery = "SELECT COUNT(*) as total FROM requests_tbl WHERE request_status = 'Pending'";
$pendingRequestsResult = mysqli_query($conn, $pendingRequestsQuery);
$pendingRequests = mysqli_fetch_assoc($pendingRequestsResult)['total'];

$issuedBooksQuery = "SELECT COUNT(*) as total FROM issued_tbl WHERE isd_status = 'Issued'";
$issuedBooksResult = mysqli_query($conn, $issuedBooksQuery);
$issuedBooks = mysqli_fetch_assoc($issuedBooksResult)['total'];

$returnedBooksQuery = "SELECT COUNT(*) as total FROM issued_tbl WHERE isd_status = 'Returned'";
$returnedBooksResult = mysqli_query($conn, $returnedBooksQuery);
$returnedBooks = mysqli_fetch_assoc($returnedBooksResult)['total'];

$overdueBooksQuery = "SELECT COUNT(*) as total FROM issued_tbl WHERE isd_status = 'Issued' AND isd_return_date < CURDATE()";
$overdueBooksResult = mysqli_query($conn, $overdueBooksQuery);
$overdueBooks = mysqli_fetch_assoc($overdueBooksResult)['total'];

// Monthly data for charts
$monthlyData = [];
for ($i = 1; $i <= 12; $i++) {
    $monthQuery = "SELECT COUNT(*) as total FROM issued_tbl WHERE MONTH(created_at) = $i AND YEAR(created_at) = YEAR(CURDATE())";
    $monthResult = mysqli_query($conn, $monthQuery);
    $monthlyData[] = mysqli_fetch_assoc($monthResult)['total'];
}
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
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Total Books</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($totalBooks) ?></h1>
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
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="#">
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
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($totalStudents) ?></h1>
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
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="#">
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
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($pendingRequests) ?></h1>
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
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="#">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> View Requests</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Issued Books Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 transition-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-white-50 mb-1 small fw-semibold text-uppercase tracking-wide">Issued Books</p>
                            <h1 class="display-4 fw-bold text-white mb-0"><?= number_format($issuedBooks) ?></h1>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="fas fa-book-reader fs-1 text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="progress bg-white bg-opacity-25 rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-white rounded-pill" style="width: 55%;"></div>
                        </div>
                        <p class="text-white-50 small mt-2 mb-0"><i class="fas fa-chart-line"></i> Currently Issued</p>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0 py-3 px-4">
                    <a class="text-white text-decoration-none small fw-semibold d-flex align-items-center justify-content-between" href="#">
                        <span><i class="fas fa-arrow-right-circle me-1"></i> View Issued</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="row g-4 mb-5">
        <!-- Returned Books Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold">Returned Books</p>
                            <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= number_format($returnedBooks) ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-check-circle fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue Books Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold">Overdue Books</p>
                            <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= number_format($overdueBooks) ?></h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-exclamation-triangle fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Books Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold">Available Books</p>
                            <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= number_format($totalBooks - $issuedBooks) ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-book fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Requests Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold">Active Requests</p>
                            <h2 class="fw-bold mb-0" style="color: #1e293b;"><?= number_format($pendingRequests) ?></h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-hourglass-half fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-5">
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1" style="color: #1e293b;">
                                <i class="fas fa-chart-line me-2 text-primary"></i>Monthly Issued Books
                            </h5>
                            <p class="text-muted small mb-0">Book issuance trends for <?= date('Y') ?></p>
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
                                <i class="fas fa-chart-pie me-2 text-primary"></i>Book Statistics
                            </h5>
                            <p class="text-muted small mb-0">Overview of library inventory</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="myBarChart" width="100%" height="40" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-1" style="color: #1e293b;">
                        <i class="fas fa-clock me-2 text-primary"></i>Recent Activities
                    </h5>
                    <p class="text-muted small mb-0">Latest book issuances and returns</p>
                </div>
                <a href="issued.php" class="btn btn-sm btn-primary rounded-pill px-3">View All</a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-3 py-3 fw-semibold text-secondary">Student</th>
                            <th class="px-3 py-3 fw-semibold text-secondary">Book Title</th>
                            <th class="px-3 py-3 fw-semibold text-secondary">Issue Date</th>
                            <th class="px-3 py-3 fw-semibold text-secondary">Return Date</th>
                            <th class="px-3 py-3 fw-semibold text-secondary">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recentQuery = "SELECT i.*, s.st_name, b.book_title 
                                        FROM issued_tbl i 
                                        JOIN students_tbl s ON s.st_id = i.isd_st_id 
                                        JOIN books_tbl b ON b.book_id = i.isd_book_id 
                                        ORDER BY i.created_at DESC LIMIT 10";
                        $recentResult = mysqli_query($conn, $recentQuery);
                        while ($row = mysqli_fetch_assoc($recentResult)) {
                            $statusClass = $row['isd_status'] == 'Issued' ? 'bg-primary' : 'bg-success';
                        ?>
                            <tr>
                                <td class="px-3 py-2"><?= htmlspecialchars($row['st_name']) ?></td>
                                <td class="px-3 py-2"><?= htmlspecialchars($row['book_title']) ?></td>
                                <td class="px-3 py-2"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                <td class="px-3 py-2"><?= date('d M Y', strtotime($row['isd_return_date'])) ?></td>
                                <td class="px-3 py-2">
                                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-1"><?= $row['isd_status'] ?></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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

    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.03);
    }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Monthly Issued Books Chart
    const monthlyData = <?= json_encode($monthlyData) ?>;
    const ctxArea = document.getElementById('myAreaChart').getContext('2d');
    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Books Issued',
                data: monthlyData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.08)',
                borderWidth: 3,
                pointBackgroundColor: '#3b82f6',
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
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e2e8f0'
                    },
                    ticks: {
                        stepSize: 5
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Book Statistics Bar Chart
    const ctxBar = document.getElementById('myBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Total Books', 'Issued', 'Available', 'Overdue'],
            datasets: [{
                label: 'Count',
                data: [<?= $totalBooks ?>, <?= $issuedBooks ?>, <?= $totalBooks - $issuedBooks ?>, <?= $overdueBooks ?>],
                backgroundColor: ['#3b82f6', '#10b981', '#06b6d4', '#ef4444'],
                borderRadius: 8,
                barPercentage: 0.65
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
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e2e8f0'
                    },
                    ticks: {
                        stepSize: 50
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<?php include "includes/footer.php"; ?>