<?php
require("controller_Book.php");
if (isset($_GET['updateBookID'])) {
    $book_ID = $_GET['updateBookID'];
    $book = get_BookWithID($_GET['updateBookID']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col p-0">
                <?php
                include("navbar.php");
                ?>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col d-flex justify-content-center">
                <div class="card text-center w-50">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="view_indexBook.php">Book List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="view_updateBook.php?updateBookID=<?php echo $book_ID; ?>">Update Book</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1 class="text-center">Update Book</h1>
                        <form action="controller_Book.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="book_ID" value="<?php echo $book_ID; ?>">
                            <input type="hidden" name="bookImageOld" value="<?php echo $book->fileName; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control text-center" name="name" id="name" value="<?php echo $book->name ?>" required autofocus>
                            </div>
                            <div class="mb-1">
                                <label for="bookImage" class="form-label">Book Photo</label>
                                <br>
                                <img src="uploads/<?php echo $book->fileName; ?>" alt="<?php echo $book->fileName; ?>" class="mb-2 border border-opacity-50 border-2 border-primary" style="width: 150px;">
                                <input type="file" class="form-control" name="bookImage" id="bookImage">
                            </div>

                            <div class="mb-3">
                                <?php
                                if (isset($_SESSION['fileIsImg']) == true) {
                                ?>
                                    <div class="text-primary">
                                        <?php
                                        echo $_SESSION['fileIsImg'];
                                        $_SESSION['fileIsImg'] = "";
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['fileNotImg_error']) == true) {
                                ?>
                                    <div class="text-danger">
                                        <?php
                                        echo $_SESSION['fileNotImg_error'];
                                        $_SESSION['fileNotImg_error'] = "";
                                        ?>
                                    </div>
                                <?php
                                }
                                if (isset($_SESSION['fileExist_error']) == true) {
                                ?>
                                    <div class="text-danger">
                                        <?php
                                        echo $_SESSION['fileExist_error'];
                                        $_SESSION['fileExist_error'] = "";
                                        ?>
                                    </div>
                                <?php
                                }
                                if (isset($_SESSION['fileSize_error']) == true) {
                                ?>
                                    <div class="text-danger">
                                        <?php
                                        echo $_SESSION['fileSize_error'];
                                        $_SESSION['fileSize_error'] = "";
                                        ?>
                                    </div>
                                <?php
                                }
                                if (isset($_SESSION['fileType_error']) == true) {
                                ?>
                                    <div class="text-danger">
                                        <?php
                                        echo $_SESSION['fileType_error'];
                                        $_SESSION['fileType_error'] = "";
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control text-center" name="author" id="author" value="<?php echo $book->author ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <select class="form-select text-center" aria-label="Default select example" name="genre" id="genre" required>
                                    <?php
                                    $arrayGenre = array("Romance", "Fantasy", "Horror", "Thriller", "Sci-Fi", "Comedy", "Documenter");
                                    foreach ($arrayGenre as $index => $genre) {
                                        if ($index == $book->genre) {
                                    ?>
                                            <option selected value="<?php echo $index; ?>">
                                                <?php
                                                echo $genre;
                                                ?>
                                            </option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $index; ?>">
                                                <?php
                                                echo $genre;
                                                ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date_released" class="form-label">Date Released</label>
                                <input type="date" class="form-control text-center" name="date_released" id="date_released" value="<?php echo $book->date_released ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="updateBook">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>