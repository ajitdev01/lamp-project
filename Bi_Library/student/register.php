<?php
include "../config/dbconnect.php";
$msg = '';
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    if (empty($_FILES['image']['name'])) {
        $imgname = 'user.webp';
    } else {
        $imgname = time() . "_" . $_FILES['image']['name'];
        $tmpname = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmpname, '../assets/students/' . $imgname);
    }


    $query = "INSERT INTO students_tbl (st_name, st_email, st_password, st_status, st_image) VALUES('$name', '$email', '$hashedPass', 'Active', '$imgname')";
    if (mysqli_query($conn, $query)) {
        $msg = '<div class="alert alert-success">Account Successfully Created! You can now login.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Failed!</div>';
    }

    // print_r($_FILES['image']);
    // if(empty($_FILES['image']['name'])){
    //     echo "Image not selected.";
    // }else{
    //     echo $_FILES['image']['name'];
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="BiLibrary - Student Registration | Create your library account" />
    <meta name="author" content="Brainzima" />
    <title>BiLibrary | Create Account - Student Registration</title>

    <!-- Bootstrap 5.3 (Latest) + Icons + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- Google Fonts: Inter + Poppins for modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet" />

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

        /* Modern card with subtle glass effect */
        .card-modern {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 32px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            backdrop-filter: blur(0px);
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
        .register-icon-circle {
            width: 70px;
            height: 70px;
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

        /* File upload custom styling */
        .file-upload-wrapper {
            position: relative;
            border-radius: 14px;
            border: 1.5px dashed #cbd5e1;
            background: #fafcff;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .file-upload-wrapper:hover {
            border-color: #1E4A76;
            background: #f0f4fe;
        }

        .form-control-file {
            padding: 0.9rem 1rem;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .form-control-file::file-selector-button {
            background: linear-gradient(95deg, #1E4A76, #0F3460);
            border: none;
            border-radius: 40px;
            padding: 0.4rem 1rem;
            color: white;
            font-weight: 500;
            margin-right: 1rem;
            transition: 0.2s;
        }

        .form-control-file::file-selector-button:hover {
            background: #0F3A5E;
            transform: scale(1.02);
        }

        /* Modern button */
        .btn-register {
            background: linear-gradient(95deg, #1E4A76, #0F3460);
            border: none;
            border-radius: 50px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            transition: all 0.25s;
            box-shadow: 0 6px 14px rgba(15, 52, 96, 0.25);
            width: 100%;
        }

        .btn-register:hover {
            background: linear-gradient(95deg, #0F3A5E, #0B2B4A);
            transform: scale(1.01);
            box-shadow: 0 10px 20px rgba(15, 52, 96, 0.35);
        }

        .btn-register i {
            transition: transform 0.2s;
        }

        .btn-register:hover i {
            transform: translateX(5px);
        }

        /* Link styling */
        .link-modern {
            color: #1E4A76;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .link-modern:hover {
            color: #0F3460;
            text-decoration: underline;
        }

        /* Alert message styling */
        .alert-custom {
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
            border-left: 5px solid;
            background: #fff4e5;
        }

        /* Footer glass effect */
        .footer-custom {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(2px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: auto;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .card-modern {
                border-radius: 28px;
            }

            .card-header-gradient {
                padding: 1.5rem 1rem 1rem 1rem;
            }

            .register-icon-circle {
                width: 55px;
                height: 55px;
            }

            .register-icon-circle i {
                font-size: 1.8rem !important;
            }
        }

        /* small badge */
        .brand-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
            border-radius: 40px;
            padding: 0.3rem 1rem;
            display: inline-block;
        }

        /* input icons inside floating labels via pseudo not needed - we add manually inside label */
        .form-floating label i {
            margin-right: 8px;
            color: #8ba0b0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="layoutAuthentication" class="flex-grow-1 d-flex flex-column">
        <div id="layoutAuthentication_content" class="flex-grow-1 d-flex align-items-center">
            <main class="w-100 py-5">
                <div class="container px-3 px-md-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-xl-6 col-xxl-5">
                            <!-- Modern Card with smooth corners -->
                            <div class="card card-modern shadow-lg border-0 rounded-4">
                                <div class="card-header-gradient text-center border-0 rounded-top-4">
                                    <div class="register-icon-circle mx-auto">
                                        <i class="bi bi-person-plus-fill text-white fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1" style="color: #0B2B5E;">Join BiLibrary</h3>
                                    <p class="text-muted small mb-0">Create your student account to access digital library</p>
                                </div>

                                <!-- PHP Message Area (dynamic) -->
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
                                    <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        <!-- Full Name Field -->
                                        <div class="form-floating mb-4">
                                            <input class="form-control" id="inputFullName" name="name" type="text" placeholder="Enter your full name" required />
                                            <label for="inputFullName"><i class="bi bi-person-circle"></i> Full name</label>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-floating mb-4">
                                            <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required />
                                            <label for="inputEmail"><i class="bi bi-envelope-fill"></i> Email address</label>
                                        </div>

                                        <!-- Password Field -->
                                        <div class="form-floating mb-4">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a strong password" required />
                                            <label for="inputPassword"><i class="bi bi-lock-fill"></i> Password</label>
                                            <div class="form-text text-muted small mt-1 ms-2">Min. 6 characters, use letters & numbers for security</div>
                                        </div>

                                        <!-- Profile Image Upload with modern style -->
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold text-secondary mb-2 ms-1"><i class="bi bi-image me-1"></i> Profile Photo (optional)</label>
                                            <div class="file-upload-wrapper">
                                                <input class="form-control form-control-file" id="inputImage" name="image" type="file" accept="image/*" style="border: none; background: transparent;" />
                                            </div>
                                            <div class="form-text text-muted small mt-1 ms-1">Upload JPG, PNG or GIF. Max size 5MB.</div>
                                        </div>

                                        <!-- Create Account Button -->
                                        <div class="mt-4 mb-2">
                                            <button class="btn btn-register btn-primary" type="submit" name="create">
                                                <i class="bi bi-check2-circle me-2"></i> Create Account <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Card Footer with Login Link -->
                                <div class="card-footer text-center py-4 bg-transparent border-top-0">
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <span class="text-muted small">Already have an account?</span>
                                        <a href="login.php" class="link-modern">
                                            Sign in here <i class="bi bi-box-arrow-in-right ms-1"></i>
                                        </a>
                                    </div>
                                    <div class="mt-3">
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-shield-check text-success me-1"></i> Privacy Protected · Secure Registration
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Library Info Hint (desktop) -->
                            <div class="text-center mt-4 d-none d-lg-block">
                                <div class="brand-badge text-white d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-book-half"></i>
                                    <span class="small fw-medium">BiLibrary Ecosystem · Access 10k+ books</span>
                                    <i class="bi bi-dot"></i>
                                    <span class="small">Free for students</span>
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
                            <i class="bi bi-c-circle"></i> 2025 BiLibrary - Developed By: <strong class="text-dark ms-1">
                                <a href="https://www.ajitdev.com/">Ajit Dev </a>
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

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- Client-side validation script (optional but modern) -->
    <script>
        (function() {
            'use strict';
            // Fetch all forms with needs-validation class
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Optional: show file name for image upload
            const fileInput = document.getElementById('inputImage');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const fileName = this.files[0].name;
                        const fileSize = (this.files[0].size / 1024).toFixed(1);
                        // just a subtle console free, no heavy UI needed but shows better UX
                        const helpText = this.parentElement.nextElementSibling;
                        if (helpText && helpText.classList.contains('form-text')) {
                            helpText.innerHTML = `<i class="bi bi-check-circle-fill text-success me-1"></i> Selected: ${fileName} (${fileSize} KB)`;
                        }
                    } else {
                        const helpText = this.parentElement.nextElementSibling;
                        if (helpText && helpText.classList.contains('form-text')) {
                            helpText.innerHTML = `Upload JPG, PNG or GIF. Max size 5MB.`;
                        }
                    }
                });
            }
        })();
    </script>
</body>

</html>