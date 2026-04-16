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
?>
<div class="container">
    <h3>Add Student Form</h3>
    <?php echo $msg; ?>
    <form action="" method="post">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="name" placeholder="FullName" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="email" name="email" placeholder="Email Address" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="submit" name="add" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>