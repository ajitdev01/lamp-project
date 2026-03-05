<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db/dbconnect.php';

$msg = '';
$error = '';

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $emailQuery = "SELECT * FROM users_tbl WHERE user_email = '$email'";
    $emailResult = mysqli_query($conn, $emailQuery);

    if (mysqli_num_rows($emailResult) > 0) {

        $data = mysqli_fetch_assoc($emailResult);

        if (password_verify($password, $data['user_password'])) {

            $_SESSION['user_id'] = $data['user_id'];
            $_SESSION['user_name'] = $data['user_name'];

            header("Location: index.php");   // FIXED
            exit();

        } else {

            $error = "<div class='alert alert-danger'>Invalid Password</div>";

        }

    } else {

        $error = "<div class='alert alert-danger'>Email not found</div>";

    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Your Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">

                <!-- Brand Header -->
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock-fill text-primary display-1"></i>
                    <h2 class="mt-2 fw-bold">Welcome Back</h2>
                    <p class="text-secondary">Please sign in to continue</p>
                </div>

                <!-- Login Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button" role="tab">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="register.php" class="nav-link" role="tab">
                                    <i class="bi bi-person-plus me-2"></i>Register
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">

                        <!-- Error Message Display -->
                        <?php echo $error; ?>
                        <?php echo $msg; ?>

                        <!-- Login Form -->
                        <form action="" method="post" class="needs-validation" novalidate>

                            <!-- Email Field -->
                            <div class="form-floating mb-3">
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    required>
                                <label for="email">
                                    <i class="bi bi-envelope-fill me-2 text-secondary"></i>Email Address
                                </label>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-floating mb-3">
                                <input type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Password"
                                    required>
                                <label for="password">
                                    <i class="bi bi-lock-fill me-2 text-secondary"></i>Password
                                </label>
                                <div class="invalid-feedback">
                                    Please enter your password.
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none small">
                                    Forgot Password?
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" name="login" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                </button>
                            </div>

                            <!-- Demo Credentials -->
                            <div class="alert alert-info mt-4 mb-0 py-2 small" role="alert">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Demo: demo@example.com / password
                            </div>
                        </form>
                    </div>

                    <!-- Social Login Options -->
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <div class="text-center mb-3">
                            <span class="bg-white px-3 text-secondary small">Or continue with</span>
                            <hr class="mt-2 mb-3">
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google"></i>
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-facebook"></i>
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-github"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Link -->
                <div class="text-center mt-4">
                    <p class="text-secondary">
                        Don't have an account?
                        <a href="register.php" class="text-decoration-none fw-bold">
                            Register Now <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </p>
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-4">
                    <small class="text-secondary">
                        <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-decoration-none me-3">Terms of Service</a>
                        <a href="#" class="text-decoration-none">Contact</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- Form Validation Script -->
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>

</html>