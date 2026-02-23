<?php
require_once("../config/database.php");
session_start();

// Security: Only Admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 1. Get image name to delete the file from server
    $res = $conn->query("SELECT image FROM books WHERE id = $id");
    $book = $res->fetch_assoc();

    if ($book['image'] != 'default.png') {
        @unlink("../assets/Images/" . $book['image']);
    }

    // 2. Delete from database
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: allbooks.php?status=deleted");
    } else {
        header("Location: allbooks.php?status=error");
    }
}
