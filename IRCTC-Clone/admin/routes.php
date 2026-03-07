<?php
include "includes/header.php";
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Routes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Routes</li>
        </ol>
        <!-- switch logic  -->
        <?php
        $page = $_GET['page'] ?? '';
        switch ($page) {
            case 'add':
                include 'includes/add_routes.php';
                break;
            case 'edit':
                include 'includes/editRoute.php';
                break;
            default:
                include 'includes/all_routes.php';
                break;
        }
        ?>
        <!-- switch logic  -->
    </div>
</main>

<?php
include "includes/footer.php";
?>