<?php
// batch-delete.php - Optional: Bulk Delete Students (Advanced feature)
include "./includes/header.php";
include "./db/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_ids'])) {
    $ids = $_POST['delete_ids'];
    $ids_string = implode(',', array_map('intval', $ids));

    $query = "DELETE FROM students_tbl WHERE id IN ($ids_string)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $deleted_count = mysqli_affected_rows($conn);
        $msg = "Successfully deleted $deleted_count student(s).";
        $msgType = 'success';
    } else {
        $msg = "Error deleting records: " . mysqli_error($conn);
        $msgType = 'error';
    }
}

// Fetch all students for bulk delete interface
$query = "SELECT id, name, rollno, division FROM students_tbl ORDER BY name";
$result = mysqli_query($conn, $query);
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-pink-600 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trash-alt text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Bulk Delete Students</h1>
                    <p class="text-red-100 text-sm mt-1">⚠️ Warning: This action cannot be undone</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <?php if (isset($msg)): ?>
                <div class="mb-6 p-4 rounded-lg flex items-start gap-3 <?php echo $msgType == 'success' ? 'bg-green-50 border-l-4 border-green-500 text-green-700' : 'bg-red-50 border-l-4 border-red-500 text-red-700'; ?>">
                    <i class="fas <?php echo $msgType == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mt-0.5"></i>
                    <span><?php echo $msg; ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="bulkDeleteForm">
                <div class="mb-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="selectAll" class="w-5 h-5 rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                    </div>
                    <button type="submit" id="deleteSelectedBtn" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <i class="fas fa-trash-alt mr-2"></i> Delete Selected
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left w-12">Select</th>
                                <th class="px-4 py-3 text-left">Roll No</th>
                                <th class="px-4 py-3 text-left">Student Name</th>
                                <th class="px-4 py-3 text-left">Division</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>" class="student-checkbox w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    </td>
                                    <td class="px-4 py-3 font-medium"><?php echo $row['rollno']; ?></td>
                                    <td class="px-4 py-3"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $row['division'] == 'Fail' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>">
                                            <?php echo $row['division']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="mt-6 flex gap-4">
                <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Students
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const deleteBtn = document.getElementById('deleteSelectedBtn');

    function updateDeleteButton() {
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        deleteBtn.disabled = checkedCount === 0;
        deleteBtn.innerHTML = checkedCount > 0 ?
            `<i class="fas fa-trash-alt mr-2"></i> Delete Selected (${checkedCount})` :
            `<i class="fas fa-trash-alt mr-2"></i> Delete Selected`;
    }

    selectAllCheckbox.addEventListener('change', function() {
        studentCheckboxes.forEach(cb => {
            cb.checked = selectAllCheckbox.checked;
        });
        updateDeleteButton();
    });

    studentCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            updateDeleteButton();
        });
    });

    // Confirm before bulk delete
    document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        if (checkedCount > 0) {
            const confirmMsg = `Are you sure you want to delete ${checkedCount} student(s)? This action cannot be undone!`;
            if (!confirm(confirmMsg)) {
                e.preventDefault();
            }
        }
    });
</script>

<?php include "./includes/footer.php"; ?>