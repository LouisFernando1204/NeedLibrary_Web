<?php
require("controller_BookLoan.php");
if (isset($_GET['updateBookLoanID'])) {
    $bookLoan_ID = $_GET['updateBookLoanID'];
    $bookLoan = get_BookLoanWithID($_GET['updateBookLoanID']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Loan</title>
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
                                <a class="nav-link" href="view_indexBookLoan.php">Loan List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="view_addBookLoan.php">Update Loan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1 class="text-center">Update Loan</h1>
                        <form action="controller_BookLoan.php" method="post" class="row needs-validation" novalidate>
                            <input type="hidden" name="bookLoan_ID" value="<?php echo $bookLoan_ID ?>">
                            <div class="mb-1">
                                <label for="customerName" class="form-label">Customer Name</label>
                                <select class="form-select text-center" aria-label="Default select example" name="customerName" id="customerName" required>
                                    <?php
                                    if (isset($_SESSION['customerList'])) {
                                        $customers = getAll_Customer();
                                        if (count($customers) > 0) {
                                            foreach ($customers as $index => $customer) {
                                                if ($index == $bookLoan->customer_ID) {
                                    ?>
                                                    <option selected value="<?php echo $index; ?>"><?php echo $customer->name; ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?php echo $index; ?>"><?php echo $customer->name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="-1">Oops.. No Data!</option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                            if (isset($_SESSION['noCustomerData_error'])) {
                            ?>
                                <div class="text-danger p-0 mb-3">
                                    <?php
                                    echo $_SESSION['noCustomerData_error'];
                                    $_SESSION['noCustomerData_error'] = "";
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="mb-1">
                                <label for="bookName" class="form-label">Book Name</label>
                                <select class="form-select text-center" aria-label="Default select example" name="bookName" id="bookName" value="<?php echo $input_data['bookName'] ?>" required>
                                    <?php
                                    if (isset($_SESSION['bookList'])) {
                                        $books = getAll_Book();
                                        if (count($books) > 0) {
                                            foreach ($books as $index => $book) {
                                                if ($index == $bookLoan->book_ID) {
                                    ?>
                                                    <option selected value="<?php echo $index; ?>"><?php echo $book->name; ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?php echo $index; ?>"><?php echo $book->name; ?></option>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="-1">Oops.. No Data!</option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                            if (isset($_SESSION['noBookData_error'])) {
                            ?>
                                <div class="text-danger p-0 mb-3">
                                    <?php
                                    echo $_SESSION['noBookData_error'];
                                    $_SESSION['noBookData_error'] = "";
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="mb-3 col-md-6">
                                <label for="borrowDate" class="form-label">Borrow Date</label>
                                <input type="date" class="form-control text-center" name="borrowDate" id="borrowDate" value="<?php echo $bookLoan->borrowDate; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="returnDate" class="form-label">Return Date</label>
                                <input type="date" class="form-control text-center" name="returnDate" id="returnDate" value="<?php echo $bookLoan->returnDate; ?>" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="note" class="form-label">Note</label>
                                <input type="text" class="form-control text-center" name="note" id="note" value="<?php echo $bookLoan->note; ?>" required>
                            </div>
                            <div class="mb-3 col-md-5 p-0">
                                <label for="fine" class="form-label">Fine</label>
                                <input type="number" class="form-control text-center" name="fine" id="fine" value="<?php echo $bookLoan->fine; ?>" required>
                            </div>
                            <div class="col-md-1" style="margin-top: 37px;">
                                $
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="updateBookLoan">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>