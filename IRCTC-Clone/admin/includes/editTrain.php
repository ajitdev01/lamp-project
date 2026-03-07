<?php


if (isset($_GET['ref'])) {
    $ref = $_GET['ref'];
    $sqlf = "SELECT * FROM trains_tbl WHERE train_id=$ref";
    $resultf = mysqli_query($conn, $sqlf);
    if ($resultf) {
        $data = mysqli_fetch_assoc($resultf);
    } else {
        echo "eroorrrr";
    }
}


if (isset($_POST['edit'])) {
    $train_no = $_POST['train_no'];
    $train_name = $_POST['train_name'];
    $train_route = $_POST['train_route'];
    $ac = $_POST['ac'];
    $sl = $_POST['sl'];
    $gn = $_POST['gn'];
    $total = $ac + $sl + $gn;
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];

    $sql = "UPDATE `trains_tbl` SET `train_number`='$train_no',`train_name`='$train_name',`train_route_id`='$train_route',`train_ac_capacity`='$ac',`train_sl_capacity`='$sl',`train_gn_capacity`='$gn',`train_total_capacity`='$total',`train_stime`='$stime',`train_etime`='$etime' WHERE train_id = $ref ";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div id="alert" class="alert alert-success">Route Successfully Updated!</div>';
    } else {
        $msg = '<div id="alert" class="alert alert-danger">Route Adding Error!</div>';
    }
}
?>

<div class="card mb-4 shadow-sm">
    <div class="card-body d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
        <a href="trains.php" class="btn btn-primary"><i class="fas fa-train me-2"></i>Trains</a>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white text-center py-3">
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Train Information</h4>
    </div>
    <div class="card-body p-4">
        <form action="" method="post">
            <h1 class="text-center mb-4 d-none">Add Train Form</h1> <?php if (!empty($msg)) {
                echo $msg;
            } ?>
            
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="train_no" class="form-label fw-bold">Train Number:</label>
                        <input type="text" value="<?= $data['train_number'] ?>" placeholder="Train Number" class="form-control" name="train_no" required>
                    </div>

                    <div class="mb-3">
                        <label for="train_name" class="form-label fw-bold">Train Name:</label>
                        <input type="text" value="<?= $data['train_name'] ?>" placeholder="Train Name" class="form-control" name="train_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="train_route" class="form-label fw-bold">Train Route:</label>
                        <select name="train_route" id="train_route" class="form-select" required>
                            <?php
                            $sqlr = "SELECT * FROM routes_tbl";
                            $resultr = mysqli_query($conn, $sqlr);
                            if (mysqli_num_rows($resultr) > 0) {
                                while ($datar = mysqli_fetch_assoc($resultr)) {
                                    $selected = ($datar['route_id'] == $data['train_route_id']) ? 'selected' : '';
                            ?>
                                    <option value="<?= $datar['route_id'] ?>" <?= $selected ?>>
                                        <?= $datar['route_start'] ?> - <?= $datar['route_end'] ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <fieldset class="border p-3 rounded-3 mb-3">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary">Seat Information</legend>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="ac" class="form-label">AC:</label>
                                <input type="number" value="<?= $data['train_ac_capacity'] ?>" placeholder="e.g., 101" class="form-control" name="ac" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sl" class="form-label">SL:</label>
                                <input type="number" value="<?= $data['train_sl_capacity'] ?>" placeholder="e.g., 101" class="form-control" name="sl" required>
                            </div>
                            <div class="col-md-4">
                                <label for="gn" class="form-label">GN:</label>
                                <input type="number" value="<?= $data['train_gn_capacity'] ?>" placeholder="e.g., 101" class="form-control" name="gn" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="border p-3 rounded-3 mb-4">
                        <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary">Train Timing</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="stime" class="form-label">Starting Time:</label>
                                <input type="time" value="<?= $data['train_stime'] ?>" class="form-control" name="stime" required>
                            </div>
                            <div class="col-md-6">
                                <label for="etime" class="form-label">Ending Time:</label>
                                <input type="time" value="<?= $data['train_etime'] ?>" class="form-control" name="etime" required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-grid">
                        <button class="btn btn-success btn-lg" type="submit" name="edit"><i class="fas fa-save me-2"></i>Update Train</button>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <img src="https://cdn.britannica.com/28/233928-050-CC617C2B/high-speed-railway-commuter-train.jpg" class="img-fluid rounded-4 shadow-lg" alt="High-speed commuter train" style="max-height: 500px; object-fit: cover;">
                </div>
            </div>
        </form>
    </div>
</div>