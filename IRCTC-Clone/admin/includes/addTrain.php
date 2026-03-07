<?php
if (isset($_POST['add'])) {
    $train_no = $_POST['train_no'];
    $train_name = $_POST['train_name'];
    $train_route = $_POST['train_route'];
    $ac = $_POST['ac'];
    $sl = $_POST['sl'];
    $gn = $_POST['gn'];
    $total = $ac + $sl + $gn;
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];

    $sql = "INSERT INTO `trains_tbl`(`train_number`, `train_name`, `train_route_id`,`train_ac_capacity`, `train_sl_capacity`, `train_gn_capacity`, `train_total_capacity`, `train_stime`, `train_etime`)
      VALUES ('$train_no', '$train_name', '$train_route', '$ac', '$sl', '$gn', '$total', '$stime', '$etime')";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div id="alert" class="alert alert-success">Train Successfully Added!</div>';
    } else {
        $msg = '<div  id="alert" class="alert alert-danger">Route Adding Error!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Train</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="d-flex justify-content-between mb-4">
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
        <a href="trains.php" class="btn btn-primary">
            <i class="fas fa-train me-2"></i>Trains
        </a>
    </div>

    <div class="card p-4">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4 class="mb-0"><i class="fas fa-table me-2"></i>Add New Train</h4>
        </div>
        <div class="card-body p-4">
            <form action="" method="post">
                <?php if (!empty($msg)) { echo $msg; } ?>
                
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="train_no" class="form-label fw-bold">Train Number:</label>
                            <input type="text" id="train_no" placeholder="e.g., 12345" class="form-control" name="train_no" required>
                        </div>

                        <div class="mb-3">
                            <label for="train_name" class="form-label fw-bold">Train Name:</label>
                            <input type="text" id="train_name" placeholder="e.g., Express Train" class="form-control" name="train_name" required>
                        </div>
        
                        <div class="mb-3">
                            <label for="train_route" class="form-label fw-bold">Train Route:</label>
                            <select name="train_route" id="train_route" class="form-select" required>
                                <option value="" disabled selected>Select Route</option>
                                <?php
                                $sqlr = "SELECT * FROM routes_tbl";
                                $resultr = mysqli_query($conn, $sqlr);
                                if (mysqli_num_rows($resultr) > 0) {
                                    while ($datar = mysqli_fetch_assoc($resultr)) {
                                ?>
                                <option value="<?= $datar['route_id'] ?>"><?= $datar['route_start'] ?> - <?= $datar['route_end'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
        
                        <fieldset class="border p-3 rounded-3 mb-3">
                            <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary">Seat Information</legend>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="ac" class="form-label">AC:</label>
                                    <input type="number" id="ac" placeholder="e.g., 100" class="form-control" name="ac" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="sl" class="form-label">SL:</label>
                                    <input type="number" id="sl" placeholder="e.g., 200" class="form-control" name="sl" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="gn" class="form-label">GN:</label>
                                    <input type="number" id="gn" placeholder="e.g., 300" class="form-control" name="gn" required>
                                </div>
                            </div>
                        </fieldset>
        
                        <fieldset class="border p-3 rounded-3 mb-4">
                            <legend class="float-none w-auto px-2 fs-6 fw-bold text-primary">Train Timing</legend>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="stime" class="form-label">Starting Time:</label>
                                    <input type="time" id="stime" class="form-control" name="stime" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="etime" class="form-label">Ending Time:</label>
                                    <input type="time" id="etime" class="form-control" name="etime" required>
                                </div>
                            </div>
                        </fieldset>
        
                        <div class="d-grid">
                            <button class="btn btn-success btn-lg" type="submit" name="add">
                                <i class="fas fa-plus-circle me-2"></i>Add Train
                            </button>
                        </div>
                    </div>
        
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                         <img src="https://static.toiimg.com/photo/msid-108969842,width-96,height-65.cms" class="img-fluid rounded-4 shadow-lg" alt="Train image" style="max-height: 500px; object-fit: cover;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>