<?php
require 'phpqrcode/qrlib.php'; // Adjust the path to the autoloader

// Set a filename for the download
$filename = 'qrcode.png';

$path = 'images/qrcode/';
$qrcode = $path . $filename;

QRcode::png($_GET['link'], $qrcode, 'H', 10, 10);

// Send the appropriate headers
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($qrcode));

// Read the file and output it to the browser
readfile($qrcode);
exit;
?>
