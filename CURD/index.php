<?php
include "includes/header.php";
include "db/dbconnect.php";

$message = "";
if (isset($_GET['delete'])) {
    $ref = $_GET['delete'];
    $query = "DELETE FROM 	users_tbl WHERE  id = $ref";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $message = '<div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
             ✅ Data deleted successfully.
           <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    } else {
        $message = '<div id="alertMessage"  class="alert alert-danger alert-dismissible fade show" role="alert">
           ❌ Deletion failed. Please try again later.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    }
}
?>
<style>
    .user-card {
        transition: all 0.25s ease;
        border-radius: 14px;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>

<div class="row mt-3">
    <?php echo $message ?>
    <?php
    $query = "SELECT * FROM users_tbl";
    $result = mysqli_query($conn, $query);

    while ($data = mysqli_fetch_assoc($result)) {
    ?>
        <div class="col-md-3 mb-4">

            <div class="card border-0 shadow-sm h-100 user-card">
                <div class="card-body p-4">

                    <!-- Header Section -->
                    <div class="d-flex align-items-center mb-3">

                        <div class="avatar-circle bg-primary text-white fw-bold me-3">
                            <?php echo strtoupper(substr($data['name'], 0, 1)); ?>
                        </div>

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-dark">
                                <?php echo $data['name']; ?>
                            </h6>

                            <?php
                            $sClass = '';
                            switch ($data['status']) {
                                case 'Active':
                                    $sClass = 'bg-success-subtle text-success';
                                    break;
                                case 'Inactive':
                                    $sClass = 'bg-secondary-subtle text-secondary';
                                    break;
                                case 'Blocked':
                                    $sClass = 'bg-danger-subtle text-danger';
                                    break;
                                case 'Pending':
                                    $sClass = 'bg-warning-subtle text-warning';
                                    break;
                            }
                            ?>
                            <span class="badge rounded-pill px-3 py-1 <?php echo $sClass; ?>">
                                <?php echo $data['status']; ?>
                            </span>
                        </div>

                    </div>

                    <!-- Contact Info -->
                    <div class="mb-2 small">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <?php echo $data['email']; ?>
                    </div>

                    <div class="mb-3 small">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <?php echo $data['mobile']; ?>
                    </div>

                    <!-- Qualification & Job -->
                    <div class="row text-center mb-3 small">
                        <div class="col-6 border-end">
                            <div class="text-muted">Qualification</div>
                            <div class="fw-semibold"><?php echo $data['qulification']; ?></div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Preference</div>
                            <div class="fw-semibold"><?php echo $data['job_pf']; ?></div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <small class="text-muted">ID: <?php echo $data['id']; ?></small>

                        <div class="btn-group btn-group-sm">
                            <a onclick="return confirm('Are you sure to edit this data?')"
                                href="editEmp.php?id=<?php echo $data['id']; ?>"
                                class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a onclick="return confirm('Are you sure to delete this data?')"
                                href="?delete=<?php echo $data['id']; ?>"
                                class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    <?php } ?>

</div>


<script src="./Includes/Script.js"></script>
<?php
include "includes/footer.php"
?>