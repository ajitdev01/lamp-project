<?php
ob_start();
session_start();
require_once("../config/database.php");

if (!isset($_SESSION['patron_id'])) {
    header("Location: ./users/login.php");
    exit();
}

include "../includes/header.php";
$p_id = $_SESSION['patron_id'];

// 1. Fetch Active Borrows (Books currently in hand)
$borrows_sql = "SELECT b.*, bk.title, bk.author, bk.image 
                FROM borrows b 
                JOIN books bk ON b.book_id = bk.id 
                WHERE b.patron_id = '$p_id' AND b.status IN ('Borrowed', 'Overdue')
                ORDER BY b.due_date ASC";
$borrows_res = mysqli_query($conn, $borrows_sql);

// 2. Fetch Requests (Pending or Rejected)
$requests_sql = "SELECT r.*, bk.title, bk.author 
                 FROM requests r 
                 JOIN books bk ON r.book_id = bk.id 
                 WHERE r.patron_id = '$p_id' 
                 ORDER BY r.request_date DESC";
$requests_res = mysqli_query($conn, $requests_sql);
?>

<main class="max-w-7xl mx-auto px-4 py-12">

    <div class="mb-12">
        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 bg-blue-600 rounded-lg text-white">
                <i class="fas fa-book-reader"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800">Currently Borrowed</h2>
        </div>

        <?php if (mysqli_num_rows($borrows_res) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while ($loan = mysqli_fetch_assoc($borrows_res)):
                    $is_overdue = (strtotime($loan['due_date']) < time() && $loan['status'] != 'Returned');
                ?>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border <?= $is_overdue ? 'border-red-200 bg-red-50/30' : 'border-slate-100' ?> flex items-center gap-6">
                        <img src="assets/Images/<?= $loan['image'] ?>" class="w-16 h-24 object-cover rounded-xl shadow">
                        <div class="flex-grow">
                            <h3 class="font-bold text-slate-800"><?= htmlspecialchars($loan['title']) ?></h3>
                            <p class="text-xs text-slate-500 mb-3">Due by: <span class="<?= $is_overdue ? 'text-red-600 font-bold' : 'text-slate-800' ?>"><?= date('M d, Y', strtotime($loan['due_date'])) ?></span></p>

                            <?php if ($is_overdue): ?>
                                <span class="text-[10px] bg-red-600 text-white px-2 py-1 rounded-md font-bold uppercase animate-pulse">Overdue</span>
                            <?php else: ?>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full mt-2">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: 70%"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-slate-400 italic">No books currently on loan.</p>
        <?php endif; ?>
    </div>

    <hr class="border-slate-200 mb-12">

    <div>
        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 bg-slate-800 rounded-lg text-white">
                <i class="fas fa-history"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800">Request Log</h2>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Book</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while ($req = mysqli_fetch_assoc($requests_res)): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800"><?= htmlspecialchars($req['title']) ?></p>
                                <p class="text-xs text-slate-500"><?= htmlspecialchars($req['author']) ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($req['status'] == 'Pending'): ?>
                                    <span class="text-amber-600 text-xs font-bold flex items-center">
                                        <span class="h-2 w-2 bg-amber-500 rounded-full mr-2"></span> Pending
                                    </span>
                                <?php elseif ($req['status'] == 'Approved'): ?>
                                    <span class="text-green-600 text-xs font-bold flex items-center">
                                        <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span> Approved
                                    </span>
                                <?php else: ?>
                                    <span class="text-red-500 text-xs font-bold flex items-center">
                                        <span class="h-2 w-2 bg-red-500 rounded-full mr-2"></span> Rejected
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?= date('M d', strtotime($req['request_date'])) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>