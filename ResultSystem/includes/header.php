<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ResultSystem | Smart Analytics Dashboard</title>
    <!-- Tailwind CSS + Font Awesome + Google Fonts + Chart.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- custom config override for better defaults -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'Segoe UI', 'sans-serif'],
                        'display': ['Poppins', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        accent: '#8b5cf6',
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02)',
                        'card': '0 20px 35px -12px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts: Inter + Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        /* smooth transitions & custom scroll */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            scroll-behavior: smooth;
        }

        .card-hover {
            transition: all 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.15);
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- modern navbar with glassmorphism effect -->
    <nav class="bg-white/80 backdrop-blur-md rounded-2xl shadow-soft border border-white/30 px-5 py-3 mb-8 sticky top-4 z-50">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-primary-500 to-accent flex items-center justify-center shadow-md">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                <a href="index.php" class="text-2xl font-display font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent tracking-tight">ResultSystem</a>
            </div>
            <button id="mobile-menu-button" class="block md:hidden text-slate-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div id="navbar-menu" class="hidden md:flex w-full md:w-auto items-center gap-6 mt-4 md:mt-0 transition-all">
                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
                    <a href="index.php" class="flex items-center gap-2 text-slate-700 font-medium hover:text-primary-600 transition px-2 py-1 rounded-lg hover:bg-slate-100/70">
                        <i class="fas fa-home text-primary-500 text-sm"></i> Home
                    </a>
                    <a href="add-form.php" class="flex items-center gap-2 text-slate-700 font-medium hover:text-primary-600 transition px-2 py-1 rounded-lg hover:bg-slate-100/70">
                        <i class="fas fa-user-plus text-emerald-600 text-sm"></i> Add Student
                    </a>
                    <div class="h-8 w-px bg-slate-200 hidden md:block"></div>
                    <div class="relative">
                        <form class="flex items-center" role="search">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                                <input type="search" placeholder="Search students, results..." class="pl-9 pr-4 py-2 rounded-full w-64 border border-slate-200 bg-white/80 focus:ring-2 focus:ring-primary-300 focus:border-primary-400 outline-none transition text-sm">
                            </div>
                            <button type="submit" class="ml-2 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium transition shadow-sm">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>