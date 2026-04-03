<?php
// edit-student.php - Edit Student Record with Modern UI
include "./includes/header.php";
include "./db/db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$msg = '';
$msgType = '';

// Fetch existing student data
$query = "SELECT * FROM students_tbl WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo '<div class="max-w-7xl mx-auto px-4 py-12 text-center">
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-2"></i>
                    <h2 class="text-xl font-bold text-gray-800">Student Not Found</h2>
                    <p class="text-gray-600 mt-2">The requested student record does not exist.</p>
                    <a href="all-students.php" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Back to Directory</a>
                </div>
              </div>';
    include "footer.php";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Process update form
if (isset($_POST['update'])) {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $rollno = (int)$_POST['rollno'];
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $math = (int)$_POST['math'];
    $sc = (int)$_POST['sc'];
    $ssc = (int)$_POST['ssc'];
    $eng = (int)$_POST['eng'];
    $hnd = (int)$_POST['hnd'];

    // Validate marks range
    $subjects = ['math' => $math, 'sc' => $sc, 'ssc' => $ssc, 'eng' => $eng, 'hnd' => $hnd];
    $valid = true;
    foreach ($subjects as $sub => $mark) {
        if ($mark < 0 || $mark > 100) {
            $valid = false;
            $msg = ucfirst($sub) . " marks must be between 0 and 100!";
            $msgType = 'error';
            break;
        }
    }

    if ($valid) {
        // Check if rollno already exists for another student
        $checkQuery = "SELECT id FROM students_tbl WHERE rollno = $rollno AND id != $id";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $msg = "Roll Number $rollno already exists for another student!";
            $msgType = 'error';
        } else {
            $obmarks = $math + $sc + $ssc + $eng + $hnd;
            $per = ($obmarks / 500) * 100;

            // Division logic
            if ($math < 33 || $sc < 33 || $ssc < 33 || $eng < 33 || $hnd < 33) {
                $div = "Fail";
                $grade = "F";
                $gradePoint = 0.00;
            } else {
                if ($per >= 60) {
                    $div = "First Division";
                    $grade = $per >= 75 ? "A+" : "A";
                    $gradePoint = $per >= 75 ? 9.0 : 8.0;
                } else if ($per >= 45) {
                    $div = "Second Division";
                    $grade = "B";
                    $gradePoint = 6.0;
                } else if ($per >= 33) {
                    $div = "Third Division";
                    $grade = "C";
                    $gradePoint = 5.0;
                } else {
                    $div = "Fail";
                    $grade = "F";
                    $gradePoint = 0.00;
                }
            }

            $query = "UPDATE students_tbl SET 
                        rollno = $rollno,
                        name = '$name',
                        fname = '$fname',
                        mname = '$mname',
                        dob = '$dob',
                        math = $math,
                        sc = $sc,
                        ssc = $ssc,
                        eng = $eng,
                        hnd = $hnd,
                        obmarks = $obmarks,
                        percentage = $per,
                        division = '$div',
                        grade = '$grade',
                        grade_point = $gradePoint
                      WHERE id = $id";

            $result = mysqli_query($conn, $query);
            if ($result) {
                $msg = "Student record updated successfully!";
                $msgType = 'success';
                // Refresh data
                $query = "SELECT * FROM students_tbl WHERE id = $id";
                $result = mysqli_query($conn, $query);
                $data = mysqli_fetch_assoc($result);
            } else {
                $msg = "Failed to update: " . mysqli_error($conn);
                $msgType = 'error';
            }
        }
    }
}
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="index.php" class="hover:text-blue-600 transition"><i class="fas fa-home"></i> Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="all-students.php" class="hover:text-blue-600 transition">All Students</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800 font-medium">Edit Student</span>
    </nav>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Edit Student Record</h1>
                        <p class="text-amber-100 text-sm mt-1">Update information for <?php echo htmlspecialchars($data['name']); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="marksheet.php?ref=<?php echo $data['id']; ?>" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-file-alt"></i> View Marksheet
                    </a>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Alert Messages -->
            <?php if ($msg): ?>
                <div class="mb-6 p-4 rounded-lg flex items-start gap-3 <?php echo $msgType == 'success' ? 'bg-green-50 border-l-4 border-green-500 text-green-700' : 'bg-red-50 border-l-4 border-red-500 text-red-700'; ?>">
                    <i class="fas <?php echo $msgType == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mt-0.5"></i>
                    <span><?php echo $msg; ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-6">
                <!-- Personal Information Section -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-circle text-amber-500"></i> Personal Information
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user text-gray-400 mr-1"></i> Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required value="<?php echo htmlspecialchars($data['name']); ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-hashtag text-gray-400 mr-1"></i> Roll Number <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="rollno" required value="<?php echo $data['rollno']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar text-gray-400 mr-1"></i> Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="dob" required value="<?php echo $data['dob']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>
                </div>

                <!-- Parents Information -->
                <div class="border-b border-gray-200 pb-4 mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-family text-amber-500"></i> Parents Information
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-father text-gray-400 mr-1"></i> Father's Name
                        </label>
                        <input type="text" name="fname" value="<?php echo htmlspecialchars($data['fname']); ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition"
                            placeholder="Enter father's name">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-mother text-gray-400 mr-1"></i> Mother's Name
                        </label>
                        <input type="text" name="mname" value="<?php echo htmlspecialchars($data['mname']); ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition"
                            placeholder="Enter mother's name">
                    </div>
                </div>

                <!-- Marks Section -->
                <div class="border-b border-gray-200 pb-4 mt-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-chart-line text-amber-500"></i> Subject Marks (Out of 100)
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Minimum passing marks: 33 in each subject</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calculator text-gray-400 mr-1"></i> Mathematics
                        </label>
                        <input type="number" name="math" required min="0" max="100" value="<?php echo $data['math']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flask text-gray-400 mr-1"></i> Science
                        </label>
                        <input type="number" name="sc" required min="0" max="100" value="<?php echo $data['sc']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe text-gray-400 mr-1"></i> Social Science
                        </label>
                        <input type="number" name="ssc" required min="0" max="100" value="<?php echo $data['ssc']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-language text-gray-400 mr-1"></i> English
                        </label>
                        <input type="number" name="eng" required min="0" max="100" value="<?php echo $data['eng']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-om text-gray-400 mr-1"></i> Hindi
                        </label>
                        <input type="number" name="hnd" required min="0" max="100" value="<?php echo $data['hnd']; ?>"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                    </div>
                </div>

                <!-- Current Performance Preview -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mt-4">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-chart-simple text-blue-600"></i> Current Performance Preview
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-xs text-gray-500">Total Marks</p>
                            <p class="text-xl font-bold text-gray-800"><?php echo $data['obmarks']; ?>/500</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Percentage</p>
                            <p class="text-xl font-bold <?php echo $data['percentage'] >= 60 ? 'text-green-600' : ($data['percentage'] >= 33 ? 'text-yellow-600' : 'text-red-600'); ?>">
                                <?php echo round($data['percentage'], 1); ?>%
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Division</p>
                            <p class="text-sm font-semibold <?php echo $data['division'] != 'Fail' ? 'text-green-600' : 'text-red-600'; ?>">
                                <?php echo $data['division']; ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Grade</p>
                            <p class="text-xl font-bold text-indigo-600"><?php echo $data['grade'] ?: 'N/A'; ?></p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 text-center mt-3">
                        <i class="fas fa-info-circle"></i> These values will be automatically recalculated when you save changes
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" name="update" class="bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center gap-2">
                        <i class="fas fa-save"></i> Update Record
                    </button>
                    <a href="all-students.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="button" onclick="confirmDelete(<?php echo $data['id']; ?>, '<?php echo addslashes($data['name']); ?>')"
                        class="ml-auto bg-red-50 hover:bg-red-100 text-red-600 px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Delete Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 transition-all">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="deleteModalContent">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">Delete Student</h3>
            </div>
            <p class="text-gray-600 mb-6">Are you sure you want to delete <span id="deleteStudentName" class="font-semibold"></span>? This action cannot be undone and will remove all associated records.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                <a href="#" id="deleteConfirmLink" class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center px-4 py-2 rounded-xl transition">Delete Permanently</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(studentId, studentName) {
        document.getElementById('deleteStudentName').textContent = studentName;
        document.getElementById('deleteConfirmLink').href = 'delete-student.php?id=' + studentId + '&redirect=edit';
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Auto-dismiss alerts after 3 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 3000);
</script>

<?php include "./includes/footer.php"; ?>