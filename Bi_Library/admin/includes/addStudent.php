<?php
$msg = '';
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO students_tbl (st_name, st_email, st_password, st_status) VALUES('$name', '$email', '$hashedPass', 'Active')";
    if (mysqli_query($conn, $query)) {
        $msg = '<div class="alert alert-success">Student Added Successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Student Added Failed!</div>';
    }
}
?><div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 p-4 mx-auto" style="max-width: 500px;">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Add Student</h3>
            <p class="text-muted small">Fill details to register a new student</p>
        </div>

        <?php echo $msg; ?>

        <form action="" method="post">

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" placeholder="Enter full name"
                    class="form-control rounded-3 shadow-sm" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" placeholder="Enter email"
                    class="form-control rounded-3 shadow-sm" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" placeholder="Enter password"
                    class="form-control rounded-3 shadow-sm" required>
            </div>

            <!-- Button -->
            <div class="d-grid">
                <button type="submit" name="add"
                    class="btn btn-primary rounded-3 fw-semibold py-2">
                    Add Student
                </button>
            </div>

        </form>
    </div>
</div>