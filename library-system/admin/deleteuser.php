<?php
require_once("../config/database.php");
session_start();

// 1. Security Check: Only logged-in admins can delete
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    /* OPTIONAL SAFETY CHECK: 
       Check if this patron has any active book loans before deleting.
       $checkLoans = $conn->query("SELECT id FROM borrowings WHERE patron_id = $id AND status = 'issued'");
       if($checkLoans->num_rows > 0) {
           header("Location: allusers.php?error=active_loans");
           exit;
       }
    */

    // 3. Prepare the Delete Statement
    $stmt = $conn->prepare("DELETE FROM patrons WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Success: Redirect with a success message
        header("Location: allusers.php?msg=user_deleted");
    } else {
        // Failure: Redirect with an error message
        header("Location: allusers.php?msg=delete_failed");
    }
    $stmt->close();
} else {
    // No ID provided
    header("Location: allusers.php");
}
$conn->close();
