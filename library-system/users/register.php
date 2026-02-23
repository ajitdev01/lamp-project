<?php
session_start();
require_once '../config/database.php';

$name = $email = $phone = $address = $city = $state = $zip_code = $dob = $gender = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Name validation
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Full name is required";
    } else {
        $name = trim($_POST["name"]);
    }

    // Email validation
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        } else {
            $sql = "SELECT id FROM patrons WHERE email = '$email'";
            if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
                $errors['email'] = "Email already registered";
            }
        }
    }

    // Password validation
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Password is required";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $errors['password'] = "Minimum 8 characters required";
    } else {
        $password = trim($_POST["password"]);
    }

    // Confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $errors['confirm_password'] = "Confirm your password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($errors['password']) && ($password != $confirm_password)) {
            $errors['confirm_password'] = "Passwords don't match";
        }
    }

    // Date of birth
    if (empty(trim($_POST["dob"]))) {
        $errors['dob'] = "Date of birth is required";
    } else {
        $dob = trim($_POST["dob"]);
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        if ($age < 13) {
            $errors['dob'] = "Must be at least 13 years old";
        }
    }

    // Optional fields
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $state = trim($_POST["state"] ?? "");
    $zip_code = trim($_POST["zip_code"] ?? "");
    $gender = trim($_POST["gender"] ?? "");

    // Insert into database if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO patrons (name, email, phone, address, city, state, zip_code, date_of_birth, gender, password, status, created_at) 
                VALUES ('$name', '$email', '$phone', '$address', '$city', '$state', '$zip_code', '$dob', '$gender', '$hashed_password', 'active', NOW())";

        if (mysqli_query($conn, $sql)) {
            $patron_id = mysqli_insert_id($conn);
            $_SESSION['register_success'] = true;
            $_SESSION['success_message'] = "Registration successful! Your patron ID is: $patron_id";
            header("Location: login.php");
            exit();
        } else {
            $errors['database'] = "Registration failed. Please try again.";
        }
    }
}

include "../includes/require.php";
?>

<!-- Navigation -->
<nav class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <a href="../index.php" class="flex items-center text-gray-700 hover:text-blue-600">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Home</span>
            </a>
            <div class="text-lg font-semibold text-gray-900">Library Registration</div>
            <a href="login.php" class="text-blue-600 hover:text-blue-800 font-medium">
                Sign In
            </a>
        </div>
    </div>
</nav>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h1>
            <p class="text-gray-600">Join our library community</p>
        </div>

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 alertMessage">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span><?php echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Database Error -->
        <?php if (isset($errors['database'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span><?php echo $errors['database']; ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form method="POST" class="space-y-5">
                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name *
                    </label>
                    <input type="text"
                        name="name"
                        value="<?php echo htmlspecialchars($name); ?>"
                        required
                        class="w-full px-4 py-2.5 border <?php echo isset($errors['name']) ? 'border-red-400' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="John Doe">
                    <?php if (isset($errors['name'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo $errors['name']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address *
                    </label>
                    <input type="email"
                        name="email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        required
                        class="w-full px-4 py-2.5 border <?php echo isset($errors['email']) ? 'border-red-400' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="john@example.com">
                    <?php if (isset($errors['email'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo $errors['email']; ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date of Birth *
                        </label>
                        <input type="date"
                            name="dob"
                            value="<?php echo htmlspecialchars($dob); ?>"
                            required
                            max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>"
                            class="w-full px-4 py-2.5 border <?php echo isset($errors['dob']) ? 'border-red-400' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['dob'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo $errors['dob']; ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gender
                        </label>
                        <select name="gender"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select</option>
                            <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo ($gender == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password *
                    </label>
                    <div class="relative">
                        <input type="password"
                            name="password"
                            id="password"
                            required
                            minlength="8"
                            class="w-full px-4 py-2.5 border <?php echo isset($errors['password']) ? 'border-red-400' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                        <button type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-3 text-gray-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo $errors['password']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password *
                    </label>
                    <div class="relative">
                        <input type="password"
                            name="confirm_password"
                            id="confirm_password"
                            required
                            class="w-full px-4 py-2.5 border <?php echo isset($errors['confirm_password']) ? 'border-red-400' : 'border-gray-300'; ?> rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="••••••••">
                        <button type="button"
                            onclick="togglePassword('confirm_password')"
                            class="absolute right-3 top-3 text-gray-500">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo $errors['confirm_password']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input id="terms"
                        name="terms"
                        type="checkbox"
                        required
                        class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded">
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        I agree to the Terms and Privacy Policy *
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="login.php" class="text-blue-600 font-medium hover:text-blue-800">
                        Sign In
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set max date for DOB
    document.addEventListener('DOMContentLoaded', function() {
        const maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() - 13);
        const dobField = document.querySelector('input[name="dob"]');
        if (dobField) {
            dobField.max = maxDate.toISOString().split('T')[0];
        }
    });
</script>

<?php

include "../includes/footer.php";
?>