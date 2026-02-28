<?php
include "includes/header.php";
include "db/dbconnect.php";

$ref = $_GET['id'];
$query = "SELECT * FROM users_tbl WHERE id = $ref";
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);


$message = '';
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $job = $_POST['job'];
    $qualification = $_POST['qualification'];


    $query = "UPDATE `users_tbl`
          SET
            `name` = '$name',
            `email` = '$email',
            `mobile` = '$mobile',
            `adress` = '$address',
            `qulification` = '$qualification',
            `job_pf` = '$job',
            `status` = '$status',
            `updated_at` = NOW()
          WHERE `id` = $ref";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $message = "
    <div  id='alertMessage' class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Data added successfully.
        <a href='index.php' class='alert-link ms-2'>Go to Home</a>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
    } else {
        $message = "
    <div  id='alertMessage' class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Unable to add data. Please try again.
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
    }
}

?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Add New User</h4>
                </div>

                <div class="card-body p-4">

                    <?php echo $message; ?>

                    <form method="post">

                        <!-- Full Name -->
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required value="<?php echo $data['name'] ?>">
                            <label for="name">Full Name</label>
                        </div>

                        <!-- Email & Mobile -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required value="<?php echo $data['email'] ?>">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" name="mobile" class="form-control" id="mobile" placeholder="Mobile" required value="<?php echo $data['mobile'] ?>">
                                    <label for="mobile">Mobile Number</label>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-floating mb-3">
                            <textarea name="address" class="form-control" va placeholder="Full Address" id="address" style="height: 100px" required>
                                <?php echo $data['adress'] ?>
                            </textarea>
                            <label for="address">Full Address</label>
                        </div>

                        <!-- Qualification / Job / Status -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" name="qualification" value="<?php echo $data['qulification'] ?>" class="form-control" id="qualification" placeholder="Qualification" required>
                                    <label for="qualification">Qualification</label>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" name="job" class="form-control" id="job" value="<?php echo $data['job_pf'] ?>" placeholder="Job Preference" required>
                                    <label for="job">Job Preference</label>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <select name="status" id="" class="form-select">
                                    <option value="Pending" <?php echo $data['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Active" <?php echo $data['status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo $data['status'] == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="Blocked" <?php echo $data['status'] == 'Blocked' ? 'selected' : ''; ?>>Blocked</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                    Submit Form
                                </button>
                            </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>






<script src="./Includes/Script.js"></script>
<?php
include "includes/footer.php"
?>