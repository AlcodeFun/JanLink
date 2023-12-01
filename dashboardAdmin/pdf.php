<?php
require('../fpdf186/fpdf.php'); // Include the FPDF library
require '../dbconfig.php';

// Include your database connection code here

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

// PDF generation
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Report for Pedagang and Pembeli');

// Beautify table headers for Pedagang
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Header background color
$pdf->SetTextColor(0); // Header text color

$pdf->Cell(15, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Nama Pedagang', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Jajanan', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Deskripsi', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'No HP', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Kategori', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Status', 1, 1, 'C', true);

// Populate table with Pedagang data
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(255); // Reset background color
$pdf->SetTextColor(0); // Reset text color

foreach ($pedagangData as $index => $row) {
    $pdf->Cell(15, 10, $index + 1, 1, 0, 'C');
    $pdf->Cell(40, 10, $row['Nama_Pedagang'], 1);
    $pdf->Cell(30, 10, $row['Nama_Jajanan'], 1);
    $pdf->Cell(30, 10, $row['Deskripsi'], 1);
    $pdf->Cell(30, 10, $row['No_HP'], 1, 0, 'C');
    $pdf->Cell(25, 10, $row['ID_Kategori'], 1, 0, 'C'); // Assuming Kategori is a numeric ID
    $pdf->Cell(20, 10, $row['Status'], 1, 1, 'C');
}

// Beautify table headers for Pembeli
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255); // Header background color
$pdf->SetTextColor(0); // Header text color

$pdf->Cell(15, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Username', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Email', 1, 1, 'C', true);

// Populate table with Pembeli data
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(255); // Reset background color
$pdf->SetTextColor(0); // Reset text color

foreach ($pembeliData as $index => $row) {
    $pdf->Cell(15, 10, $index + 1, 1, 0, 'C');
    $pdf->Cell(40, 10, $row['Username'], 1);
    $pdf->Cell(50, 10, $row['Email'], 1, 1, 'C');
}

// Output PDF
$pdf->Output('D', 'pedagang_pembeli_report.pdf');

// Close MySQL connection
mysqli_close($mysqli);
