<?php include "includes/header.php"; ?>
<main>
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h1 class="mb-0">Trains</h1>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Trains</li>
        </ol>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <?php
                $page = $_GET['page'] ?? '';

                switch ($page) {
                    case 'add':
                        // Updated addTrain.php content with improved UI
                        include_once 'includes/addTrain.php';
                        break;
                    case 'edit':
                        // A placeholder for the editTrain.php content with a better UI
                        include 'includes/editTrain.php';
                        break;
                    default:
                        // A placeholder for the allTrains.php content with a better UI
                        include 'includes/allTrains.php';
                        break;
                }
                ?>
            </div>
        </div>
        </div>
</main>
<?php include "includes/footer.php"; ?>