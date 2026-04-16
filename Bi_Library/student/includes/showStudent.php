<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Student's Data | <a href="?page=add" class="btn btn-sm btn-primary">Add Student</a>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $query = "SELECT * FROM students_tbl";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {

                ?>
                        <tr>
                            <td><?= $data['st_id'] ?></td>
                            <td><?= $data['st_name'] ?></td>
                            <td><?= $data['st_email'] ?></td>
                            <td><img src="<?= $data['st_image'] ?>" alt=""></td>
                            <td><span class="badge bg-primary"><?= $data['st_status'] ?></span></td>
                            <td><?= date('d-M-Y', strtotime($data['created_at'])) ?></td>
                            <td>
                                <a href="" class="btn btn-sm btn-info">Edit</a>
                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                <?php

                    }
                } else {
                    echo "No Data Found";
                } ?>
            </tbody>
        </table>
    </div>
</div>