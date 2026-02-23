<?php
session_start();
require_once '../config/database.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM patrons WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && $user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['patron_id'] = $user['id'];
                $_SESSION['patron_name'] = $user['name'];
                $_SESSION['patron_email'] = $user['email'];

                header("Location: ../books.php");
                exit();
            }
        }
        $error = "Invalid email or password";
    }
}
?>
<?php
include "../includes/require.php";
?>


<!-- Simple Navigation -->
<nav class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <a href="../index.php" class="text-gray-700 hover:text-blue-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Home
            </a>
            <span class="font-semibold text-gray-900">Library Login</span>
            <a href="register.php" class="text-blue-600 hover:text-blue-800 font-medium">
                Sign Up
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-sign-in-alt text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600">Sign in to your library account</p>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div id="alertMessage" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" class="space-y-5">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input type="email"
                        name="email"
                        required
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="john@example.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                        <button type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-3 text-gray-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox"
                            name="remember"
                            id="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    <a href="forgot-password.php" class="text-sm text-blue-600 hover:text-blue-800">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Sign In
                </button>

                <!-- Register Link -->
                <div class="text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="register.php" class="text-blue-600 font-medium hover:text-blue-800">
                        Create one
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>




<?php
include "../includes/footer.php";
?>