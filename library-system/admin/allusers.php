<?php
require_once("../config/database.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch Patrons with new status logic
$query = "SELECT * FROM patrons ORDER BY created_at DESC";
$result = $conn->query($query);

include("../includes/header.php");
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Library Members</h1>
            <p class="text-slate-500 mt-1">Manage patron accounts, monitor status, and verify details.</p>
        </div>
        <a href="adduser.php" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-200">
            <i class="fas fa-user-plus mr-2"></i> Register New Patron
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Patron Identity</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Contact Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Location</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm mr-3">
                                        <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800"><?php echo htmlspecialchars($row['name']); ?></div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                            DOB: <?php echo date('d M Y', strtotime($row['date_of_birth'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-slate-600 flex items-center mb-1">
                                    <i class="far fa-envelope w-5 text-indigo-400"></i> <?php echo htmlspecialchars($row['email']); ?>
                                </div>
                                <div class="text-xs text-slate-500 flex items-center">
                                    <i class="fas fa-phone-alt w-5 text-indigo-400"></i> <?php echo htmlspecialchars($row['phone']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-xs font-medium text-slate-600">
                                    <i class="fas fa-map-marker-alt text-slate-300 mr-1"></i>
                                    <?php echo htmlspecialchars($row['city'] . ', ' . $row['state']); ?>
                                    <span class="block text-slate-400 text-[10px] ml-4"><?php echo htmlspecialchars($row['zip_code']); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <?php
                                $status = strtolower($row['status']);
                                $badgeClasses = "px-3 py-1 text-[10px] font-bold uppercase rounded-full border ";

                                if ($status == 'active') {
                                    echo "<span class='{$badgeClasses} bg-green-50 text-green-600 border-green-100'>Active</span>";
                                } elseif ($status == 'suspended') {
                                    echo "<span class='{$badgeClasses} bg-orange-50 text-orange-600 border-orange-100'>Suspended</span>";
                                } else {
                                    echo "<span class='{$badgeClasses} bg-slate-50 text-slate-500 border-slate-200'>Inactive</span>";
                                }
                                ?>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="edituser.php?id=<?php echo $row['id']; ?>" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-indigo-600 hover:text-white transition" title="Edit Profile">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a href="deleteuser.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Remove this patron permanently?')" class="p-2 bg-slate-100 text-red-500 rounded-lg hover:bg-red-600 hover:text-white transition" title="Delete Account">
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