<?php
require_once("../config/database.php");
session_start();

// Security: Only Admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch Books
$query = "SELECT * FROM books ORDER BY created_at DESC";
$result = $conn->query($query);

include("../includes/header.php");
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Library Inventory</h1>
            <p class="text-slate-500 mt-1">Manage and monitor all books in your collection.</p>
        </div>
        <a href="addbook.php" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-200">
            <i class="fas fa-plus-circle mr-2"></i> Add New Book
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Book Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Category</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Stock Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="h-16 w-12 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden shadow-sm mr-4 border border-slate-200">
                                        <img src="../assets/Images/<?php echo $row['image']; ?>" class="h-full w-full object-cover" onerror="this.src='https://placehold.co/400x600?text=No+Cover'">
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($row['title']); ?></div>
                                        <div class="text-xs text-slate-500 italic mb-1">by <?php echo htmlspecialchars($row['author']); ?></div>
                                        <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-mono font-bold text-slate-500 rounded">ISBN: <?php echo $row['isbn']; ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full">
                                    <?php echo $row['category']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700"><?php echo $row['available_quantity']; ?> / <?php echo $row['quantity']; ?></span>
                                    <?php if ($row['available_quantity'] > 0): ?>
                                        <span class="flex items-center text-[10px] font-bold text-green-500 uppercase mt-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500 mr-1.5 animate-pulse"></span> Available
                                        </span>
                                    <?php else: ?>
                                        <span class="flex items-center text-[10px] font-bold text-red-400 uppercase mt-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-400 mr-1.5"></span> Out of Stock
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="editbook.php?id=<?php echo $row['id']; ?>" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="deletebook.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Permanently delete this book?')" class="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 transition" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("../includes/footer.php"); ?>