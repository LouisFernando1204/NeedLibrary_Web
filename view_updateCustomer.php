<?php
require("controller_Customer.php");
if (isset($_GET['updateCustomerID'])) {
    $customer_ID = $_GET['updateCustomerID'];
    $customer = get_CustomerWithID($_GET['updateCustomerID']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
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
                                <a class="nav-link" href="view_indexCustomer.php">Customer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="view_updateCustomer.php?updateCustomerID=<?php echo $customer_ID; ?>">Update Customer</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1 class="text-center">Update Customer</h1>
                        <form action="controller_Customer.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="customer_ID" value="<?php echo $customer_ID; ?>">
                            <input type="hidden" name="customerImageOld" value="<?php echo $customer->fileName; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control text-center" name="name" id="name" value="<?php echo $customer->name ?>" required autofocus>
                            </div>
                            <div class="mb-1">
                                <label for="customerImage" class="form-label">Profile Photo</label>
                                <br>
                                <img src="uploads/<?php echo $customer->fileName; ?>" alt="<?php echo $customer->fileName; ?>" class="mb-2 border border-opacity-50 border-2 border-primary" style="width: 150px;">
                                <input type="file" class="form-control" name="customerImage" id="customerImage">
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
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control text-center" name="address" id="address" value="<?php echo $customer->address ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control text-center" name="email" id="email" value="<?php echo $customer->email ?>" required>
                            </div>
                            <div class="mb-1">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control text-center" name="birthdate" id="birthdate" value="<?php echo $customer->birthdate ?>" required>
                            </div>
                            <?php
                            if (isset($_SESSION['birthdate_error'])) {
                            ?>
                                <div class="text-danger p-0 mb-4">
                                    <?php
                                    echo $_SESSION['birthdate_error'];
                                    $_SESSION['birthdate_error'] = "";
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            <button type="submit" class="btn btn-primary" name="updateCustomer">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>