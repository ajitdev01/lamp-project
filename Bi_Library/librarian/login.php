<?php
session_start();
if (isset($_SESSION['lb_id'])) {
    header("Location: index.php");
}
include '../config/dbconnect.php';
$msg = '';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $emailQry = "SELECT * FROM librarian_tbl WHERE lb_email = '$email'";
    $emailResult = mysqli_query($conn, $emailQry);
    if (mysqli_num_rows($emailResult) > 0) {
        $data = mysqli_fetch_assoc($emailResult);
        if (password_verify($password, $data['lb_password'])) {
            session_start();
            $_SESSION['lb_id'] = $data['lb_id'];
            $_SESSION['lb_name'] = $data['lb_name'];
            header("Location: index.php");
        } else {
            $msg = '<div class="alert alert-danger">Password is incorrect.</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger">Email is not registed. Please Register First.</div>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="BiLibrary - Librarian Login Portal" />
    <meta name="author" content="Brainzima" />
    <title>Librarian Login - BiLibrary</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0B2B5E 0%, #1A4A7A 50%, #2C6E9E 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Modern card with glass effect */
        .card-modern {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 32px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.4) !important;
        }

        /* Gradient header */
        .card-header-gradient {
            background: linear-gradient(120deg, #ffffff 0%, #f8faff 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 2rem 1.5rem 1.2rem 1.5rem;
        }

        /* Icon circle */
        .login-icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, #1E4A76, #0F3460);
            border-radius: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        }

        /* Form floating label enhancements */
        .form-floating>label {
            font-weight: 500;
            color: #5a6e7c;
            letter-spacing: -0.2px;
            padding-left: 1rem;
        }

        .form-floating>.form-control {
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            padding: 1rem 0.75rem 0.5rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #fff;
        }

        .form-floating>.form-control:focus {
            border-color: #1E4A76;
            box-shadow: 0 0 0 4px rgba(30, 74, 118, 0.15);
        }

        /* Modern button */
        .btn-login {
            background: linear-gradient(95deg, #1E4A76, #0F3460);
            border: none;
            border-radius: 50px;
            padding: 0.85rem 1.8rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            transition: all 0.25s;
            box-shadow: 0 6px 14px rgba(15, 52, 96, 0.25);
            width: auto;
        }

        .btn-login:hover {
            background: linear-gradient(95deg, #0F3A5E, #0B2B4A);
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(15, 52, 96, 0.35);
        }

        .btn-login i {
            transition: transform 0.2s;
        }

        .btn-login:hover i {
            transform: translateX(5px);
        }

        /* Link styling */
        .link-modern {
            color: #1E4A76;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .link-modern:hover {
            color: #0F3460;
            text-decoration: underline;
        }

        /* Checkbox styling */
        .form-check-input {
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
            border: 1.5px solid #cbd5e1;
        }

        .form-check-input:checked {
            background-color: #1E4A76;
            border-color: #1E4A76;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
        }

        /* Footer glass effect */
        .footer-custom {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(2px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: auto;
        }

        /* Alert message styling */
        .alert-custom {
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
            border-left: 5px solid;
        }

        /* Brand badge */
        .brand-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border-radius: 40px;
            padding: 0.3rem 1rem;
            display: inline-block;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .card-modern {
                border-radius: 28px;
            }

            .card-header-gradient {
                padding: 1.5rem 1rem 1rem 1rem;
            }

            .login-icon-circle {
                width: 65px;
                height: 65px;
            }

            .login-icon-circle i {
                font-size: 2rem !important;
            }

            .btn-login {
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="layoutAuthentication" class="flex-grow-1 d-flex flex-column">
        <div id="layoutAuthentication_content" class="flex-grow-1 d-flex align-items-center">
            <main class="w-100 py-5">
                <div class="container px-3 px-md-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-xl-5 col-xxl-4">
                            <!-- Modern Card -->
                            <div class="card card-modern shadow-lg border-0 rounded-4">
                                <div class="card-header-gradient text-center border-0 rounded-top-4">
                                    <div class="login-icon-circle mx-auto">
                                        <i class="fas fa-chalkboard-user text-white fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: #0B2B5E;">Librarian Login</h3>
                                    <p class="text-muted small mb-0">Access the library management portal</p>
                                </div>

                                <!-- PHP Message Area (dynamic) -->
                                <div class="px-4 pt-3">
                                    <?php if (isset($msg) && !empty($msg)): ?>
                                        <div class="alert alert-custom alert-dismissible fade show mb-3 py-3" role="alert" style="background: #fff4e5; border-left-color: #f5a623; border-radius: 20px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-info-circle text-warning"></i>
                                                <span><?php echo $msg; ?></span>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body p-4 p-xl-5 pt-0">
                                    <form action="" method="post">
                                        <!-- Email Field -->
                                        <div class="form-floating mb-4">
                                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="name@example.com" required>
                                            <label for="inputEmail"><i class="fas fa-envelope me-2 text-secondary"></i> Email address</label>
                                        </div>

                                        <!-- Password Field -->
                                        <div class="form-floating mb-3">
                                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
                                            <label for="inputPassword"><i class="fas fa-lock me-2 text-secondary"></i> Password</label>
                                        </div>

                                        <!-- Remember Me Checkbox -->
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                            <label class="form-check-label" for="inputRememberPassword">
                                                <i class="fas fa-check-circle me-1 text-success"></i> Remember me
                                            </label>
                                        </div>

                                        <!-- Forgot Password + Login Button -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4">
                                            <button type="submit" name="login" class="btn btn-login btn-primary px-5 py-2 rounded-pill">
                                                Login <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Card Footer with Sign Up Link -->
                                <div class="card-footer text-center py-4 bg-transparent border-top-0">
                                    <div class="mt-3">
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                            <i class="fas fa-shield-alt text-success me-1"></i> Secure Login · SSL Encrypted
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Modern Footer -->
        <div id="layoutAuthentication_footer">
            <footer class="footer-custom py-4 mt-3">
                <div class="container-fluid px-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <div class="text-muted small d-flex align-items-center gap-1">
                            <i class="far fa-copyright"></i> 2025 BiLibrary - Developed By: <strong class="text-dark ms-1">
                                <a href="https://ajitdev.com">Ajit Dev</a>
                            </strong>
                        </div>
                        <div class="d-flex gap-4">
                            <a href="#" class="text-secondary text-decoration-none small hover-link">
                                <i class="fas fa-shield-alt me-1"></i>Privacy
                            </a>
                            <a href="#" class="text-secondary text-decoration-none small hover-link">
                                <i class="fas fa-file-alt me-1"></i>Terms
                            </a>
                            <a href="#" class="text-secondary text-decoration-none small hover-link">
                                <i class="fas fa-headset me-1"></i>Support
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Form Validation Script -->
    <script>
        (function() {
            'use strict';
            const forms = document.querySelectorAll('form');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Password visibility toggle (optional feature)
        const togglePassword = () => {
            const passwordInput = document.querySelector('input[name="password"]');
            if (passwordInput) {
                const wrapper = passwordInput.parentElement;
                const toggleBtn = document.createElement('button');
                toggleBtn.type = 'button';
                toggleBtn.className = 'btn btn-link position-absolute end-0 top-0 mt-3 me-2 text-secondary';
                toggleBtn.style.zIndex = '10';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                toggleBtn.onclick = () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    toggleBtn.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
                };
                wrapper.style.position = 'relative';
                wrapper.appendChild(toggleBtn);
            }
        };
        document.addEventListener('DOMContentLoaded', togglePassword);
    </script>
</body>

</html>