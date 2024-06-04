<?php
include("model_Book.php");
include("model_Customer.php");
include("model_BookLoan.php");

date_default_timezone_set("Asia/Bangkok");
session_start();
// cek dulu kalau misal ngga ada session bookLoanList
if (!isset($_SESSION['bookLoanList'])) {
    // buat deklarasi session bookLoanList sebagai array untuk menampung objek book
    $_SESSION['bookLoanList'] = array();
}
// Periksa jika session bookList belum ada, maka buat session tersebut sebagai array kosong
if (!isset($_SESSION['bookList'])) {
    $_SESSION['bookList'] = array();
}
// Periksa jika session customerList belum ada, maka buat session tersebut sebagai array kosong
if (!isset($_SESSION['customerList'])) {
    $_SESSION['customerList'] = array();
}

function create_BookLoan()
{
    $bookLoan = new BookLoan();
    $bookLoan->customer_ID = $_POST['customerName'];
    $bookLoan->book_ID = $_POST['bookName'];
    $bookLoan->borrowDate = $_POST['borrowDate'];
    $bookLoan->borrowTime = date("h:i:s a");
    $bookLoan->returnDate = $_POST['returnDate'];
    $bookLoan->returnTime = "Not Done";
    $bookLoan->note = $_POST['note'];
    $bookLoan->fine = $_POST['fine'];
    array_push($_SESSION['bookLoanList'], $bookLoan);
}

function update_BookLoan($bookLoanID)
{
    $bookLoan = $_SESSION['bookLoanList'][$bookLoanID];
    $bookLoan->customer_ID = $_POST['customerName'];
    $bookLoan->book_ID = $_POST['bookName'];
    $bookLoan->borrowDate = $_POST['borrowDate'];
    $bookLoan->returnDate = $_POST['returnDate'];
    $bookLoan->note = $_POST['note'];
    $bookLoan->fine = $_POST['fine'];
}

// ini untuk mengambil array objek book untuk di-looping di dalam form select
function getAll_Book()
{
    return $_SESSION['bookList'];
}

// ini untuk mengambil objek book yang name nya ada ditampilkan di view_indexBookLoan.php
function get_BookWithID($bookID) {
    return $_SESSION['bookList'][$bookID];
}

// ini untuk mengambil array objek customer untuk di-looping di dalam form select
function getAll_Customer()
{
    return $_SESSION['customerList'];
}

// ini untuk mengambil objek customer yang name nya ada ditampilkan di view_indexBookLoan.php
function get_CustomerWithID($customerID) {
    return $_SESSION['customerList'][$customerID];
}

function read_BookLoan()
{
    return $_SESSION['bookLoanList'];
}

function get_BookLoanWithID($bookLoanID)
{
    return $_SESSION['bookLoanList'][$bookLoanID];
}

function delete_BookLoan($bookLoanID)
{
    unset($_SESSION['bookLoanList'][$bookLoanID]);
}

// cek jika button ADD ditekan
if (isset($_POST['addBookLoan'])) {
    $_SESSION['input_data'] = $_POST;
    if($_POST['customerName'] == -1) {
        $_SESSION['noCustomerData_error'] = "Please input the data for customer first!";
        header("location:view_addBookLoan.php");
    }
    if ($_POST['bookName'] == -1) {
        $_SESSION['noBookData_error'] = "Please input the data for book first!";
        header("location:view_addBookLoan.php");
    }
    else {
        create_BookLoan();
        header("location:view_indexBookLoan.php");
    }
    // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
}

// cek jika button UPDATE ditekan
if (isset($_POST['updateBookLoan'])) {
    update_BookLoan($_POST['bookLoan_ID']);
    header("location:view_indexBookLoan.php");
    // redirect/kembali ke halaman index untuk melihat semua data yang sudah ditambahkan
}

// cek jika button DELETE ditekan
if (isset($_GET['deleteBookLoanID'])) {
    delete_BookLoan($_GET['deleteBookLoanID']);
    header("location:view_indexBookLoan.php");
}

// ini untuk mengisi dan mengosongkan return time jika tekan tombol di kolom checklist
if(isset($_GET['checklistID'])) {
    $bookLoan = get_BookLoanWithID($_GET['checklistID']);
    if($bookLoan->returnTime != "Not Done") {
        $bookLoan->returnTime = "Not Done";
    }
    else {
        $bookLoan->returnTime = date("h:i:s a");
    }
    header("location:view_indexBookLoan.php");
}
?>
