<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the FPDF library
require('fpdf17/fpdf.php');
include('db.php');  // Include your database connection file

// Check if 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch billing data for the specified ID
    $query = "SELECT billing.id, billing.prev, billing.pres, billing.pdate, billing.status
              FROM billing
              WHERE billing.id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result === false) {
        // Display SQL error
        echo 'MySQL Error: ' . mysqli_error($conn);
    } elseif ($row = mysqli_fetch_assoc($result)) {
        $price = $_POST['price'];  // Adjust this accordingly

        // Output debug information
        echo '<pre>';
        print_r($row);
        echo 'Price: ' . $price;
        echo '</pre>';

        // Uncomment the following line to generate the PDF
        // generatePDF($row, $price);
    } else {
        echo 'Error fetching billing record';
    }
} else {
    echo 'Invalid billing ID';
}
?>
