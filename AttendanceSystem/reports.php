<?php include "includes/header.php";

include "db/dbconnect.php";

if (isset($_GET['udate'])) {
    $current_date = $_GET['udate'];
} else {
    $current_date = date('Y-m-d');
}

// Present Data
$pQry = "SELECT COUNT(*) AS total_present FROM attendance WHERE date='$current_date' AND status='Present'";
$pResult = mysqli_query($conn, $pQry);
$pdata = mysqli_fetch_assoc($pResult);

// echo "<pre>";
// print_r($pdata);
// echo "</pre>";

//Absent Data
$aQry = "SELECT COUNT(*) AS total_absent FROM attendance WHERE date='$current_date' AND status='Absent'";
$aResult = mysqli_query($conn, $aQry);
$adata = mysqli_fetch_assoc($aResult);
?>

<div class="container-fluid py-4" style="background:#f4f6f9; min-height:100vh;">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">
                <i class="fas fa-calendar-day text-primary me-2"></i>
                Attendance Reports
            </h2>
            <p class="text-muted mb-0">
                Date : <span class="fw-semibold text-dark">
                    <?php echo date('d M Y', strtotime($current_date)); ?>
                </span>
            </p>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-6">
            <form method="get" class="card border-0 shadow-sm p-3">
                <div class="input-group input-group-lg">
                    <input type="date" name="udate" class="form-control border-primary">
                    <button class="btn btn-primary px-4">
                        <i class="fas fa-search me-1"></i> Show
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row text-center mb-4 g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-scale">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                    <h6 class="text-muted">Total Present</h6>
                    <h1 class="fw-bold text-success">
                        <?php echo $pdata['total_present']; ?>
                    </h1>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-scale">
                <div class="card-body">
                    <div class="text-danger mb-2">
                        <i class="fas fa-user-times fa-2x"></i>
                    </div>
                    <h6 class="text-muted">Total Absent</h6>
                    <h1 class="fw-bold text-danger">
                        <?php echo $adata['total_absent']; ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Cards -->
    <div class="row g-4">

        <?php
        $query = "SELECT * FROM students 
                  JOIN attendance ON students.roll_no = attendance.roll_no 
                  WHERE attendance.date ='$current_date'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
                $isPresent = $data['status'] == 'Present';
        ?>

        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm h-100 student-card">

                <!-- Status Badge -->
                <div class="card-header text-center py-2 <?php echo $isPresent ? 'bg-success' : 'bg-danger'; ?> text-white">
                    <i class="fas <?php echo $isPresent ? 'fa-check-circle' : 'fa-times-circle'; ?> me-1"></i>
                    <?php echo $data['status']; ?>
                </div>

                <div class="card-body text-center">

                    <!-- Avatar -->
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($data['name']); ?>&background=0D6EFD&color=fff&size=100"
                         class="rounded-circle mb-3 shadow-sm"
                         width="80" height="80">

                    <h5 class="fw-bold mb-1"><?php echo $data['name']; ?></h5>
                    <small class="text-muted d-block mb-2">
                        Roll No: <?php echo $data['roll_no']; ?>
                    </small>

                    <p class="small mb-1 text-truncate">
                        <i class="fas fa-envelope text-primary me-1"></i>
                        <?php echo $data['email']; ?>
                    </p>

                    <p class="small mb-3">
                        <i class="fas fa-phone text-success me-1"></i>
                        <?php echo $data['mobile']; ?>
                    </p>

                    <a href="singleReport.php?roll=<?php echo $data['roll_no']; ?>"
                       class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-chart-line me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>

        <?php } 
        } else { ?>

        <!-- Empty State -->
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h5 class="fw-bold">No Attendance Records</h5>
                <p class="text-muted mb-0">
                    No data available for selected date.
                </p>
            </div>
        </div>

        <?php } ?>

    </div>
</div>

<style>
.student-card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.03);
    transition: 0.3s ease;
}
</style>

<?php include "includes/footer.php"; ?>