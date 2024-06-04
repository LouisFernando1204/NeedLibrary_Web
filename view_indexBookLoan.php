<?php
require("controller_BookLoan.php");
// ngga usah pakai include soalnya hanya bertujuan untuk bisa mengenali file controller nya 
// (ngga usah include semua yang ada di controller)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Loan Page</title>
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
                <div class="card text-center w-100">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="view_indexBookLoan.php">Loan List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_addBookLoan.php">Add Loan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1>Book Loan List</h1>
                        <table class="table table-dark table-striped-columns">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Borrow Date</th>
                                    <th scope="col">Borrow Time</th>
                                    <th scope="col">Return Date</th>
                                    <th scope="col">Return Time</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Fine</th>
                                    <th scope="col">Checklist</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['bookLoanList'])) {
                                    $bookLoanList = read_BookLoan();
                                    $id = 1;
                                    if (count($bookLoanList) > 0) {
                                        foreach ($bookLoanList as $index => $loan) {
                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $id; ?></th>
                                                <td style="width: 120px;">
                                                    <?php
                                                    $customerID = $loan->customer_ID;
                                                    $customers = get_CustomerWithID($customerID);
                                                    echo $customers->name;
                                                    echo '<img src="uploads/' . $customers->fileName . '" alt="' . $customers->fileName . '" class="mt-2" style="width: 150px;">';
                                                    ?>
                                                </td>
                                                <td style="width: 120px;">
                                                    <?php
                                                    $bookID = $loan->book_ID;
                                                    $books = get_BookWithID($bookID);
                                                    echo $books->name;
                                                    echo '<img src="uploads/' . $books->fileName . '" alt="' . $books->fileName . '" class="mt-2" style="width: 150px;">';
                                                    ?>
                                                </td>
                                                <td><?php echo $loan->borrowDate; ?></td>
                                                <td><?php echo $loan->borrowTime; ?></td>
                                                <td><?php echo $loan->returnDate; ?></td>
                                                <td><?php echo $loan->returnTime; ?></td>
                                                <td style="width: 250px;"><?php echo $loan->note; ?></td>
                                                <td style="width: 80px;"><?php echo $loan->fine . " $"; ?></td>
                                                <td>
                                                    <?php
                                                    if ($loan->returnTime != "Not Done") {
                                                    ?>
                                                        <a href="controller_BookLoan.php?checklistID=<?php echo $index; ?>">
                                                            <button class="btn btn-danger">Undone</button>
                                                        </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="controller_BookLoan.php?checklistID=<?php echo $index; ?>">
                                                            <button class="btn btn-success">Done</button>
                                                        </a>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td>
                                                    <a href="view_updateBookLoan.php?updateBookLoanID=<?php echo $index; ?>">
                                                        <button class="btn btn-warning mb-2">Update</button>
                                                    </a>
                                                    <br>
                                                    <a href="controller_BookLoan.php?deleteBookLoanID=<?php echo $index; ?>" onclick="return confirm('Are you sure want to delete this loan?')">
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
                                            <td colspan="11" class="p-5">
                                                <div class="alert alert-danger" role="alert">
                                                    Oops.. There is no Loan Data!
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