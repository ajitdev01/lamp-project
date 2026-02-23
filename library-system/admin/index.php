<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

// Fetch Admin Details
$stmt = $conn->prepare("SELECT name, email, profile_image, last_login FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();


include("../includes/header.php");
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
            <div class="relative">
                <img class="h-28 w-28 rounded-full object-cover ring-4 ring-blue-50"
                    src="../assets/Images/ <?php echo htmlspecialchars($admin['profile_image']) ?>" alt="Admin">
                <span class="absolute bottom-1 right-1 block h-5 w-5 rounded-full bg-green-400 ring-4 ring-white"></span>
            </div>
            <h2 class="mt-4 text-xl font-bold text-gray-800"><?php echo htmlspecialchars($admin['name']); ?></h2>
            <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($admin['email']); ?></p>

            <div class="mt-6 w-full pt-6 border-t border-gray-100 text-left">
                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Security Access</p>
                <div class="mt-3 flex items-center text-sm text-gray-600">
                    <i class="fas fa-clock mr-2 text-blue-500"></i>
                    <span>Last Login: <?php echo $admin['last_login'] ? date('M j, g:i A', strtotime($admin['last_login'])) : 'New'; ?></span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Books Management</h3>
                        </div>
                    </div>
                    <a href="addbook.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                        <i class="fas fa-plus mr-1"></i> Add New
                    </a>
                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-50">
                    <a href="allbooks.php" class="px-4 py-2 bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-list mr-1"></i> VIEW ALL
                    </a>
                    <a href="allbooks.php" class="px-4 py-2 bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-edit mr-1"></i> EDIT BOOKS
                    </a>
                    <a href="allbooks.php" class="px-4 py-2 bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-trash mr-1"></i> DELETE BOOKS
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">User Management</h3>
                        </div>
                    </div>

                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-50">
                    <a href="allusers.php" class="px-4 py-2 bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-id-card mr-1"></i> VIEW ALL USERS
                    </a>
                    <a href="allusers.php" class="px-4 py-2 bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-user-edit mr-1"></i> MODIFY USERS
                    </a>
                    <a href="allusers.php" class="px-4 py-2 bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-full text-xs font-bold transition">
                        <i class="fas fa-user-minus mr-1"></i> REMOVE USERS
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600">
                            <i class="fas fa-exchange-alt fa-2x"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Circulation & Requests</h3>
                            <p class="text-xs text-gray-500">Approve requests and manage returns</p>
                        </div>
                    </div>
                    <?php
                    $count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM requests WHERE status = 'Pending'");
                    $count = mysqli_fetch_assoc($count_q)['total'];
                    if ($count > 0): ?>
                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                            <?php echo $count; ?> NEW REQUESTS
                        </span>
                    <?php endif; ?>
                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-50">
                    <a href="admin_requests.php" class="px-4 py-2 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white rounded-full text-xs font-bold transition flex items-center">
                        <i class="fas fa-bell mr-1"></i> VIEW PENDING REQUESTS
                    </a>
                    <a href="./active_requests.php" class="px-4 py-2 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white rounded-full text-xs font-bold transition flex items-center">
                        <i class="fas fa-book-reader mr-1"></i> ACTIVE BORROWS
                    </a>
                    <a href="borrow_history.php" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-xs font-bold transition flex items-center">
                        <i class="fas fa-history mr-1"></i> BORROW HISTORY
                    </a>
                </div>
            </div>

        </div>

    </div>
</main>

<?php include("../includes/footer.php"); ?>