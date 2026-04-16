<?php
include "includes/header.php";
include "includes/sidebar.php";
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Issued Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Issued</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            <?php
                $page = $_GET['page'] ?? '';
                switch ($page) {
                    case 'add':
                        include "";
                        break;
                    
                    default:
                        include "includes/showIssued.php";
                        break;
                }

            ?>
        </div>
    </div>
</div>
<?php
include "includes/footer.php";
?>