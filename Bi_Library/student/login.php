<?php
session_start();
if (isset($_SESSION['st_id'])) {
    header("Location: index.php");
}
include '../config/dbconnect.php';
$msg = '';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $emailQry = "SELECT * FROM students_tbl WHERE st_email = '$email'";
    $emailResult = mysqli_query($conn, $emailQry);
    if (mysqli_num_rows($emailResult) > 0) {
        $data = mysqli_fetch_assoc($emailResult);
        if (password_verify($password, $data['st_password'])) {
            session_start();
            $_SESSION['st_id'] = $data['st_id'];
            $_SESSION['st_name'] = $data['st_name'];
            $_SESSION['st_image'] = $data['st_image'];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>BiLibrary | Student Login - Modern Access Portal</title>
    <!-- Bootstrap 5.3 (latest stable) + Icons + Google Fonts for better typography -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Inter & Poppins for modern SaaS feel -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
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

        /* Modern glassmorphism effect for card */
        .card-modern {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(0px);
            border-radius: 32px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.35) !important;
        }

        /* Custom header with gradient accent */
        .card-header-gradient {
            background: linear-gradient(120deg, #ffffff 0%, #f8faff 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.8rem 1.5rem 1rem 1.5rem;
        }

        .login-icon-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(145deg, #1E4A76, #0F3460);
            border-radius: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        }

        /* Form floating label improvements */
        .form-floating>label {
            font-weight: 500;
            color: #5a6e7c;
            letter-spacing: -0.2px;
        }

        .form-control {
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            padding: 1rem 0.75rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #1E4A76;
            box-shadow: 0 0 0 4px rgba(30, 74, 118, 0.15);
        }

        .btn-login {
            background: linear-gradient(95deg, #1E4A76, #0F3460);
            border: none;
            border-radius: 40px;
            padding: 0.8rem 1.8rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            transition: all 0.25s;
            box-shadow: 0 6px 14px rgba(15, 52, 96, 0.25);
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

        /* Footer styling */
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

        /* Responsive improvements */
        @media (max-width: 576px) {
            .card-modern {
                border-radius: 28px;
            }

            .card-header-gradient {
                padding: 1.2rem 1rem 0.8rem 1rem;
            }

            .btn-login {
                padding: 0.7rem 1.2rem;
            }
        }

        /* Brand badge */
        .brand-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border-radius: 40px;
            padding: 0.3rem 1rem;
            display: inline-block;
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
                            <!-- Modern card with subtle shadow and smooth edges -->
                            <div class="card card-modern shadow-lg border-0 rounded-4">
                                <div class="card-header-gradient text-center border-0 rounded-top-4">
                                    <div class="login-icon-circle mx-auto">
                                        <i class="bi bi-person-badge-fill text-white fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: #0B2B5E;">Student Portal</h3>
                                    <p class="text-muted small mb-0">Access your digital library account</p>
                                </div>

                                <!-- PHP message area (dynamic) - styled beautifully -->
                                <div class="px-4 pt-3">
                                    <?php if (isset($msg) && !empty($msg)): ?>
                                        <div class="alert alert-custom alert-dismissible fade show mb-3 py-3" role="alert" style="background: #fff4e5; border-left-color: #f5a623; border-radius: 20px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-info-circle-fill text-warning"></i>
                                                <span><?php echo $msg; ?></span>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body p-4 p-xl-5 pt-0">
                                    <form action="" method="post" class="needs-validation" novalidate>
                                        <!-- Email field with floating label + icon enhancement -->
                                        <div class="form-floating mb-4">
                                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="student@example.com" required>
                                            <label for="inputEmail"><i class="bi bi-envelope-fill me-2 text-secondary"></i> Email address</label>
                                        </div>

                                        <!-- Password field with floating label -->
                                        <div class="form-floating mb-4">
                                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
                                            <label for="inputPassword"><i class="bi bi-lock-fill me-2 text-secondary"></i> Password</label>
                                        </div>

                                        <!-- Forgot password + login button row, modern layout -->
                                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4 mb-2">
                                            <button type="submit" name="login" class="btn btn-login btn-primary px-5 py-2 rounded-pill">
                                                Login <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center py-4 bg-transparent border-top-0">
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <span class="text-muted small">New to BiLibrary?</span>
                                        <a href="register.php" class="link-modern fw-semibold">
                                            Create free account <i class="bi bi-arrow-right-circle ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-shield-check text-success me-1"></i> Secure login · SSL encrypted
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional library info card (optional) -->
                            <div class="text-center mt-4 d-none d-md-block">
                                <div class="brand-badge text-white d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-book-half"></i>
                                    <span class="small fw-medium">BiLibrary · Smart Library Ecosystem</span>
                                    <i class="bi bi-dot"></i>
                                    <span class="small">24/7 access</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Modern footer with glass effect -->
        <div id="layoutAuthentication_footer">
            <footer class="footer-custom py-4 mt-4">
                <div class="container px-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <div class="text-muted small d-flex align-items-center gap-1">
                            <i class="bi bi-c-circle"></i> 2025 BiLibrary - Developed By: <strong class="text-dark ms-1">
                                <a href="https://ajitdev.com">
                                    Ajit Dev
                                </a>
                            </strong>
                        </div>
                        <div class="d-flex gap-4">
                            <a href="#" class="text-secondary text-decoration-none small hover-link"><i class="bi bi-shield-lock me-1"></i>Privacy</a>
                            <a href="#" class="text-secondary text-decoration-none small hover-link"><i class="bi bi-file-text me-1"></i>Terms</a>
                            <a href="#" class="text-secondary text-decoration-none small hover-link"><i class="bi bi-question-circle me-1"></i>Support</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS bundle for interactivity (alert close, etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"></script>
    <!-- Optional: small script to handle form validation styling -->
    <script>
        // Enable Bootstrap validation styles (optional but modern)
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })();
    </script>
</body>

</html>