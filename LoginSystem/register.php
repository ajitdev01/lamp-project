<?php
include 'db/dbconnect.php';

$msg = '';
$error = '';

if (isset($_POST['register'])) {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Basic validation
    $errors = array();

    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($mobile)) {
        $errors[] = "Mobile number is required";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors[] = "Invalid mobile number (10 digits required)";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    if (empty($errors)) {
        $check_query = "SELECT * FROM users_tbl WHERE user_email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Email already registered";
        }
    }

    // If no errors, insert data
    if (empty($errors)) {
        // Note: In production, use password_hash() instead of storing plain password
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users_tbl (user_name, user_email, user_mobile, user_password) 
                  VALUES('$name','$email', '$mobile', '$hashedPassword')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> Your account has been created successfully!
                        <hr>
                        <a href="login.php" class="btn btn-success btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Proceed to Login
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
        } else {
            $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Registration failed. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
        }
    } else {
        // Display errors
        $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-2 mb-0">';
        foreach ($errors as $err) {
            $error .= '<li>' . $err . '</li>';
        }
        $error .= '</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light d-flex align-items-center min-vh-100 py-4">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">

                <!-- Brand Header -->
                <div class="text-center mb-4">
                    <i class="bi bi-person-plus-fill text-primary display-1"></i>
                    <h2 class="mt-2 fw-bold">Create Account</h2>
                    <p class="text-secondary">Join us today and get started</p>
                </div>

                <!-- Registration Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="login.php" class="nav-link" role="tab">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="register-tab" data-bs-toggle="pill" data-bs-target="#register" type="button" role="tab">
                                    <i class="bi bi-person-plus me-2"></i>Register
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">

                        <!-- Messages Display -->
                        <?php echo $error; ?>
                        <?php echo $msg; ?>

                        <!-- Registration Form -->
                        <form action="" method="post" class="needs-validation" novalidate>

                            <!-- Name Field -->
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    placeholder="John Doe"
                                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                    required>
                                <label for="name">
                                    <i class="bi bi-person-fill me-2 text-secondary"></i>Full Name
                                </label>
                                <div class="invalid-feedback">
                                    Please enter your full name.
                                </div>
                            </div>

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

                            <!-- Mobile Field -->
                            <div class="form-floating mb-3">
                                <input type="tel"
                                    class="form-control"
                                    id="mobile"
                                    name="mobile"
                                    placeholder="9876543210"
                                    value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>"
                                    pattern="[0-9]{10}"
                                    maxlength="10"
                                    required>
                                <label for="mobile">
                                    <i class="bi bi-phone-fill me-2 text-secondary"></i>Mobile Number
                                </label>
                                <div class="invalid-feedback">
                                    Please enter a valid 10-digit mobile number.
                                </div>
                                <small class="text-secondary">10-digit mobile number without country code</small>
                            </div>

                            <!-- Password Field -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password"
                                            class="form-control"
                                            id="password"
                                            name="password"
                                            placeholder="Password"
                                            minlength="6"
                                            required>
                                        <label for="password">
                                            <i class="bi bi-lock-fill me-2 text-secondary"></i>Password
                                        </label>
                                        <div class="invalid-feedback">
                                            Password must be at least 6 characters.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password"
                                            class="form-control"
                                            id="confirm_password"
                                            name="confirm_password"
                                            placeholder="Confirm Password"
                                            required>
                                        <label for="confirm_password">
                                            <i class="bi bi-lock-fill me-2 text-secondary"></i>Confirm Password
                                        </label>
                                        <div class="invalid-feedback">
                                            Please confirm your password.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar bg-danger" id="password-strength" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-secondary" id="password-strength-text">Enter a password</small>

                            <!-- Terms & Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and
                                    <a href="#" class="text-decoration-none">Privacy Policy</a>
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" name="register" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus-fill me-2"></i>Create Account
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Social Registration Options -->
                    <div class="card-footer bg-white border-0 pb-4 px-4">
                        <div class="text-center mb-3">
                            <span class="bg-white px-3 text-secondary small">Or sign up with</span>
                            <hr class="mt-2 mb-3">
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-google"></i>
                                    <span class="d-none d-md-inline ms-2">Google</span>
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-facebook"></i>
                                    <span class="d-none d-md-inline ms-2">Facebook</span>
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-github"></i>
                                    <span class="d-none d-md-inline ms-2">GitHub</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="text-secondary">
                        Already have an account?
                        <a href="login.php" class="text-decoration-none fw-bold">
                            Sign In <i class="bi bi-arrow-right-circle"></i>
                        </a>
                    </p>
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-4">
                    <small class="text-secondary">
                        <a href="#" class="text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-decoration-none me-3">Terms of Service</a>
                        <a href="#" class="text-decoration-none">Contact Support</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- Form Validation & Password Strength Script -->
    <script>
        (function() {
            'use strict';

            // Form validation
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

            // Password strength indicator
            var password = document.getElementById('password');
            var strengthBar = document.getElementById('password-strength');
            var strengthText = document.getElementById('password-strength-text');

            password.addEventListener('input', function() {
                var strength = 0;
                var value = this.value;

                if (value.length >= 6) strength += 25;
                if (value.match(/[a-z]+/)) strength += 25;
                if (value.match(/[A-Z]+/)) strength += 25;
                if (value.match(/[0-9]+/)) strength += 25;

                strengthBar.style.width = strength + '%';

                if (strength <= 25) {
                    strengthBar.className = 'progress-bar bg-danger';
                    strengthText.textContent = 'Weak password';
                } else if (strength <= 50) {
                    strengthBar.className = 'progress-bar bg-warning';
                    strengthText.textContent = 'Fair password';
                } else if (strength <= 75) {
                    strengthBar.className = 'progress-bar bg-info';
                    strengthText.textContent = 'Good password';
                } else {
                    strengthBar.className = 'progress-bar bg-success';
                    strengthText.textContent = 'Strong password';
                }

                if (value.length === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = 'Enter a password';
                }
            });
        })();
    </script>
</body>

</html>