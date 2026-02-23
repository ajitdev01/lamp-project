<?php
ob_start();
session_start();
include "./config/database.php";

// Validation
if (!isset($_SESSION['patron_id']) || !isset($_POST['confirm_request'])) {
    $_SESSION['msg'] = '<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">Invalid request</div>';
    header("Location: books.php");
    exit();
}

$patron_id = $_SESSION['patron_id'];
$book_id = mysqli_real_escape_string($conn, $_POST['book_id']);

// Check book availability
$book_res = mysqli_query($conn, "SELECT title, available_quantity FROM books WHERE id = '$book_id'");
$book = mysqli_fetch_assoc($book_res);

if (!$book || $book['available_quantity'] <= 0) {
    $_SESSION['msg'] = '<div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">Book unavailable</div>';
    header("Location: books.php");
    exit();
}

// Check existing requests
$check_sql = "SELECT id FROM requests WHERE patron_id = '$patron_id' AND book_id = '$book_id' AND status IN ('Pending', 'Approved') LIMIT 1";
if (mysqli_num_rows(mysqli_query($conn, $check_sql)) > 0) {
    $_SESSION['msg'] = '<div class="mb-6 p-4 bg-yellow-50 border alert border-yellow-200 text-yellow-700 rounded-lg">Request already exists</div>';
    header("Location: books.php");
    exit();
}

// Insert request
$request_sql = "INSERT INTO requests (patron_id, book_id, status, request_date) VALUES ('$patron_id', '$book_id', 'Pending', NOW())";

if (mysqli_query($conn, $request_sql)) {
    $_SESSION['msg'] = '<div class="mb-6 p-4 bg-green-50 border alert border-green-200 text-green-700 rounded-lg">Request submitted successfully</div>';
} else {
    $_SESSION['msg'] = '<div class="mb-6 p-4 bg-red-50 border alert border-red-200 text-red-700 rounded-lg">System error</div>';
}

header("Location: books.php");
exit();
