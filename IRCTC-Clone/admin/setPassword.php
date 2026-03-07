<?php
// session_start(); // MUST BE FIRST
include __DIR__ . "/../config/config.php";
include __DIR__ . "/../config/dbconfig.php";

// Block access if OTP is not verified
if (!isset($_SESSION['isVerified']) || $_SESSION['isVerified'] !== true) {
    header("Location: forget_password.php");
    exit;
}



$message = "";

if (isset($_POST['set'])) {

    $remail = $_SESSION['remail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Update password
    $sql = "UPDATE admin_tbl SET admin_password ='$password' WHERE admin_email = '$remail'";
    if (mysqli_query($conn, $sql)) {

        // Clear OTP for security
        $sql_delete_otp = "UPDATE admin_tbl SET admin_otp = NULL WHERE admin_email = '$remail'";
        if (mysqli_query($conn, $sql_delete_otp)) {

            // Success message
            $message = '
            <div id="alert" class="alert alert-success">
                Password reset successfully!
                <a href="login.php" class="btn btn-primary btn-sm">Login</a>
            </div>';
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
    <meta name="description" content="Secure Password Reset Page" />
    <meta name="author" content="" />
    <title>Set New Password - Secure Reset</title>

    <!-- Bootstrap -->
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

        .password-note {
            font-size: 0.85rem;
            color: #6c757d;
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
                            <h3 class="my-3">🔑 Set New Password</h3>
                        </div>
                        <div class="card-body">
                            <?php if (empty($message)) { ?>
                                <div class="small mb-3 text-muted text-center">
                                    ✅ <strong><?= $_SESSION['remail'] ?></strong> verified successfully.
                                    Please set your new password.
                                </div>

                                <form action="" method="post">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" type="password" placeholder="New Password" name="password" required />
                                        <label for="inputPassword">New Password</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputConfirmPassword" type="password" placeholder="Confirm Password" name="confirm_password" required />
                                        <label for="inputConfirmPassword">Confirm Password</label>
                                    </div>

                                    <div class="password-note mb-3">
                                        Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="login.php"><i class="fas fa-arrow-left me-1"></i>Back to login</a>
                                        <button type="submit" class="btn btn-primary px-4" name="set">
                                            <i class="fas fa-save me-2"></i>Submit
                                        </button>
                                    </div>
                                </form>
                            <?php } else {
                                echo $message;
                            } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 bg-light mt-auto text-center">
        <div class="container small text-muted">
            &copy; Your Website 2023 | <a href="#">Privacy Policy</a> · <a href="#">Terms & Conditions</a>
        </div>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>