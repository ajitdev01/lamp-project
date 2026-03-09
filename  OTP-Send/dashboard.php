<?php
session_start();

if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiMail Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col">
            <div class="p-6">
                <span class="text-2xl font-bold tracking-tighter text-indigo-400">BiMail</span>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center space-x-3 bg-indigo-600 p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Messages</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Tasks</span>
                </a>
                <a href="#" class="flex items-center space-x-3 text-slate-400 hover:text-white hover:bg-slate-800 p-3 rounded-xl transition-all">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <a href="logout.php" class="flex items-center space-x-3 text-red-400 p-3">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10">
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Welcome back, User!</h1>
                    <p class="text-slate-500">Here's what is happening with your account today.</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 border-2 border-indigo-200">
                    <i class="fa-solid fa-user"></i>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h3 class="font-bold text-lg">Notifications</h3>
                    <p class="text-slate-500 text-sm mb-4">You have 3 unread messages in your inbox.</p>
                    <a href="#" class="text-blue-600 font-semibold text-sm flex items-center">
                        View Messages <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h3 class="font-bold text-lg">Recent Activity</h3>
                    <p class="text-slate-500 text-sm mb-4">Last login: Today at 2:00 PM</p>
                    <a href="#" class="text-emerald-600 font-semibold text-sm flex items-center">
                        Activity Log <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <h3 class="font-bold text-lg">Task List</h3>
                    <p class="text-slate-500 text-sm mb-4">2 tasks are currently pending completion.</p>
                    <a href="#" class="text-amber-600 font-semibold text-sm flex items-center">
                        Manage Tasks <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <h3 class="font-bold text-lg">Account Settings</h3>
                    <p class="text-slate-500 text-sm mb-4">Update your profile and security settings.</p>
                    <a href="#" class="text-purple-600 font-semibold text-sm flex items-center">
                        Edit Profile <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

            </div>

            <div class="mt-10 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">System Logs</h3>
                </div>
                <div class="p-6 text-center text-slate-400 italic">
                    No critical logs to report at this time.
                </div>
            </div>
        </main>
    </div>

</body>
</html>