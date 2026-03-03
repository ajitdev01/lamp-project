<?php
include "includes/header.php";
include "db/dbconnect.php";
$currenct_date = date("Y-m-d");


$current_date = date('Y-m-d');

if (isset($_GET['attendance']) && isset($_GET['status'])) {
    $roll = $_GET['attendance'];
    $status = $_GET['status'];
    $query = "INSERT INTO attendance (date, roll_no, status) VALUES('$current_date', '$roll', '$status')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: index.php");
    } else {
        echo "Failed";
    }
}

?>
<style>
    .student-card {
        transition: all 0.3s ease;
        border-radius: 14px;
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
</style>

<div class="row mt-4 g-4">

    <div class="col-12 p-5">
        <div class="card border-0 shadow-sm bg-dark text-light">
            <div class="card-body text-center py-3">
                <h4 class="mb-0">
                    <i class="fa-solid fa-calendar-day me-2 text-info"></i>
                    <?php echo date('d M Y', strtotime($current_date)); ?>
                </h4>
            </div>
        </div>
    </div>

    <?php
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    while ($data = mysqli_fetch_assoc($result)) {
    ?>

        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100 student-card">

                <div class="card-body">

                    <!-- Top Section -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary text-white me-3">
                            <?php echo strtoupper(substr($data['name'], 0, 1)); ?>
                        </div>

                        <div>
                            <h6 class="mb-1 fw-bold"><?php echo $data['name']; ?></h6>
                            <span class="badge bg-<?php echo $data['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($data['status']); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Info Section -->
                    <div class="small text-muted mb-2">
                        <i class="fa-solid fa-envelope me-2 text-info"></i>
                        <?php echo $data['email']; ?>
                    </div>

                    <div class="small text-muted mb-3">
                        <i class="fa-solid fa-phone me-2 text-info"></i>
                        <?php echo $data['mobile']; ?>
                    </div>

                    <!-- Bottom Section -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <small class="fw-semibold text-secondary">
                            Roll: <?php echo $data['roll_no']; ?>
                        </small>

                        <div>
                            <?php
                            $ref = $data['roll_no'];
                            $aQry = "SELECT * FROM attendance WHERE roll_no='$ref' AND date='$current_date'";
                            $aResult = mysqli_query($conn, $aQry);

                            if (mysqli_num_rows($aResult) > 0) {
                                $adata = mysqli_fetch_assoc($aResult);
                            ?>
                                <span class="badge px-3 py-2 bg-<?php echo $adata['status'] == 'Present' ? 'success' : 'danger'; ?>">
                                    <?php echo $adata['status']; ?>
                                </span>
                            <?php
                            } else {
                            ?>
                                <a href="?attendance=<?php echo $data['roll_no']; ?>&status=Present"
                                    class="btn btn-sm btn-success rounded-pill me-1">
                                    <i class="fa-solid fa-check"></i>
                                </a>

                                <a href="?attendance=<?php echo $data['roll_no']; ?>&status=Absent"
                                    class="btn btn-sm btn-danger rounded-pill">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php } ?>
</div>


<?php
include "includes/footer.php"
?>