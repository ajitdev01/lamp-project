<?php
$msg = '';
if (isset($_POST['addBook'])) {
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_isbn = $_POST['book_isbn'];
    $book_description = mysqli_escape_string($conn, $_POST['book_description']);
    $book_edition = $_POST['book_edition'];
    $book_pyear = $_POST['book_pyear'];
    $book_pages = $_POST['book_pages'];
    $book_instock = $_POST['book_instock'] ?? 0;

    $book_imgname = time(). "_" .$_FILES['book_image']['name'];
    $book_tmpname = $_FILES['book_image']['tmp_name'];
    $lb_id = $_SESSION['lb_id'];


    $query = "INSERT INTO books_tbl (book_title, book_author, book_isbn, book_edition, book_description, book_image, book_pyear, book_pages, book_instock, librarian_id) VALUES('$book_title', '$book_author', '$book_isbn', '$book_edition', '$book_description', '$book_imgname', '$book_pyear', '$book_pages', '$book_instock', '$lb_id')";
    if (mysqli_query($conn, $query)) {
        move_uploaded_file($book_tmpname, '../assets/books/'.$book_imgname);
        $msg = '<div class="alert alert-success">Book Added Successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Book Added Failed!</div>';
    }
}
?>
<div class="container">
    <h3>Add Book Form</h3>
    <?php echo $msg; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Book Title -->
        <div class="mb-3">
            <label for="book_title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="book_title" name="book_title" placeholder="Enter book title" maxlength="255" required>
        </div>

        <div class="row">
            <!-- Book Author -->
            <div class="col-4 mb-3">
                <label for="book_author" class="form-label">Author</label>
                <input type="text" class="form-control" id="book_author" name="book_author" placeholder="Enter author name" maxlength="255" required>
            </div>

            <!-- Book ISBN -->
            <div class="col-4 mb-3">
                <label for="book_isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="book_isbn" name="book_isbn" placeholder="e.g. 978-3-16-148410-0" maxlength="55">
            </div>

            <!-- Book Edition -->
            <div class="col-4 mb-3">
                <label for="book_edition" class="form-label">Edition</label>
                <input type="text" class="form-control" id="book_edition" name="book_edition" placeholder="e.g. 3rd Edition" maxlength="55">
            </div>
        </div>

        <!-- Book Description -->
        <div class="mb-3">
            <label for="book_description" class="form-label">Description</label>
            <textarea class="form-control" id="book_description" name="book_description" rows="5" placeholder="Enter book description"></textarea>
        </div>

        <div class="row">
            <!-- Book Image URL -->
            <div class=" col-4 mb-3">
                <label for="book_image" class="form-label">Book Image</label>
                <input type="file" class="form-control" id="book_image" name="book_image">
            </div>

            <!-- Publication Year -->
            <div class=" col-4 mb-3">
                <label for="book_pyear" class="form-label">Publication Year</label>
                <input type="number" class="form-control" id="book_pyear" name="book_pyear" placeholder="e.g. 2023" min="1000" max="9999">
            </div>

            <!-- Book Pages -->
            <div class=" col-4 mb-3">
                <label for="book_pages" class="form-label">Number of Pages</label>
                <input type="number" class="form-control" id="book_pages" name="book_pages" placeholder="e.g. 350" min="1">
            </div>
        </div>

        <!-- In Stock -->
        <div class="mb-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="book_instock" name="book_instock" value="1" checked>
                <label class="form-check-label" for="book_instock">In Stock</label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="addBook" class="btn btn-primary px-4">Add Book</button>
        <button type="reset" class="btn btn-outline-secondary px-4 ms-2">Reset</button>
    </form>
</div>