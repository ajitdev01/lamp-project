<?php
require_once("../config/database.php");
session_start();

// Security: Only Admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: allbooks.php");
    exit;
}

$message = "";
$messageClass = "";

// 1. Fetch current book data
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    header("Location: allbooks.php");
    exit;
}

// 2. Handle Update Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $isbn = trim($_POST['isbn']);
    $quantity = (int)$_POST['quantity'];
    $available = (int)$_POST['available_quantity'];

    $image_name = $book['image']; // Keep old image by default

    // Handle New Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_image = time() . '.' . $ext;

        if (move_uploaded_file($_FILES['image']['tmp_name'], "../assets/Images/" . $new_image)) {
            // Delete old image file if it exists and isn't default
            if ($book['image'] != 'default.png' && file_exists("../assets/Images/" . $book['image'])) {
                @unlink("../assets/Images/" . $book['image']);
            }
            $image_name = $new_image;
        }
    }

    $update_stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, isbn=?, image=?, quantity=?, available_quantity=? WHERE id=?");
    $update_stmt->bind_param("sssssiii", $title, $author, $category, $isbn, $image_name, $quantity, $available, $id);

    if ($update_stmt->execute()) {
        header("Location: allbooks.php?msg=updated");
        exit;
    } else {
        $message = "Error updating record: " . $conn->error;
        $messageClass = "bg-red-50 text-red-600 border-red-200";
    }
}

include("../includes/header.php");
?>

<main class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex items-center space-x-2 text-sm text-slate-400 mb-6">
        <a href="index.php" class="hover:text-blue-600">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="allbooks.php" class="hover:text-blue-600">Inventory</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-bold">Edit Book</span>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 bg-slate-50 p-8 border-r border-slate-100 flex flex-col items-center justify-center text-center">
                <div class="mb-6 shadow-2xl rounded-xl overflow-hidden border-4 border-white rotate-2 hover:rotate-0 transition-transform duration-500">
                    <img id="preview" src="../assets/Images/<?php echo $book['image']; ?>"
                        class="h-64 w-44 object-cover" onerror="this.src='https://placehold.co/400x600?text=No+Cover'">
                </div>
                <h3 class="text-lg font-bold text-slate-800 leading-tight"><?php echo htmlspecialchars($book['title']); ?></h3>
                <p class="text-blue-500 font-medium text-sm mt-1">Current Cover Image</p>
            </div>

            <div class="md:w-2/3 p-8 md:p-12">
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-slate-800">Modify Book Details</h2>
                    <p class="text-slate-500">Update the information below to refresh the library records.</p>
                </div>

                <?php if ($message): ?>
                    <div class="p-4 mb-6 rounded-xl border <?php echo $messageClass; ?> flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Book Title</label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Author</label>
                        <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">ISBN</label>
                        <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                            <option value="Fiction" <?php if ($book['category'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
                            <option value="Science" <?php if ($book['category'] == 'Science') echo 'selected'; ?>>Science</option>
                            <option value="Technology" <?php if ($book['category'] == 'Technology') echo 'selected'; ?>>Technology</option>
                            <option value="History" <?php if ($book['category'] == 'History') echo 'selected'; ?>>History</option>
                        </select>
                    </div>

                    <div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total</label>
                                <input type="number" name="quantity" value="<?php echo $book['quantity']; ?>" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Available</label>
                                <input type="number" name="available_quantity" value="<?php echo $book['available_quantity']; ?>" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition">
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Change Cover Image</label>
                        <input type="file" name="image" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="md:col-span-2 pt-4 flex space-x-3">
                        <button type="submit" name="update_book"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition transform active:scale-95">
                            Update Book
                        </button>
                        <a href="allbooks.php" class="px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include("../includes/footer.php"); ?>