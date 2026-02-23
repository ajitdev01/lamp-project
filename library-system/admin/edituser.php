<?php
require_once("../config/database.php");
session_start();

// Security check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: allusers.php");
    exit;
}

// Fetch Patron Details
$stmt = $conn->prepare("SELECT * FROM patrons WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Update Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $city     = $_POST['city'];
    $state    = $_POST['state'];
    $zip      = $_POST['zip_code'];
    $status   = $_POST['status'];
    $gender   = $_POST['gender'];

    $update = $conn->prepare("UPDATE patrons SET name=?, email=?, phone=?, address=?, city=?, state=?, zip_code=?, status=?, gender=? WHERE id=?");
    $update->bind_param("sssssssssi", $name, $email, $phone, $address, $city, $state, $zip, $status, $gender, $id);

    if ($update->execute()) {
        header("Location: allusers.php?msg=updated");
        exit;
    }
}

include("../includes/header.php");
?>

<main class="max-w-5xl mx-auto px-4 py-12">
    <a href="allusers.php" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-indigo-600 mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i> BACK TO MEMBERS
    </a>

    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-indigo-600 px-8 py-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-user-edit mr-3"></i> Modify Member Account
            </h2>
            <span class="text-indigo-200 text-xs font-bold uppercase tracking-widest">ID: #<?php echo $id; ?></span>
        </div>

        <form method="POST" class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Gender</label>
                    <select name="gender" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                        <option value="Male" <?php echo $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $user['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Contact Number</label>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Residential Address</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">City</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">State</label>
                    <input type="text" name="state" value="<?php echo htmlspecialchars($user['state']); ?>"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-2 ml-1">Zip Code</label>
                    <input type="text" name="zip_code" value="<?php echo htmlspecialchars($user['zip_code']); ?>"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>

                <div class="md:col-span-3">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase mb-4 ml-1">Account Permissions</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition <?php echo $user['status'] == 'active' ? 'border-green-500 bg-green-50/30' : 'border-slate-200'; ?>">
                            <input type="radio" name="status" value="active" class="h-4 w-4 text-green-600" <?php echo $user['status'] == 'active' ? 'checked' : ''; ?>>
                            <span class="ml-3 font-bold text-sm text-slate-700">ACTIVE</span>
                        </label>

                        <label class="relative flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition <?php echo $user['status'] == 'inactive' ? 'border-slate-400 bg-slate-50' : 'border-slate-200'; ?>">
                            <input type="radio" name="status" value="inactive" class="h-4 w-4 text-slate-600" <?php echo $user['status'] == 'inactive' ? 'checked' : ''; ?>>
                            <span class="ml-3 font-bold text-sm text-slate-700">INACTIVE</span>
                        </label>

                        <label class="relative flex items-center p-4 border rounded-2xl cursor-pointer hover:bg-slate-50 transition <?php echo $user['status'] == 'suspended' ? 'border-red-500 bg-red-50/30' : 'border-slate-200'; ?>">
                            <input type="radio" name="status" value="suspended" class="h-4 w-4 text-red-600" <?php echo $user['status'] == 'suspended' ? 'checked' : ''; ?>>
                            <span class="ml-3 font-bold text-sm text-slate-700">SUSPENDED</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-12 flex items-center justify-end space-x-4">
                <a href="allusers.php" class="px-8 py-4 text-sm font-bold text-slate-500 hover:text-slate-800 transition">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</main>

<?php include("../includes/footer.php"); ?>