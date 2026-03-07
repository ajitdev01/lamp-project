 <div class="card mb-4">
     <div class="card-body">
         <a href="index.php" class="btn btn-secondary">Back</a>
         <a href="?page=add" class="btn btn-primary">Add New Train</a>
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
                     <th>Train No</th>
                     <th>Train Name</th>
                     <th>Seat Info</th>
                     <th>TimeStamp</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tfoot>
                 <tr>
                     <th>#</th>
                     <th>Train No</th>
                     <th>Train Name</th>
                     <th>Seat Info</th>
                     <th>TimeStamp</th>
                     <th>Actions</th>
                 </tr>
             </tfoot>
             <tbody>
                 <?php
                    $sql = "SELECT * FROM trains_tbl";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {

                    ?>

                         <tr>
                             <td><?= $data['train_id'] ?></td>
                             <td><?= $data['train_number'] ?></td>
                             <td><?= $data['train_name'] ?></td>
                             <td>
                                 AC: <?= $data['train_ac_capacity'] ?>
                                 SL: <?= $data['train_sl_capacity'] ?>
                                 GN: <?= $data['train_gn_capacity'] ?> <br>
                                 <b>Total: <?= $data['train_total_capacity'] ?></b>
                             </td>
                             <td>
                                 <span>
                                     Created at: <?= date('d-m-Y h:i A', strtotime($data['created_at'])) ?><br>
                                     Updated at: <?php if (!empty($data['updated_at'])) {
                                                        echo date('d-m-Y h:i A', strtotime($data['updated_at']));
                                                    } ?>
                                 </span>
                             </td>
                             <td>
                                 <a href="?page=edit&ref=<?= $data['train_id'] ?>" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> Edit</a>
                                 <a href="?delete=<?= $data['train_id'] ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Delete</a>
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
        $sql = "DELETE FROM trains_tbl WHERE train_id = $ref";
        if (mysqli_query($conn, $sql)) {
            echo "Deleted";
            header("Location: trains.php");
        }
    }
    ?>