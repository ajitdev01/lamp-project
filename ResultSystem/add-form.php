<?php
include "includes/header.php";
include "./db/db.php";



$msg = '';
$msgType = '';

if (isset($_POST['add'])) {
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

    // Validate marks range (0-100)
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
        // Check if rollno already exists
        $checkQuery = "SELECT id FROM students_tbl WHERE rollno = $rollno";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $msg = "Roll Number $rollno already exists!";
            $msgType = 'error';
        } else {
            $obmarks = $math + $sc + $ssc + $eng + $hnd;
            $per = ($obmarks / 500) * 100;

            // Division logic with individual passing marks (33% passing)
            if ($math < 33 || $sc < 33 || $ssc < 33 || $eng < 33 || $hnd < 33) {
                $div = "Fail";
                $grade = "F";
                $gradePoint = 0.00;
            } else {
                // Division based on percentage
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

            $query = "INSERT INTO students_tbl (rollno, name, fname, mname, dob, math, sc, ssc, eng, hnd, obmarks, percentage, division, grade, grade_point) 
                      VALUES ($rollno, '$name', '$fname', '$mname', '$dob', $math, $sc, $ssc, $eng, $hnd, $obmarks, $per, '$div', '$grade', $gradePoint)";

            $result = mysqli_query($conn, $query);
            if ($result) {
                $msg = "Student record added successfully!";
                $msgType = 'success';
                // Clear form fields after successful submission
                echo '<script>setTimeout(function() { window.location.href = "add-form.php?success=1"; }, 1500);</script>';
            } else {
                $msg = "Failed to add student: " . mysqli_error($conn);
                $msgType = 'error';
            }
        }
    }
}

$showSuccess = isset($_GET['success']) && $_GET['success'] == 1;
?>

<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-graduate text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">Add New Student</h1>
                <p class="text-blue-100 text-sm mt-1">Fill in the details below to register a student</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <?php if ($msg && $msgType == 'error'): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                <span><?php echo $msg; ?></span>
            </div>
        <?php endif; ?>

        <?php if ($showSuccess || ($msg && $msgType == 'success')): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                <span><?php echo $showSuccess ? "Student record added successfully!" : $msg; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            <!-- Personal Information Section -->
            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-500"></i> Personal Information
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-gray-400 mr-1"></i> Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Enter student name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hashtag text-gray-400 mr-1"></i> Roll Number <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="rollno" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Enter roll number">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-gray-400 mr-1"></i> Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="dob" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-venus-mars text-gray-400 mr-1"></i> Gender
                    </label>
                    <select class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <!-- Parents Information -->
            <div class="border-b border-gray-200 pb-4 mt-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-family text-blue-500"></i> Parents Information
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-father text-gray-400 mr-1"></i> Father's Name
                    </label>
                    <input type="text" name="fname" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Enter father's name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-mother text-gray-400 mr-1"></i> Mother's Name
                    </label>
                    <input type="text" name="mname" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="Enter mother's name">
                </div>
            </div>

            <!-- Marks Section -->
            <div class="border-b border-gray-200 pb-4 mt-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-500"></i> Subject Marks (Out of 100)
                </h2>
                <p class="text-sm text-gray-500 mt-1">Minimum passing marks: 33 in each subject</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calculator text-gray-400 mr-1"></i> Mathematics
                    </label>
                    <input type="number" name="math" required min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="0-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flask text-gray-400 mr-1"></i> Science
                    </label>
                    <input type="number" name="sc" required min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="0-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-globe text-gray-400 mr-1"></i> Social Science
                    </label>
                    <input type="number" name="ssc" required min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="0-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-language text-gray-400 mr-1"></i> English
                    </label>
                    <input type="number" name="eng" required min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="0-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-om text-gray-400 mr-1"></i> Hindi
                    </label>
                    <input type="number" name="hnd" required min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition" placeholder="0-100">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" name="add" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Student Record
                </button>
                <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                    <i class="fas fa-undo-alt"></i> Reset
                </button>
                <a href="students-list.php" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl font-medium transition flex items-center gap-2">
                    <i class="fas fa-list"></i> View All Students
                </a>
            </div>
        </form>
    </div>
</div>

<?php include "./includes/footer.php"; ?>