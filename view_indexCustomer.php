<?php
require("controller_Customer.php");
// ngga usah pakai include soalnya hanya bertujuan untuk bisa mengenali file controller nya 
// (ngga usah include semua yang ada di controller)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Page</title>
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
                                <a class="nav-link active" href="view_indexCustomer.php">Customer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_addCustomer.php">Add Customer</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h1>Customer List</h1>
                        <table class="table table-dark table-striped-columns">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Profile Photo</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Birthdate</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['customerList'])) {
                                    $customerList = read_Customer();
                                    $id = 1;
                                    if (count($customerList) > 0) {
                                        foreach ($customerList as $index => $customer) {
                                ?>
                                            <tr>
                                                <th scope="row"><?php echo $id; ?></th>
                                                <td><?php echo $customer->name; ?></td>
                                                <td>
                                                    <?php
                                                    echo '<img src="uploads/' . $customer->fileName . '" alt="' . $customer->fileName . '" style="width: 150px;">';
                                                    ?>
                                                </td>
                                                <td><?php echo $customer->address; ?></td>
                                                <td><?php echo $customer->email; ?></td>
                                                <td style="width: 100px;"><?php echo $customer->birthdate; ?></td>
                                                <td>
                                                    <a href="view_updateCustomer.php?updateCustomerID=<?php echo $index; ?>">
                                                        <button class="btn btn-warning mb-2">Update</button>
                                                    </a>
                                                    <br>
                                                    <a href="controller_Customer.php?deleteCustomerID=<?php echo $index; ?>" onclick="return confirm('Are you sure want to delete this customer?')">
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
                                                    Oops.. There is no Customer Data!
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