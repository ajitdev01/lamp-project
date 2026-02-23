<?php
require_once("../config/database.php");
session_start(); // Ensure session is started

$error = "";
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM admins WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = (int)$admin['id'];
                $_SESSION['admin_name'] = $admin['name'];

                $update = $conn->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
                $update->bind_param("i", $_SESSION['admin_id']);
                $update->execute();

                header("Location: index.php");
                exit;
            }
        }
        $error = "Invalid email or password.";
    }
}

include("../includes/header.php");
?>

<div class="min-h-[90vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 p-8 text-center text-white">
            <h2 class="text-3xl font-bold italic">Admin Access</h2>
            <p class="text-blue-100 mt-2">Enter your credentials to continue</p>
        </div>

        <div class="p-8">
            <?php if ($error): ?>
                <div id="alertMessage" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium"><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form method="post" autocomplete="off" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="admin@example.com"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative group">
                        <input type="password" name="password" id="passwordInput" required placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition duration-200">

                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition transform active:scale-[0.98]">
                    Sign In
                </button>
            </form>
        </div>

        <div class="pb-8 text-center">
            <a href="../index.php" class="text-sm text-gray-400 hover:text-blue-500 transition">← Back to Main Website</a>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>