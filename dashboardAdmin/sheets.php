<?php
require '../PhpSpreadsheet/vendor/autoload.php'; // Adjust the path based on your project structure
require '../dbconfig.php'; // Include your database connection code here

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch data from the database
$pedagangData = [];
$pembeliData = [];

// Assuming you are using MySQLi for database connection

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch pedagang data
$pedagangResult = mysqli_query($conn, 'SELECT * FROM pedagang');
while ($row = mysqli_fetch_assoc($pedagangResult)) {
    $pedagangData[] = $row;
}

// Fetch pembeli data
$pembeliResult = mysqli_query($conn, 'SELECT * FROM pembeli');
while ($row = mysqli_fetch_assoc($pembeliResult)) {
    $pembeliData[] = $row;
}

// Create a spreadsheet
$spreadsheet = new Spreadsheet();

// Create the Pedagang worksheet
$pedagangSheet = $spreadsheet->createSheet();
$pedagangSheet->setTitle('Pedagang');

// Set headers for Pedagang
$pedagangSheet->setCellValue('A1', 'ID_Pedagang');
$pedagangSheet->setCellValue('B1', 'Nama Pedagang');
$pedagangSheet->setCellValue('C1', 'Jajanan');
$pedagangSheet->setCellValue('D1', 'Deskripsi');
$pedagangSheet->setCellValue('E1', 'No HP');
$pedagangSheet->setCellValue('F1', 'ID_Kategori');
$pedagangSheet->setCellValue('G1', 'Status');

// Populate Pedagang data
$rowIndex = 2;
foreach ($pedagangData as $row) {
    $pedagangSheet->setCellValue('A' . $rowIndex, $row['ID_Pedagang']);
    $pedagangSheet->setCellValue('B' . $rowIndex, $row['Nama_Pedagang']);
    $pedagangSheet->setCellValue('C' . $rowIndex, $row['Nama_Jajanan']);
    $pedagangSheet->setCellValue('D' . $rowIndex, $row['Deskripsi']);
    $pedagangSheet->setCellValue('E' . $rowIndex, $row['No_HP']);
    $pedagangSheet->setCellValue('F' . $rowIndex, $row['ID_Kategori']);
    $pedagangSheet->setCellValue('G' . $rowIndex, $row['Status']);
    $rowIndex++;
}

// Create the Pembeli worksheet
$pembeliSheet = $spreadsheet->createSheet();
$pembeliSheet->setTitle('Pembeli');

// Set headers for Pembeli
$pembeliSheet->setCellValue('A1', 'ID_Pembeli');
$pembeliSheet->setCellValue('B1', 'Username');
$pembeliSheet->setCellValue('C1', 'Email');

// Populate Pembeli data
$rowIndex = 2;
foreach ($pembeliData as $row) {
    $pembeliSheet->setCellValue('A' . $rowIndex, $row['ID_Pembeli']);
    $pembeliSheet->setCellValue('B' . $rowIndex, $row['Username']);
    $pembeliSheet->setCellValue('C' . $rowIndex, $row['Email']);
    $rowIndex++;
}

// Specify the folder to save the spreadsheet
$saveFolder = __DIR__ . '/../sheets/';
if (!file_exists($saveFolder)) {
    mkdir($saveFolder, 0777, true);
}

// Save the spreadsheet to a file with a specific folder
$spreadsheetPath = $saveFolder . 'pedagang_pembeli_spreadsheet.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($spreadsheetPath);

// Respond to the client
echo json_encode(['success' => true, 'path' => $spreadsheetPath]);
