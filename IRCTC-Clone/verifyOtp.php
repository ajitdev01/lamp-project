<?php
session_start();
include 'config/config.php';
if (isset($_POST['verify'])) {
    $remail = $_SESSION['remail'];
    $uotp = $_POST['uotp'];

    $sql = "SELECT * FROM users_tbl WHERE user_email='$remail' AND user_otp='$uotp'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['isVerified'] = true;
        header("Location: setPassword.php");
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
    <link href="admin/css/styles.css" rel="stylesheet" />
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
                        <h3 class="fw-bold mb-1">OTP Verification</h3>
                        <p class="text-white-50 mb-0">Secure your account by verifying the code sent to your email</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4 p-md-5 bg-white">
                        <div class="small mb-4 text-muted text-center">
                            Enter the 6-digit OTP sent to your registered email:
                            <br><strong class="text-primary"><?= $_SESSION['remail'] ?></strong>
                        </div>

                        <form action="" method="post">
                            <div class="form-floating mb-4">
                                <input type="number" 
                                       name="uotp" 
                                       id="otpInput" 
                                       class="form-control rounded-3 text-center fw-semibold fs-5 tracking-widest" 
                                       placeholder="123456" 
                                       maxlength="6" 
                                       required />
                                <label for="otpInput">
                                    <i class="fa-solid fa-key me-2 text-primary"></i>Enter OTP
                                </label>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <a href="login.php" class="text-decoration-none text-primary fw-semibold">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Return to Login
                                </a>
                                <button type="submit" 
                                        name="verify" 
                                        class="btn btn-primary px-4 py-2 rounded-3 fw-semibold shadow-sm">
                                    <i class="fa-solid fa-check me-2"></i>Verify OTP
                                </button>
                            </div>
                        </form>

                        <div class="text-center small text-muted mt-3">
                            Didn’t receive the OTP? <a href="#" class="text-decoration-none text-primary fw-semibold">Resend</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer text-center bg-light py-3">
                        <small class="text-muted">&copy; <?= SITENAME ?>  Website 2025 | All Rights Reserved</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>