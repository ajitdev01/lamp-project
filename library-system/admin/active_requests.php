<?php
ob_start();
session_start();
require_once("../config/database.php");

// 1. Admin Security Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Handle Approval / Rejection Logic
if (isset($_GET['action']) && isset($_GET['id'])) {
    $req_id = $_GET['id'];
    $action = $_GET['action'];

    // Fetch details using Prepared Statement
    $stmt = $conn->prepare("SELECT patron_id, book_id FROM requests WHERE id = ? AND status = 'Pending'");
    $stmt->bind_param("i", $req_id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();

    if ($request) {
        $p_id = $request['patron_id'];
        $b_id = $request['book_id'];

        if ($action == 'approve') {
            // Check stock
            $stmt_stock = $conn->prepare("SELECT available_quantity FROM books WHERE id = ?");
            $stmt_stock->bind_param("i", $b_id);
            $stmt_stock->execute();
            $book = $stmt_stock->get_result()->fetch_assoc();

            if ($book && $book['available_quantity'] > 0) {
                // START TRANSACTION
                $conn->begin_transaction();

                try {
                    $borrow_date = date('Y-m-d');
                    $due_date = date('Y-m-d', strtotime('+14 days'));

                    // A. Insert into Borrows
                    $q1 = $conn->prepare("INSERT INTO borrows (patron_id, book_id, borrow_date, due_date, status) VALUES (?, ?, ?, ?, 'Borrowed')");
                    $q1->bind_param("iiss", $p_id, $b_id, $borrow_date, $due_date);
                    $q1->execute();

                    // B. Update Request
                    $q2 = $conn->prepare("UPDATE requests SET status = 'Approved' WHERE id = ?");
                    $q2->bind_param("i", $req_id);
                    $q2->execute();

                    // C. Decrease Inventory
                    $q3 = $conn->prepare("UPDATE books SET available_quantity = available_quantity - 1 WHERE id = ?");
                    $q3->bind_param("i", $b_id);
                    $q3->execute();

                    $conn->commit();
                    $_SESSION['msg'] = "<div class='bg-emerald-500 text-white p-4 rounded-xl mb-4 font-bold shadow-lg'>✅ Success: Book issued and stock updated.</div>";
                } catch (Exception $e) {
                    $conn->rollback();
                    $_SESSION['msg'] = "<div class='bg-red-500 text-white p-4 rounded-xl mb-4'>❌ Error: Transaction failed. Please try again.</div>";
                }
            } else {
                $_SESSION['msg'] = "<div class='bg-amber-500 text-white p-4 rounded-xl mb-4'>⚠️ Error: This book is currently out of stock.</div>";
            }
        } elseif ($action == 'reject') {
            $stmt_rej = $conn->prepare("UPDATE requests SET status = 'Rejected' WHERE id = ?");
            $stmt_rej->bind_param("i", $req_id);
            $stmt_rej->execute();
            $_SESSION['msg'] = "<div class='bg-slate-600 text-white p-4 rounded-xl mb-4'>Request has been Rejected.</div>";
        }
    }
    header("Location: active_requests.php");
    exit();
}

// 3. Fetch All Pending Requests (Join for performance)
$query = "SELECT r.id, r.request_date, p.name as patron_name, b.title as book_title, b.available_quantity 
          FROM requests r 
          JOIN patrons p ON r.patron_id = p.id 
          JOIN books b ON r.book_id = b.id 
          WHERE r.status = 'Pending' 
          ORDER BY r.request_date ASC";
$result = $conn->query($query);

include("../includes/header.php");
?>
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pending Borrow Requests</h1>
            <p class="text-slate-500">Manage incoming book requests from your library patrons.</p>
        </div>
        <a href="index.php" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-full font-bold hover:bg-slate-200 transition">
            ← Dashboard
        </a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div id="alert">
            <?= $_SESSION['msg'];
            unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Patron Details</th>
                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Book Details</th>
                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Request Date</th>
                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Decision</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800"><?= htmlspecialchars($row['patron_name']); ?></div>
                                <div class="text-xs text-slate-400 italic">Verified Patron</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-blue-600"><?= htmlspecialchars($row['book_title']); ?></div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $row['available_quantity'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $row['available_quantity']; ?> in stock
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                <?= date('M d, Y', strtotime($row['request_date'])); ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="?action=approve&id=<?= $row['id']; ?>"
                                        onclick="return confirm('Confirm book issuance?')"
                                        class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-black hover:bg-emerald-700 shadow-md shadow-emerald-100 transition-all active:scale-95">
                                        APPROVE
                                    </a>
                                    <a href="?action=reject&id=<?= $row['id']; ?>"
                                        onclick="return confirm('Are you sure you want to reject this request?')"
                                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-400 rounded-xl text-xs font-black hover:text-red-600 hover:border-red-100 hover:bg-red-50 transition-all">
                                        REJECT
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-24 text-center">
                            <div class="text-slate-300 mb-2">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <p class="text-slate-400 font-medium italic">No pending requests found in the database.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<?php include("../includes/footer.php"); ?>