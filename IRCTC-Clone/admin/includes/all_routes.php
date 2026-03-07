 <div class="card mb-4">
     <div class="card-body">
         <a href="index.php" class="btn btn-secondary">Back</a>
         <a href="?page=add" class="btn btn-primary">Add New Route</a>
     </div>
 </div>
 <div class="card mb-4">
     <div class="card-header">
         <i class="fas fa-table me-1"></i>
         DataTable Example
     </div>
     <div class="card-body">
         <table id="datatablesSimple">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>Start From</th>
                     <th>End To</th>
                     <th>Distance</th>
                     <th>TimeStamp</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tfoot>
                 <tr>
                     <th>#</th>
                     <th>Start From</th>
                     <th>End To</th>
                     <th>Distance</th>
                     <th>TimeStamp</th>
                     <th>Actions</th>
                 </tr>
             </tfoot>
             <tbody>
                 <?php
                    $sql = "SELECT * FROM routes_tbl";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {

                    ?>

                         <tr>
                             <td><?= $data['route_id'] ?></td>
                             <td><?= $data['route_start'] ?></td>
                             <td><?= $data['route_end'] ?></td>
                             <td><?= $data['route_distance'] ?> KM</td>
                             <td>
                                 <span>
                                     Created at: <?= date('d-m-Y h:i A', strtotime($data['created_at'])) ?><br>
                                     Updated at: <?php if (!empty($data['updated_at'])) {
                                                        echo date('d-m-Y h:i A', strtotime($data['updated_at']));
                                                    } ?>
                                 </span>
                             </td>
                             <td>
                                 <a href="?page=edit&ref=<?= $data['route_id'] ?>" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Edit</a>
                                 <a href="?delete=<?= $data['route_id'] ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Delete</a>
                             </td>
                         </tr>
                 <?php

                        }
                    } else {
                        echo "No Data Found!";
                    }
                    ?>

             </tbody>
         </table>
     </div>
 </div>

 <?php
    if (isset($_GET['delete'])) {
        $ref = $_GET['delete'];
        $sql = "DELETE FROM routes_tbl WHERE route_id = $ref";
        if (mysqli_query($conn, $sql)) {
            $message = '<div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">  Route Deleted Successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            header("Location: routes.php");
        }
    }
    ?>