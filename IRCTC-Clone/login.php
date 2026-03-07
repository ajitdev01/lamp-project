<?php
include 'config/config.php';
session_start();

// Safe redirect handling
$redirect = isset($_GET['redirect']) && !empty($_GET['redirect'])
    ? urldecode($_GET['redirect'])
    : 'index.php';   // default page

if (isset($_POST['login'])) {

    // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query user
    $sql = "SELECT * FROM users_tbl WHERE user_email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $data = mysqli_fetch_assoc($result);
        $hashPassword = $data['user_password'];

        if (password_verify($password, $hashPassword)) {

            // Set session values
            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['user_name'] = $data['user_name'];
            $_SESSION['user_email'] = $data['user_email'];

            // Redirect safely
            header("Location: $redirect");
            exit;
        } else {
            $msg = '<div class="alert alert-danger">Password is incorrect!</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger">Email is incorrect!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - <?= SITENAME ?></title>
    <link href="admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header text-center bg-gradient-primary text-white py-4" style="background: linear-gradient(135deg, #007bff, #6610f2);">
                        <h3 class="mb-0 fw-bold">User Login</h3>
                        <p class="text-white-50 mb-0">Welcome back! Please login to continue</p>
                    </div>
                    <div class="card-body p-4 p-md-5 bg-white">
                        <?php if (!empty($msg)) echo $msg; ?>
                        <form action="" method="post">
                            <div class="form-floating mb-4">
                                <input type="email" name="email" class="form-control rounded-3" id="inputEmail" placeholder="name@example.com" required>
                                <label for="inputEmail"><i class="fa-solid fa-envelope me-2 text-primary"></i>Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control rounded-3" id="inputPassword" placeholder="Password" required>
                                <label for="inputPassword"><i class="fa-solid fa-lock me-2 text-primary"></i>Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a class="small text-decoration-none text-primary fw-semibold" href="forgot-password.php">Forgot Password?</a>
                                <button type="submit" name="login" class="btn btn-primary px-4 py-2 rounded-3 fw-semibold shadow-sm">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                                </button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="mb-2">Don't have an account?</p>
                            <a href="register.php" class="btn btn-outline-primary btn-sm px-3 rounded-3 fw-semibold">Create an Account</a>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3 bg-light">
                        <a href="<?= SITEURL ?>" class="btn btn-secondary btn-sm rounded-3 px-3">
                            <i class="fa-solid fa-arrow-left me-1"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>