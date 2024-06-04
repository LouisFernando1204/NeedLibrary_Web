<?php
require("controller_Book.php");
// ngga usah pakai include soalnya hanya bertujuan untuk bisa mengenali file controller nya 
// (ngga usah include semua yang ada di controller)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Page</title>
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
                <div class="card text-center" style="width: 1000px;">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="view_indexBook.php">Book List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_addBook.php">Add Book</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1>Book List</h1>
                        <table class="table table-dark table-striped-columns">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Book Photo</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Date Released</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['bookList'])) {
                                    $bookList = read_Book();
                                    $id = 1;
                                    if (count($bookList) > 0) {
                                        foreach ($bookList as $index => $book) {
                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $id; ?></th>
                                                <td><?php echo $book->name; ?></td>
                                                <td>
                                                    <?php
                                                    echo '<img src="uploads/' . $book->fileName . '" alt="' . $book->fileName . '" style="width: 150px;">';
                                                    ?>
                                                </td>
                                                <td><?php echo $book->author; ?></td>
                                                <td>
                                                    <?php
                                                    if ($book->genre == 0) {
                                                        echo "Romance";
                                                    } else if ($book->genre == 1) {
                                                        echo "Fantasy";
                                                    } else if ($book->genre == 2) {
                                                        echo "Horror";
                                                    } else if ($book->genre == 3) {
                                                        echo "Thriller";
                                                    } else if ($book->genre == 4) {
                                                        echo "Sci-Fi";
                                                    } else if ($book->genre == 5) {
                                                        echo "Comedy";
                                                    } else if ($book->genre == 6) {
                                                        echo "Documenter";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $book->date_released; ?></td>
                                                <td>
                                                    <a href="view_updateBook.php?updateBookID=<?php echo $index; ?>">
                                                        <button class="btn btn-warning mb-2">Update</button>
                                                    </a>
                                                    <br>
                                                    <a href="controller_Book.php?deleteBookID=<?php echo $index; ?>" onclick="return confirm('Are you sure want to delete this book?')">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </a>
                                                </td>
                                                <?php
                                                $id++;
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" class="p-5">
                                                <div class="alert alert-danger" role="alert">
                                                    Oops.. There is no Book Data!
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>