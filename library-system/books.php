<?php
ob_start();
session_start();

if (!isset($_SESSION['patron_id'])) {
    header("Location: ./users/login.php");
    exit();
}
include "./config/database.php";

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sql = "SELECT * FROM books WHERE 1=1";
if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%' OR category LIKE '%$search%')";
}
$sql .= " ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

include "./includes/header.php";
?>

<style>
    .book-card {
        transition: all 0.3s ease;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
</style>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="sticky top-0 z-40 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">📚 Library</h1>
                    <p class="text-gray-600 text-sm mt-1">Browse our collection</p>
                </div>

                <!-- Search -->
                <form method="GET" class="relative w-full md:w-80">
                    <input type="text"
                        name="search"
                        value="<?= htmlspecialchars($search); ?>"
                        placeholder="Search books..."
                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (!empty($search)): ?>
                        <a href="?" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            ✕
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Messages -->
        <?php if (!empty($_SESSION['msg'])): ?>
            <div class="" id="alertMessage">
                <?= $_SESSION['msg']; ?>
                <?php unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <!-- Books Grid -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php while ($book = mysqli_fetch_assoc($result)):
                    $is_available = $book['available_quantity'] > 0;
                ?>
                    <div class="book-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                        <!-- Book Cover -->
                        <div class="relative h-48 bg-gray-100">
                            <img src="./assets/Images/<?= !empty($book['image']) ? $book['image'] : 'default.jpg'; ?>"
                                alt="<?= htmlspecialchars($book['title']); ?>"
                                class="w-full h-full object-cover <?= !$is_available ? 'grayscale' : '' ?>">

                            <?php if (!$is_available): ?>
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded">Out of Stock</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Book Details -->
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-1 line-clamp-2"><?= htmlspecialchars($book['title']); ?></h3>
                            <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($book['author']); ?></p>
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <span><?= htmlspecialchars($book['category']); ?></span>
                                <span>Stock: <?= $book['available_quantity']; ?>/<?= $book['quantity']; ?></span>
                            </div>

                            <!-- Borrow Button -->
                            <button type="button"
                                onclick="openBorrowModal('<?= $book['id']; ?>', '<?= addslashes($book['title']); ?>')"
                                <?= !$is_available ? 'disabled' : '' ?>
                                class="w-full px-4 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $is_available ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-200 text-gray-400 cursor-not-allowed' ?>">
                                <?= $is_available ? 'Borrow Book' : 'Unavailable'; ?>
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <span class="text-3xl">📚</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No books found</h3>
                <p class="text-gray-600 mb-6"><?= !empty($search) ? "Try a different search term." : "Library catalog is empty."; ?></p>
                <?php if (!empty($search)): ?>
                    <a href="?" class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Clear Search
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Borrow Modal -->
    <div id="borrowModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50" onclick="closeBorrowModal()"></div>

            <!-- Modal -->
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Request Book</h3>

                    <p class="text-gray-600 mb-6">
                        You're requesting: <br>
                        <span id="displayBookTitle" class="font-bold text-gray-900"></span>
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Due Date:</span>
                            <span class="font-medium"><?= date('M d, Y', strtotime('+14 days')) ?></span>
                        </div>
                    </div>

                    <form action="borrow.php" method="POST" class="space-y-4">
                        <input type="hidden" name="book_id" id="modalBookId">
                        <input type="hidden" name="confirm_request" value="1">

                        <div class="flex gap-3">
                            <button type="button" onclick="closeBorrowModal()"
                                class="flex-1 px-4 py-2.5 text-gray-700 font-medium border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>

                            <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include "./includes/footer.php"; ?>