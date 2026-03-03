<?php

include 'includes/header.php';
include 'db/dbconnect.php';

$msg = '';

if (isset($_POST['addStudent'])) {

    $name   = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email  = trim($_POST['email']);
    $course = trim($_POST['course']);

    // Basic validation
    if (empty($name) || empty($mobile) || empty($email) || empty($course)) {
        $msg = '<div class="alert alert-danger">All fields are required!</div>';
    } else {

        // 1️⃣ Insert student (Prepared Statement)
        $stmt = $conn->prepare("INSERT INTO students (name, mobile, email, course) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $mobile, $email, $course);

        if ($stmt->execute()) {

            $lastid = $stmt->insert_id;

            // 2️⃣ Generate Roll Number (auto padded)
            $roll = 'BISR' . str_pad($lastid, 4, '0', STR_PAD_LEFT);

            // 3️⃣ Update roll number securely
            $updateStmt = $conn->prepare("UPDATE students SET roll_no = ? WHERE id = ?");
            $updateStmt->bind_param("si", $roll, $lastid);

            if ($updateStmt->execute()) {
                $msg = '<div class="alert alert-success">#' . $roll . ' Student Added Successfully!</div>';
            } else {
                $msg = '<div class="alert alert-danger">Roll Update Failed!</div>';
            }

            $updateStmt->close();
        } else {
            $msg = '<div class="alert alert-danger">Student Failed to Add!</div>';
        }

        $stmt->close();
    }
}
?>



<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 500px; width:100%;">

        <h3 class="text-center mb-4 fw-bold text-primary">Add Student</h3>

        <?php echo $msg; ?>

        <form action="" method="post">

            <!-- Name -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Name" required>
                <label for="name">Full Name</label>
            </div>

            <!-- Mobile -->
            <div class="form-floating mb-3">
                <input type="tel" class="form-control rounded-3" id="mobile" name="mobile" placeholder="Mobile" required>
                <label for="mobile">Mobile Number</label>
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Email" required>
                <label for="email">Email Address</label>
            </div>

            <!-- Course -->
            <div class="form-floating mb-4">
                <input type="text" class="form-control rounded-3" id="course" name="course" placeholder="Course" required>
                <label for="course">Course</label>
            </div>

            <!-- Button -->
            <div class="d-grid">
                <button type="submit" name="addStudent" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                    Add Student
                </button>
            </div>

        </form>

    </div>
</div>

<?php include 'includes/footer.php' ?>