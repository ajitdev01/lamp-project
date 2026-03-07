<?php
if (isset($_GET['ref'])) {
    $ref = $_GET['ref'];
    $sqlf = "SELECT * FROM routes_tbl WHERE route_id=$ref";
    $resultf = mysqli_query($conn, $sqlf);
    if ($resultf) {
        $data = mysqli_fetch_assoc($resultf);
    } else {
        echo "eroorrrr";
    }
}


if (isset($_POST['edit'])) {
    $start = $_POST['start_from'];
    $end = $_POST['end_to'];
    $distance = $_POST['distance'];

    $sql = " UPDATE routes_tbl SET route_start = '$start', route_end = '$end', route_distance = '$distance' WHERE route_id = $ref";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div id="alert" class="alert alert-success">Route Successfully Updated!</div>';
    } else {
        $msg = '<div id="alert"  class="alert alert-danger">Route Adding Error!</div>';
    }
}
?>
<div class="card mb-4">
    <div class="card-body">
        <a href="index.php" class="btn btn-secondary">Back</a>
        <a href="routes.php" class="btn btn-primary">Routes</a>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <form action="" method="post">
            <h1>Edit Route Form</h1>
            <?php if (!empty($msg)) {
                echo $msg;
            } ?>
            <div class="row">
                <div class="col-4">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="start">Starts From:</label>
                                <input type="text" value="<?= $data['route_start'] ?>" placeholder="Starting Station" class="form-control" name="start_from" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="start">End To:</label>
                                <input type="text" value="<?= $data['route_end'] ?>" placeholder="Ending Station" class="form-control" name="end_to" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="start">Distance (KM):</label>
                                <input type="number" placeholder="ex:101" value="<?= $data['route_distance'] ?>" class="form-control" name="distance" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <button class="btn btn-primary" type="submit" name="edit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbWsw34qQmjAOdh2ywgWh7tHdyi_V7LTPYvw&s" alt="">
                </div>
            </div>
        </form>
    </div>
</div>