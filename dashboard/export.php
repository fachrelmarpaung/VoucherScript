<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Server
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'phdkomunitas';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the 'phonebook' table
$sql = "SELECT phonenumber, idoutlet FROM phonebook";
$result = $conn->query($sql);

// Check if there is data
if ($result->num_rows > 0) {
    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();

    // Set active sheet
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the spreadsheet
    $sheet->setCellValue('A1', 'Phone Number');
    $sheet->setCellValue('B1', 'Outlet ID');

    // Populate the spreadsheet with data from the database
    $row = 2; // Start from row 2
    while ($row_data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $row_data['phonenumber']);
        $sheet->setCellValue('B' . $row, $row_data['idoutlet']);
        $row++;
    }

    // Set headers for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="phonebook_data.xlsx"');
    header('Cache-Control: max-age=0');

    // Save the spreadsheet to a file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
} else {
    echo "No data found in the phonebook table.";
}

// Close the database connection
$conn->close();
?>
