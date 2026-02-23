<?php
session_start();
include "./config/database.php";

// Check if Admin (Add your admin session check here)
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch Pending Requests with Patron and Book details
$query = "SELECT r.*, p.name as patron_name, b.title as book_title, b.available_quantity 
          FROM requests r 
          JOIN patrons p ON r.patron_id = p.id 
          JOIN books b ON r.book_id = b.id 
          WHERE r.status = 'Pending' 
          ORDER BY r.request_date ASC";
$result = mysqli_query($conn, $query);

include "./includes/header.php";
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Manage Borrow Requests</h1>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="mb-4"><?= $_SESSION['msg'];
                            unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 font-bold text-slate-700">Patron Name</th>
                    <th class="px-6 py-4 font-bold text-slate-700">Book Title</th>
                    <th class="px-6 py-4 font-bold text-slate-700">Request Date</th>
                    <th class="px-6 py-4 font-bold text-slate-700">Stock Status</th>
                    <th class="px-6 py-4 font-bold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="px-6 py-4"><?= htmlspecialchars($row['patron_name']); ?></td>
                        <td class="px-6 py-4 font-medium"><?= htmlspecialchars($row['book_title']); ?></td>
                        <td class="px-6 py-4 text-slate-500"><?= date('M d, Y', strtotime($row['request_date'])); ?></td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold <?= $row['available_quantity'] > 0 ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $row['available_quantity']; ?> Available
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="process_request.php?id=<?= $row['id']; ?>&action=approve"
                                onclick="return confirm('Confirm Approval? This will issue the book.')"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700">Approve</a>

                            <a href="process_request.php?id=<?= $row['id']; ?>&action=reject"
                                onclick="return confirm('Reject this request?')"
                                class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-200">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>