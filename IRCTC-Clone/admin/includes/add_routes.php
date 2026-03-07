<?php
if(isset($_POST['add'])){
    $start = $_POST['start_from'];
    $end = $_POST['end_to'];
    $distance = $_POST['distance'];

    $sql= "INSERT INTO `routes_tbl`(`route_start`, `route_end`, `route_distance`) VALUES ('$start', '$end', '$distance')";
    if(mysqli_query($conn, $sql)){
        $message='<div id="alert" class="alert alert-success">Route Successfully Added!</div>';
    }else{
        $message= '<div id="alert" class="alert alert-danger">Route Adding Error!</div>';
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
        <form action="" method="post" class="container mt-5">
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-primary text-white text-center">
      <h3 class="mb-0">Add Route</h3>
    </div>
    <div class="card-body">
      <?php if (!empty($message)) { echo '<div class="alert alert-info">'.$message.'</div>'; } ?>
      
      <div class="row">
        <div class="col-md-6">
          <!-- Starts From -->
          <div class="form-group mb-3">
            <label for="start_from" class="form-label">Starts From:</label>
            <input type="text" placeholder="Starting Station" class="form-control" id="start_from" name="start_from" required>
          </div>
          <!-- End To -->
          <div class="form-group mb-3">
            <label for="end_to" class="form-label">End To:</label>
            <input type="text" placeholder="Ending Station" class="form-control" id="end_to" name="end_to" required>
          </div>
          <!-- Distance -->
          <div class="form-group mb-3">
            <label for="distance" class="form-label">Distance (KM):</label>
            <input type="number" placeholder="ex: 101" class="form-control" id="distance" name="distance" required>
          </div>
          <!-- Submit Button -->
          <div class="d-grid">
            <button class="btn btn-primary btn-lg" type="submit" name="add">Submit</button>
          </div>
        </div>
        
        <!-- Image Section -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbWsw34qQmjAOdh2ywgWh7tHdyi_V7LTPYvw&s" class="img-fluid" style="max-height: 250px;" alt="Route Illustration">
        </div>
      </div>
    </div>
  </div>
</form>

     </div>
 </div>