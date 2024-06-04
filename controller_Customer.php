<?php
include("model_Customer.php");
include("model_BookLoan.php");

session_start();
// cek dulu kalau misal ngga ada session customerList
if (!isset($_SESSION['customerList'])) {
    // buat deklarasi session customerList sebagai array untuk menampung objek customer
    $_SESSION['customerList'] = array();
}

function create_Customer()
{
    $customer = new Customer();
    $customer->name = $_POST['name'];
    $customer->address = $_POST['address'];
    $customer->email = $_POST['email'];

    date_default_timezone_set("Asia/Bangkok");
    $customerBirthdate = date("Y-m-d", strtotime($_POST['birthdate']));
    $currentDate = date("Y-m-d");
    if ($customerBirthdate >= $currentDate) {
        $_SESSION['birthdate_error'] = "Please input your birthdate correctly!";
        $birthdateOk = 0;
    } else {
        $customer->birthdate = $customerBirthdate;
        $birthdateOk = 1;
    }

    $customer->fileName = $_FILES['customerImage']['name'];
    $fileType = strtolower(pathinfo(($customer->fileName), PATHINFO_EXTENSION));
    $fileTmp_Name = $_FILES['customerImage']['tmp_name'];
    $fileSize = $_FILES['customerImage']['size'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($customer->fileName);

    $check = getimagesize($fileTmp_Name);
    if ($check !== false) {
        $_SESSION['fileIsImg'] = "File is an image - " . $check["mime"] . "." . "<br>";
        $uploadOk = 1;
    } else {
        $_SESSION['fileNotImg_error'] = "File is not an image." . "<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['fileExist_error'] = "File already exists." . "<br>";
        $uploadOk = 0;
    }

    // Check file size
    // 1.000.000 byte = 1 mb
    if ($fileSize > 500000) {
        $_SESSION['fileSize_error'] = "Sorry, your file is too large." . "<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        $_SESSION['fileType_error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed." . "<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk and $birthdateOk is set to 0 by an error
    if ($uploadOk == 0 || $birthdateOk == 0) {
        $referer = $_SERVER['HTTP_REFERER'];
        echo "
        <script language='javascript'>
            alert('Sorry, $customer->name hasn\\'t been created.');
            window.location.href = '$referer';
        </script>
    ";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileTmp_Name, $target_file)) {
            array_push($_SESSION['customerList'], $customer);
            echo "
                <script language='javascript'>
                    alert('$customer->name has been successfully created.');
                    window.location.href = 'view_indexCustomer.php';
                </script>
                ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

function update_Customer($customerID)
{
    $customer = $_SESSION['customerList'][$customerID]; // ini ambil customer dengan id tertentu
    $customer->name = $_POST['name'];
    $customer->address = $_POST['address'];
    $customer->email = $_POST['email'];

    date_default_timezone_set("Asia/Bangkok");
    $customerBirthdate = date("Y-m-d", strtotime($_POST['birthdate']));
    $currentDate = date("Y-m-d");
    $birthdateOk = 1;
    if ($customerBirthdate >= $currentDate) {
        $_SESSION['birthdate_error'] = "Please input your birthdate correctly!";
        $birthdateOk = 0;
    } else {
        $customer->birthdate = $customerBirthdate;
    }

    $customerImage = $_FILES['customerImage']['name'];
    $fileType = strtolower(pathinfo(($customerImage), PATHINFO_EXTENSION));
    $fileTmp_Name = $_FILES['customerImage']['tmp_name'];
    $fileSize = $_FILES['customerImage']['size'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($customerImage);

    $check = getimagesize($fileTmp_Name);
    if ($check !== false) {
        $_SESSION['fileIsImg'] = "File is an image - " . $check["mime"] . "." . "<br>";
        $uploadOk = 1;
    } else {
        $_SESSION['fileNotImg_error'] = "File is not an image." . "<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['fileExist_error'] = "File already exists." . "<br>";
        $uploadOk = 0;
    }

    // Check file size
    // 1.000.000 byte = 1 mb
    if ($fileSize > 500000) {
        $_SESSION['fileSize_error'] = "Sorry, your file is too large." . "<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        $_SESSION['fileType_error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed." . "<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk and $birthdateOk is set to 0 by an error
    if ($uploadOk == 0 || $birthdateOk == 0) {
        echo "
            <script language='javascript'>
                alert('Sorry, $customer->name hasn\\'t been updated.');
                window.location.href = 'view_updateCustomer.php?updateCustomerID=" . $_POST['customer_ID'] . "';
            </script>
        ";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileTmp_Name, $target_file)) {
            $customer->fileName = $customerImage;
            echo "
                <script language='javascript'>
                    alert('$customer->name has been successfully updated.');
                    window.location.href = 'view_indexCustomer.php';
                </script>
                ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    // ini sudah ngga perlu lagi push ke dalam array nanti malah double
    // jadi tujuannya hanya update
}

function read_Customer()
{
    return $_SESSION['customerList'];
}

function get_CustomerWithID($customerID)
{
    return $_SESSION['customerList'][$customerID];
}

function delete_Customer($customerID)
{
    unset($_SESSION['customerList'][$customerID]);
}

// cek jika button ADD ditekan
if (isset($_POST['addCustomer'])) {
    $_SESSION['input_data'] = $_POST;
    create_Customer();
    // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
}

// cek jika button UPDATE ditekan
if (isset($_POST['updateCustomer'])) {
    if ($_FILES['customerImage']['error'] == 4) {
        $customer = $_SESSION['customerList'][$_POST['customer_ID']];
        $customer->name = $_POST['name'];
        $customer->address = $_POST['address'];
        $customer->email = $_POST['email'];

        date_default_timezone_set("Asia/Bangkok");
        $customerBirthdate = date("Y-m-d", strtotime($_POST['birthdate']));
        $currentDate = date("Y-m-d");
        $birthdateOk = 1;
        if ($customerBirthdate >= $currentDate) {
            $_SESSION['birthdate_error'] = "Please input your birthdate correctly!";
            $birthdateOk = 0;
        } else {
            $customer->birthdate = $customerBirthdate;
        }
        $customer->fileName = $_POST['customerImageOld'];

        if ($birthdateOk == 0) {
            echo "
                <script language='javascript'>
                    alert('Sorry, $customer->name hasn\\'t been updated.');
                    window.location.href = 'view_updateCustomer.php?updateCustomerID=" . $_POST['customer_ID'] . "';
                </script>
            ";
        } else {
            echo "
                <script language='javascript'>
                    alert('$customer->name has been successfully updated.');
                    window.location.href = 'view_indexCustomer.php';
                </script>
            ";
        }
    } else {
        update_Customer($_POST['customer_ID']);
        // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
    }
}

// cek jika button DELETE ditekan
if (isset($_GET['deleteCustomerID'])) {
    delete_Customer($_GET['deleteCustomerID']);

    if (isset($_SESSION['bookLoanList'])) {
        $bookLoanList = $_SESSION['bookLoanList'];
        foreach ($bookLoanList as $index => $loan) {
            if ($loan->customer_ID == $_GET['deleteCustomerID']) {
                unset($bookLoanList[$index]);
            }
        }
        // jika sudah dihapus objek bookLoanList nya maka harus disimpan kembali ke dalam session 
        // untuk ditampilkan ke dalam halaman index BookLoanList
        $_SESSION['bookLoanList'] = $bookLoanList;
    }

    header("location:view_indexCustomer.php");
}
?>
