<?php
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryDB | Pro Management</title>

    <?php include_once "require.php"; ?>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .nav-link-active {
            position: relative;
            color: #2563eb;
        }

        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #2563eb;
            border-radius: 2px;
        }
    </style>
</head>

<body class="bg-slate-50/50">

    <nav class="nav-glass border-b border-slate-200/60 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex items-center cursor-pointer">
                    <div class="bg-blue-600 p-2.5 rounded-xl shadow-lg shadow-blue-200">
                        <i class="fas fa-book-reader text-white text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <a href="<?php echo SITEURL; ?>index.php"
                            class="text-xl font-extrabold text-slate-800 leading-none block">
                            <?php echo SITENAME; ?>
                        </a>
                        <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">
                            Digital Archive
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-2">

                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <a href="<?php echo SITEURL; ?>admin/index.php" class="px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 rounded-lg">
                            Dashboard
                        </a>
                        <a href="<?php echo SITEURL; ?>admin/allbooks.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            Inventory
                        </a>
                        <a href="<?php echo SITEURL; ?>admin/allusers.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            Members
                        </a>

                        <div class="flex items-center ml-6 pl-6 border-l border-slate-200 space-x-4">
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-400 uppercase">System Admin</p>
                                <p class="text-sm font-bold text-slate-800">
                                    <?php echo $_SESSION['admin_name']; ?>
                                </p>
                            </div>
                            <a href="<?php echo SITEURL; ?>admin/logout.php"
                                class="h-10 w-10 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                                <i class="fas fa-power-off"></i>
                            </a>
                        </div>

                    <?php elseif (isset($_SESSION['patron_id'])): ?>
                        <a href="<?php echo SITEURL; ?>index.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            Home
                        </a>
                        <a href="<?php echo SITEURL; ?>books.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            Catalog
                        </a>
                        <a href="<?php echo SITEURL; ?>users/my_requests.php" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-blue-600">
                            My Requests
                        </a>

                        <div class="ml-6 flex items-center bg-slate-100 p-2 rounded-xl space-x-3">
                            <span class="text-sm font-bold text-slate-700">
                                <?php echo explode(' ', $_SESSION['patron_name'])[0]; ?>
                            </span>
                            <a href="<?php echo SITEURL; ?>users/logout.php" class="text-xs font-bold text-red-500 uppercase">
                                Exit
                            </a>
                        </div>

                    <?php else: ?>
                        <a href="<?php echo SITEURL; ?>users/login.php"
                            class="text-sm font-bold text-slate-700 px-5 py-2.5 hover:bg-slate-100 rounded-xl">
                            Sign In
                        </a>
                        <a href="<?php echo SITEURL; ?>users/register.php"
                            class="text-sm font-bold text-white px-6 py-2.5 bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-200">
                            Get Started
                        </a>
                    <?php endif; ?>
                </div>

                <div class="md:hidden">
                    <button id="menu-toggle" class="p-2 rounded-xl bg-slate-100 text-slate-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 px-4 py-6 space-y-4 shadow-xl">
            <?php if (isset($_SESSION['admin_id'])): ?>
                <a href="<?php echo SITEURL; ?>admin/index.php" class="block font-semibold text-blue-600">Dashboard</a>
                <a href="<?php echo SITEURL; ?>admin/allbooks.php" class="block font-semibold text-slate-600">Inventory</a>
                <a href="<?php echo SITEURL; ?>admin/allusers.php" class="block font-semibold text-slate-600">Members</a>
                <a href="<?php echo SITEURL; ?>admin/logout.php" class="block font-bold text-red-500">Logout</a>
            <?php elseif (isset($_SESSION['patron_id'])): ?>
                <a href="<?php echo SITEURL; ?>index.php" class="block font-semibold text-slate-600">Home</a>
                <a href="<?php echo SITEURL; ?>books.php" class="block font-semibold text-slate-600">Catalog</a>
                <a href="<?php echo SITEURL; ?>users/my_requests.php" class="block font-semibold text-slate-600">My Requests</a>
                <a href="<?php echo SITEURL; ?>users/logout.php" class="block font-bold text-red-500">Logout</a>
            <?php else: ?>
                <a href="<?php echo SITEURL; ?>users/login.php" class="block font-bold text-blue-600">Sign In</a>
                <a href="<?php echo SITEURL; ?>users/register.php" class="block font-bold text-slate-700">Register</a>
            <?php endif; ?>
        </div>
    </nav>