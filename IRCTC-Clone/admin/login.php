<?php
include __DIR__ . "/../config/config.php";
?>
<?php
if (isset($_POST['login'])) {
    // safe Method like this all time use this 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // email Check frist
    $sqlEmial = "SELECT * FROM admin_tbl WHERE admin_email = '$email'";
    $result = mysqli_query($conn, $sqlEmial);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $password_in_database = $data['admin_password'];
        if (password_verify($password, $password_in_database)) {
            session_start();
            $_SESSION['admin_id'] = $data['admin_id'];
            $_SESSION['admin_name'] = $data['admin_name'];
            $_SESSION['admin_email'] = $data['admin_email'];
            header("Location: index.php");
        } else {
            $message = '<div id="alert" class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <h4 class="alert-heading">Password is incorrect!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        }
    } else {
        $message = '<div id="alert" class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <h4 class="alert-heading">Email is incorrect!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Secure admin login for the control panel">
    <meta name="author" content="Your Website">
    <title>Admin Login - Panel - <?php echo SITENAME ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
            --background-gradient: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        }

        body {
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .login-card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            background: #ffffff;
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .card-header h3 {
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            font-size: 1.75rem;
        }

        .card-body {
            padding: 2rem 2.5rem;
        }

        .form-floating label {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            padding: 1rem;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .card-footer {
            background: #f9fafb;
            border-top: none;
            padding: 1.5rem;
            text-align: center;
        }

        .card-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .card-footer a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .footer {
            background: rgba(255, 255, 255, 0.05);
            color: #d1d5db;
            padding: 1.25rem 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 0.85rem;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #e5e7eb;
            text-decoration: underline;
        }

        .alert {
            border-radius: 0.75rem;
            font-size: 0.9rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Accessibility Improvements */
        .form-control:focus+label {
            color: var(--primary-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .login-card {
                margin: 1.5rem;
            }

            .card-header {
                padding: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card login-card mt-5">
                    <div class="card-header">
                        <h3>Admin Control Panel</h3>
                        <?php if (!empty($message)) {
                            echo $message;
                        } ?>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger d-none" role="alert" id="error-message">
                            Invalid email or password.
                        </div>
                        <form action="" method="post">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="name@example.com" required aria-describedby="emailHelp" />
                                <label for="inputEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required aria-describedby="passwordHelp" />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="forgot-password" href="forgot_password.php">Forgot Password?</a>
                                <button type="submit" name="login" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div>© 2025 <?php echo SITENAME ?> . All rights reserved.</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="./js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>