<?php
include("model_Book.php");
include("model_BookLoan.php");

session_start();
// cek dulu kalau misal ngga ada session bookList
if (!isset($_SESSION['bookList'])) {
    // buat deklarasi session bookList sebagai array untuk menampung objek book
    $_SESSION['bookList'] = array();
}

function create_Book()
{
    $book = new Book();
    $book->name = $_POST['name'];
    $book->author = $_POST['author'];
    $book->genre = $_POST['genre'];
    $book->date_released = $_POST['date_released'];

    $book->fileName = $_FILES['bookImage']['name'];
    $fileType = strtolower(pathinfo(($book->fileName), PATHINFO_EXTENSION));
    $fileTmp_Name = $_FILES['bookImage']['tmp_name'];
    $fileSize = $_FILES['bookImage']['size'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($book->fileName);

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
    if ($uploadOk == 0) {
        $referer = $_SERVER['HTTP_REFERER'];
        echo "
            <script language='javascript'>
                alert('Sorry, $book->name hasn\\'t been created.');
                window.location.href = '$referer';
            </script>
        ";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileTmp_Name, $target_file)) {
            array_push($_SESSION['bookList'], $book);
            echo "
                    <script language='javascript'>
                        alert('$book->name has been successfully created.');
                        window.location.href = 'view_indexBook.php';
                    </script>
                    ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

function update_Book($bookID)
{
    $book = $_SESSION['bookList'][$bookID]; // ini ambil book dengan id tertentu
    $book->name = $_POST['name'];
    $book->author = $_POST['author'];
    $book->genre = $_POST['genre'];
    $book->date_released = $_POST['date_released'];

    $bookImage = $_FILES['bookImage']['name'];
    $fileType = strtolower(pathinfo(($bookImage), PATHINFO_EXTENSION));
    $fileTmp_Name = $_FILES['bookImage']['tmp_name'];
    $fileSize = $_FILES['bookImage']['size'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($bookImage);

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
    if ($uploadOk == 0) {
        echo "
                <script language='javascript'>
                    alert('Sorry, $book->name hasn\\'t been updated.');
                    window.location.href = 'view_updateBook.php?updateBookID=" . $_POST['book_ID'] . "';
                </script>
            ";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileTmp_Name, $target_file)) {
            $book->fileName = $bookImage;
            echo "
                    <script language='javascript'>
                        alert('$book->name has been successfully updated.');
                        window.location.href = 'view_indexBook.php';
                    </script>
                    ";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    // ini sudah ngga perlu lagi push ke dalam array nanti malah double
    // jadi tujuannya hanya update
}

function read_Book()
{
    return $_SESSION['bookList'];
}

function get_BookWithID($bookID)
{
    return $_SESSION['bookList'][$bookID];
}

function delete_Book($bookID)
{
    unset($_SESSION['bookList'][$bookID]);
}

// cek jika button ADD ditekan
if (isset($_POST['addBook'])) {
    $_SESSION['input_data'] = $_POST;
    create_Book();
    // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
}

// cek jika button UPDATE ditekan
if (isset($_POST['updateBook'])) {
    if ($_FILES['bookImage']['error'] == 4) {
        $book = $_SESSION['bookList'][$_POST['book_ID']]; // ini ambil book dengan id tertentu
        $book->name = $_POST['name'];
        $book->author = $_POST['author'];
        $book->genre = $_POST['genre'];
        $book->date_released = $_POST['date_released'];
        $book->fileName = $_POST['bookImageOld'];
        echo "
                    <script language='javascript'>
                        alert('$book->name has been successfully updated.');
                        window.location.href = 'view_indexBook.php';
                    </script>
                ";
    } else {
        update_Book($_POST['book_ID']);
        // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
    }
}

// cek jika button DELETE ditekan
if (isset($_GET['deleteBookID'])) {
    delete_Book($_GET['deleteBookID']);

    if (isset($_SESSION['bookLoanList'])) {
        $bookLoanList = $_SESSION['bookLoanList'];
        foreach ($bookLoanList as $index => $loan) {
            if ($loan->book_ID == $_GET['deleteBookID']) {
                unset($bookLoanList[$index]);
            }
        }
        // jika sudah dihapus objek bookLoanList nya maka harus disimpan kembali ke dalam session 
        // untuk ditampilkan ke dalam halaman index BookLoanList
        $_SESSION['bookLoanList'] = $bookLoanList;
    }

    header("location:view_indexBook.php");
}
?>