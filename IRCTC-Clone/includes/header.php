<?php
include "./config/config.php";

// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$uemail = $_SESSION['user_email'] ?? "";
$uname  = $_SESSION['user_name'] ?? "";
$uid    = $_SESSION['user_id'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITENAME ?> - <?= SITESLOGAN ?></title>

    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #143ceeff;
            --primary-dark: #e95affff;
            --primary-light: #0008ffff;
            --secondary: #2980b9;
            --dark: #2c3e50;
            --light: #f8f9fa;
            --border: #e0e0e0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            padding-top: 80px;
            /* Increased for better spacing */
        }

        /* ===================================
           CLEAN NAVBAR
        =================================== */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            /* Standard Bootstrap z-index */
            border-bottom: 3px solid var(--primary);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Brand */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--primary-dark) !important;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 1.25rem 0;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: var(--primary) !important;
        }

        .navbar-brand i {
            color: var(--primary);
            font-size: 1.8rem;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover i {
            transform: scale(1.1);
        }

        .brand-tagline {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
            margin-left: 5px;
        }

        /* Navigation Links */
        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            padding: 1rem 1.2rem !important;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
        }

        .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(230, 126, 34, 0.05);
        }

        .nav-link.active {
            color: var(--primary) !important;
            border-bottom-color: var(--primary);
            background: rgba(230, 126, 34, 0.1);
            font-weight: 600;
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        /* User Section */
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* User Avatar */
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid var(--primary);
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.2);
        }

        /* Buttons */
        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
            color: white;
        }

        .btn-admin {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-admin:hover {
            background: #1c5980;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
            color: white;
        }

        /* Dropdown */
        .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            margin-top: 10px;
            min-width: 220px;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            color: var(--dark);
            text-decoration: none;
        }

        .dropdown-item:hover {
            background: rgba(230, 126, 34, 0.1);
            color: var(--primary);
            transform: translateX(3px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: rgba(0, 0, 0, 0.1);
        }

        .dropdown-item-text {
            padding: 0.75rem 1rem;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            body {
                padding-top: 70px;
            }

            .navbar-collapse {
                background: white;
                padding: 1rem;
                border-radius: 0 0 8px 8px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                margin-top: 5px;
                border-top: 1px solid var(--border);
            }

            .nav-link {
                padding: 0.8rem 1rem !important;
                border-bottom: none;
                border-left: 3px solid transparent;
                margin: 0.25rem 0;
            }

            .nav-link.active {
                border-left-color: var(--primary);
                border-bottom-color: transparent;
            }

            .user-section {
                padding-top: 1rem;
                border-top: 1px solid var(--border);
                margin-top: 1rem;
                flex-direction: column;
                width: 100%;
            }

            .btn-login,
            .btn-admin {
                width: 100%;
                margin-bottom: 0.5rem;
                justify-content: center;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                width: 100%;
                margin-top: 0.5rem;
                box-shadow: none;
                border: 1px solid var(--border);
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
                padding: 1rem 0;
            }

            .brand-tagline {
                display: none;
            }

            .navbar-container {
                padding: 0 1rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding-top: 65px;
            }

            .navbar-brand {
                font-size: 1.3rem;
            }

            .navbar-brand i {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Clean & Professional Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid navbar-container">
            <!-- Brand -->
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-train"></i>
                <span><?= htmlspecialchars(SITENAME) ?></span>

            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="My_Bookings.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'book.php' ? 'active' : '' ?>">
                            <i class="fas fa-ticket-alt"></i> Book Ticket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pnr.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pnr.php' ? 'active' : '' ?>">
                            <i class="fas fa-search"></i> PNR Status
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="schedule.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : '' ?>">
                            <i class="fas fa-calendar-alt"></i> Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fare.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'fare.php' ? 'active' : '' ?>">
                            <i class="fas fa-rupee-sign"></i> Fare Enquiry
                        </a>
                    </li>
                </ul>

                <!-- User Section -->
                <div class="user-section">
                    <?php if (!empty($uemail)): ?>
                        <!-- User Dropdown -->
                        <div class="dropdown">
                            <button class="btn p-0 border-0 bg-transparent" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" style="cursor: pointer;">
                                <img src="https://avatar.iran.liara.run/username?username=<?= urlencode($uname) ?>&background=e67e22&color=fff"
                                    alt="<?= htmlspecialchars($uname) ?>"
                                    class="user-avatar">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <div class="dropdown-item-text">
                                        <strong><?= htmlspecialchars($uname) ?></strong>
                                        <div class="small text-muted"><?= htmlspecialchars($uemail) ?></div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="profile.php">
                                        <i class="fas fa-user text-primary"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="My_Bookings.php">
                                        <i class="fas fa-ticket-alt text-primary"></i> My Bookings
                                        <span class="badge bg-primary ms-auto">5</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="wallet.php">
                                        <i class="fas fa-wallet text-primary"></i> My Wallet
                                        <span class="badge bg-success ms-auto">₹1,250</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login & Admin Buttons -->
                        <a href="login.php" class="btn btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="admin" class="btn btn-admin">
                            <i class="fas fa-user-shield"></i> Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- JavaScript for enhanced interactivity -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Highlight active nav link based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');

            // Highlight current page
            navLinks.forEach(link => {
                const linkHref = link.getAttribute('href');
                if (linkHref === currentPage ||
                    (currentPage === '' && linkHref === 'index.php')) {
                    link.classList.add('active');
                }
            });

            // Mobile menu close on click
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    const navbarCollapse = document.querySelector('.navbar-collapse.show');
                    if (navbarCollapse) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                });
            });

            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

</body>

</html>