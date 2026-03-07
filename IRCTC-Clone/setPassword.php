<?php
session_start();
if (!$_SESSION['isVerified']) {
    header("Location: forgot-password.php");
}
include './config/config.php';
if (isset($_POST['set'])) {
    $remail = $_SESSION['remail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users_tbl SET user_password = '$password' WHERE user_email = '$remail'";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sqld = "UPDATE users_tbl SET user_otp = NULL WHERE user_email = '$remail'";
        if (mysqli_query($conn, $sqld)) {
            $msg = '<div class="alert alert-success">Successfuly reset the password! <a href="login.php" class="btn btn-primary btn-sm">Login</a></div>';
        }
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
    <title>Password Reset - SB user</title>
    <link href="./admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                    <!-- Header -->
                    <div class="card-header text-center text-white py-4"
                        style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
                        <h3 class="fw-bold mb-1">Reset Your Password</h3>
                        <p class="text-white-50 mb-0">Securely set a new password for your account</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4 p-md-5 bg-white">
                        <?php if (empty($msg)) { ?>
                            <div class="small mb-4 text-muted text-center">
                                ✅ <strong><?= $_SESSION['remail'] ?></strong> has been verified.  
                                Please enter a new password below.
                            </div>

                            <form action="" method="post">
                                <div class="form-floating mb-4">
                                    <input type="password" 
                                           class="form-control rounded-3" 
                                           id="inputPassword" 
                                           name="password" 
                                           placeholder="New Password" 
                                           minlength="6" 
                                           required />
                                    <label for="inputPassword">
                                        <i class="fa-solid fa-lock me-2 text-primary"></i>New Password
                                    </label>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <a href="login.php" class="text-decoration-none text-primary fw-semibold">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Return to Login
                                    </a>
                                    <button type="submit" 
                                            name="set" 
                                            class="btn btn-primary px-4 py-2 rounded-3 fw-semibold shadow-sm">
                                        <i class="fa-solid fa-check me-2"></i>Submit
                                    </button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="alert alert-success text-center fw-semibold rounded-3 shadow-sm">
                                <?= $msg ?>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer text-center bg-light py-3">
                        <small class="text-muted">&copy; <?= SITENAME?> Website 2025 | All Rights Reserved</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>