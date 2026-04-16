<?php
include "includes/header.php";
include "includes/sidebar.php";
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Student Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Student</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <?php
                $page = $_GET['page'] ?? '';
                switch ($page) {
                    case 'add':
                        include "includes/addStudent.php";
                        break;
                    
                    default:
                        include "includes/showStudent.php";
                        break;
                }

            ?>
        </div>
    </div>
</div>
<?php
include "includes/footer.php";
?>