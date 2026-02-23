<?php
require_once("../config/database.php");
session_start();

// Security Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";
$messageClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $isbn = trim($_POST['isbn']);
    $quantity = (int)$_POST['quantity'];

    // Simple Image Upload Logic
    $image = "default_book.png";
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/Images/" . $image);
    }

    $stmt = $conn->prepare("INSERT INTO books (title, author, category, isbn, image, quantity, available_quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssii", $title, $author, $category, $isbn, $image, $quantity, $quantity);

    if ($stmt->execute()) {
        $message = "Book added successfully!";
        $messageClass = "bg-green-100 border-green-500 text-green-700";
    } else {
        $message = "Error: " . $conn->error;
        $messageClass = "bg-red-100 border-red-500 text-red-700";
    }
}

include("../includes/header.php");
?>

<main class="max-w-4xl mx-auto px-4 py-10">
    <nav class="flex mb-5 text-gray-500 text-sm" aria-label="Breadcrumb">
        <a href="index.php" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800 font-semibold">Add New Book</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 px-8 py-4 flex items-center">
            <i class="fas fa-book-medical text-white text-2xl mr-3"></i>
            <h1 class="text-xl font-bold text-white">Add New Book to Library</h1>
        </div>

        <div class="p-8">
            <?php if ($message): ?>
                <div class="<?php echo $messageClass; ?> border-l-4 p-4 mb-6 rounded shadow-sm flex items-center">
                    <i class="fas <?php echo strpos($messageClass, 'green') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-3"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Book Title</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-heading"></i>
                        </span>
                        <input type="text" name="title" required placeholder="e.g. The Great Gatsby"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Author</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-user-feather"></i>
                        </span>
                        <input type="text" name="author" required placeholder="Author Name"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ISBN Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-barcode"></i>
                        </span>
                        <input type="text" name="isbn" required placeholder="13-digit ISBN"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-tags"></i>
                        </span>
                        <select name="category" required
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition appearance-none">
                            <option value="">Select Category</option>
                            <option value="Fiction">Fiction</option>
                            <option value="Science">Science</option>
                            <option value="History">History</option>
                            <option value="Technology">Technology</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total Quantity</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-layer-group"></i>
                        </span>
                        <input type="number" name="quantity" min="1" required placeholder="Number of copies"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Book Cover Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="image" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" name="add_book"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition transform active:scale-95 flex justify-center items-center">
                        <i class="fas fa-plus-circle mr-2"></i> Save Book to Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include("../includes/footer.php"); ?>