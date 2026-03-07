<?php
include __DIR__ . "/../config/config.php";
include __DIR__ . "/../config/dbconfig.php"; // REQUIRED for $conn

// session_start(); // REQUIRED

// If remail missing, block access
if (!isset($_SESSION['remail'])) {
    header("Location: forget_password.php");
    exit;
}


$message = "";

if (isset($_POST['verify'])) {
    $remail = mysqli_real_escape_string($conn, $_SESSION['remail']);
    $user_otp = mysqli_real_escape_string($conn, $_POST['uotp']);

    // Check OTP
    $sql = "SELECT * FROM admin_tbl 
            WHERE admin_email = '$remail' 
              AND admin_otp = '$user_otp'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {

        // OTP matched
        $_SESSION['isVerified'] = true;

        // OPTIONAL: Clear OTP after verification for security
        mysqli_query($conn, "UPDATE admin_tbl 
                             SET admin_otp = NULL 
                             WHERE admin_email = '$remail'");

        header("Location: setPassword.php");
        exit;
    } else {
        // OTP invalid
        $message = '<div class="alert alert-danger">
                        Invalid OTP. Please try again.
                    </div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Secure OTP verification for password recovery" />
    <meta name="author" content="" />
    <title>Verify OTP - Secure Password Reset</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #3b82f6);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 14px;
            border: none;
        }

        .card-header h3 {
            font-weight: 600;
            color: #2c3e50;
        }

        .form-floating>label {
            color: #6c757d;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }
    </style>
</head>

<body>
    <div id="layoutAuthentication" class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header text-center">
                            <h3 class="my-3">🔐 Verify OTP</h3>
                        </div>
                        <div class="card-body">
                            <p class="small mb-3 text-muted text-center">
                                Please enter the <strong>6-digit OTP</strong> sent to your registered email:
                                <span class="fw-bold text-dark"><?= $_SESSION['remail'] ?></span>
                            </p>
                            <form action="" method="post">
                                <div class="form-floating mb-4">
                                    <input class="form-control text-center" id="inputOTP" type="number" maxlength="6" placeholder="XXXXXX" name="uotp" required />
                                    <label for="inputOTP">Enter OTP</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a class="small" href="login.php"><i class="fas fa-arrow-left me-1"></i>Back to login</a>
                                    <button type="submit" class="btn btn-primary px-4" name="verify">
                                        <i class="fas fa-check-circle me-2"></i>Verify OTP
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <small class="text-muted">Didn’t receive the OTP? <a href="#">Resend</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>