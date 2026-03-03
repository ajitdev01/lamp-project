<?php
include 'includes/header.php';
include 'db/dbconnect.php';
if (isset($_GET['roll'])) {
    $ref = $_GET['roll'];
    // fetching the student details
    $query = "SELECT * FROM students WHERE roll_no = '$ref'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    // fetching the attendance data
    $aQry = "SELECT * FROM attendance WHERE roll_no = '$ref'";
    $aResult = mysqli_query($conn, $aQry);


    // Present Data
    $pQry = "SELECT COUNT(*) AS total_present FROM attendance WHERE roll_no='$ref' AND status='Present'";
    $pResult = mysqli_query($conn, $pQry);
    $pdata = mysqli_fetch_assoc($pResult);

    //Absent Data
    $abQry = "SELECT COUNT(*) AS total_absent FROM attendance WHERE roll_no='$ref' AND status='Absent'";
    $abResult = mysqli_query($conn, $abQry);
    $abdata = mysqli_fetch_assoc($abResult);
?>

    <div class="container-fluid p-5">
        <!-- Profile Header Card -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- Background Header -->
                    <div class="bg-primary bg-gradient p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-1">
                                <img src="https://bifindr.com/placeholder/200x200?text=Image"
                                    class="img-fluid rounded-circle border border-4 border-white shadow"
                                    width="120"
                                    height="120"
                                    alt="">
                            </div>
                            <div class="ms-4 text-white">
                                <h2 class="fw-bold mb-1"><?php echo $data['name']; ?></h2>
                                <div>
                                    <span class="badge bg-dark bg-opacity-50 text-white px-3 py-2 me-2">
                                        <i class="fas fa-id-card me-2"></i>#<?php echo $data['roll_no']; ?>
                                    </span>
                                    <span class="badge bg-success bg-gradient px-3 py-2">
                                        <i class="fas fa-check-circle me-2"></i><?php echo $data['status']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details -->
                    <div class="row g-0 p-4">
                        <div class="col-md-8 border-end">
                            <h5 class="text-primary mb-4">
                                <i class="fas fa-user-circle me-2"></i>Personal Information
                            </h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Full Name</small>
                                            <strong><?php echo $data['name']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-hashtag text-info"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Roll Number</small>
                                            <strong><?php echo $data['roll_no']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-phone text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Mobile</small>
                                            <strong><?php echo $data['mobile']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-envelope text-warning"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <strong><?php echo $data['email']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-book text-danger"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Course</small>
                                            <strong><?php echo $data['course']; ?></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle me-3">
                                            <i class="fas fa-calendar text-secondary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Joined Date</small>
                                            <strong><?php echo date('d-M-Y', strtotime($data['created_at'])); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats with Chart -->
                        <div class="col-md-4">
                            <div class="p-4">
                                <h5 class="text-primary mb-4">
                                    <i class="fas fa-chart-pie me-2"></i>Attendance Overview
                                </h5>

                                <!-- Mini Stats -->
                                <div class="d-flex justify-content-around mb-4">
                                    <div class="text-center">
                                        <div class="bg-success bg-opacity-10 p-3 rounded-circle mb-2">
                                            <i class="fas fa-check-circle text-success fa-2x"></i>
                                        </div>
                                        <h3 class="fw-bold text-success mb-0"><?php echo $pdata['total_present']; ?></h3>
                                        <small class="text-muted">Present</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle mb-2">
                                            <i class="fas fa-times-circle text-danger fa-2x"></i>
                                        </div>
                                        <h3 class="fw-bold text-danger mb-0"><?php echo $abdata['total_absent']; ?></h3>
                                        <small class="text-muted">Absent</small>
                                    </div>
                                </div>

                                <!-- Pie Chart -->
                                <canvas id="myPieChart" class="mt-3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fas fa-history text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">Attendance History</h3>
                        <p class="text-muted mb-0">Complete record of student attendance</p>
                    </div>
                </div>
            </div>

            <?php
            $counter = 0;
            while ($adata = mysqli_fetch_assoc($aResult)) {
                $statusClass = $adata['status'] == 'Present' ? 'success' : 'danger';
                $icon = $adata['status'] == 'Present' ? 'fa-check-circle' : 'fa-times-circle';
            ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm hover-scale rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center">
                                <!-- Status Color Bar -->
                                <div class="bg-<?php echo $statusClass; ?> p-4 h-100 d-flex align-items-center">
                                    <i class="fas <?php echo $icon; ?> text-white fa-2x"></i>
                                </div>
                                <!-- Content -->
                                <div class="flex-grow-1 p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block mb-1">Attendance Date</small>
                                            <h5 class="fw-bold mb-0">
                                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                <?php echo date('d-M-Y', strtotime($adata['date'])); ?>
                                            </h5>
                                        </div>
                                        <span class="badge bg-<?php echo $statusClass; ?> bg-gradient px-4 py-2 rounded-pill">
                                            <i class="fas <?php echo $icon; ?> me-1"></i>
                                            <?php echo $adata['status']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $counter++;
            }

            // If no attendance records found
            if ($counter == 0) {
            ?>
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm rounded-4 p-5 text-center">
                        <i class="fas fa-calendar-times fa-4x mb-3 text-info"></i>
                        <h4 class="fw-bold">No Attendance Records</h4>
                        <p class="mb-0">No attendance history found for this student.</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Add this small CSS for hover effect -->
    <style>
        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: translateY(-3px);
        }
    </style>

    <script>
        // Pie Chart with better styling
        const present = <?php echo $pdata['total_present'] ?: 0; ?>;
        const absent = <?php echo $abdata['total_absent'] ?: 0; ?>;
        const total = present + absent;

        const ctx = document.getElementById('myPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent'],
                datasets: [{
                    data: [present, absent],
                    backgroundColor: ['#198754', '#dc3545'],
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    </script>

<?php
}

include "includes/footer.php"; ?>