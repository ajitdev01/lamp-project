<?php
session_start();

// LOGIN CHECK
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "./includes/header.php";
// Get logged-in user ID
$user_id = intval($_SESSION['user_id']);

// Fetch bookings for user
$sql = "SELECT * FROM bookings_tbl WHERE user_id = $user_id ";
$result = mysqli_query($conn, $sql);
?>

<!-- Hero Section -->
<section class="py-5 bg-light border-bottom shadow-sm">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">My Bookings</h1>
        <p class="text-muted">View all your confirmed and past train reservations</p>
    </div>
</section>

<!-- Bookings Table -->
<section class="container my-5">

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Your Booking History</h4>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Booking Ref</th>
                            <th>PNR No</th>
                            <th>Train Info</th>
                            <th>Route Info</th>
                            <th>DOJ</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($data = mysqli_fetch_assoc($result)): ?>

                                <tr>
                                    <!-- Booking Ref -->
                                    <td>
                                        <span class="fw-semibold text-dark">#<?= $data['booking_tbl'] ?></span>
                                    </td>

                                    <!-- PNR -->
                                    <td>
                                        <span class="badge bg-success px-3 py-2 fs-6">
                                            <?= $data['pnr_no'] ?>
                                        </span>
                                    </td>

                                    <!-- Train Info -->
                                    <td>
                                        <strong>Train No:</strong> <?= $data['train_no'] ?><br>
                                        <small class="text-muted">ID: <?= $data['train_id'] ?></small>
                                    </td>

                                    <!-- Route Info -->
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        <strong><?= $data['route_id'] ?></strong>
                                    </td>

                                    <!-- Journey Date -->
                                    <td>
                                        <span class="fw-semibold">
                                            <?= date("d M Y", strtotime($data['doj'])) ?>
                                        </span>
                                    </td>

                                    <!-- Action Button -->
                                    <td class="text-center">
                                        <a href="ticket.php?booking_tbl=<?= $data['booking_tbl'] ?>"
                                            class="btn btn-sm btn-primary px-3">
                                            <i class="fas fa-file-alt me-1"></i> View Ticket
                                        </a>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        <?php else: ?>

                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076508.png"
                                        width="90" class="mb-3 opacity-75">
                                    <h5 class="text-muted">No bookings found</h5>
                                    <p class="text-secondary">Book your first train ticket to view it here.</p>
                                    <a href="index.php" class="btn btn-primary mt-3">Search Trains</a>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-primary px-4">
            <i class="fas fa-train me-1"></i> Book Another Train
        </a>
    </div>

</section>

<?php include "./includes/footer.php"; ?>