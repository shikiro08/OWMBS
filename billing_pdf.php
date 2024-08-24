<?php
// Include the FPDF library
require('fpdf17/fpdf.php');
include('db.php');  // Include your database connection file

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 12);

// Your existing code for setting fonts, company information, billing address, etc.
$pdf->Cell(130, 5, 'RWAS WAL', 0, 0);
$pdf->Cell(59, 5, 'Monthly Invoice', 0, 1); // end of line

$currentDate = date('Y-m-d');

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(130, 5, 'Makar - Siquel Rd', 0, 0);
$pdf->Cell(59, 5, '', 0, 1); // end of line

$pdf->Cell(130, 5, 'Genral Santos City , 9500, Philippines', 0, 0);
$pdf->Cell(25, 5, 'Date', 0, 0);
$pdf->Cell(34, 5, $currentDate, 0, 1);

// Display all billing data
$query = "SELECT billing_history.id, client.cname, billing_history.amount, billing_history.payment_date
          FROM client
          JOIN billing_history ON client.id = billing_history.C_id
          WHERE MONTH(billing_history.payment_date) = MONTH(CURRENT_DATE()) AND YEAR(billing_history.payment_date) = YEAR(CURRENT_DATE())
          ORDER BY billing_history.id DESC";

$result = mysqli_query($conn, $query);

$pdf->Cell(20, 5, 'id', 1, 0);
$pdf->Cell(60, 5, 'client name', 1, 0);
$pdf->Cell(50, 5, 'date', 1, 0);
$pdf->Cell(50, 5, 'amount', 1, 1);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(20, 5, $row['id'], 1, 0);
    $pdf->Cell(60, 5, $row['cname'], 1, 0);
    $pdf->Cell(50, 5, $row['payment_date'], 1, 0);
    $pdf->Cell(50, 5, $row['amount'], 1, 1);
}

// Calculate and display the total payment
$tquery = "SELECT SUM(amount) AS total_amount
           FROM billing_history
           WHERE C_id IN (SELECT C_id FROM billing_history WHERE MONTH(payment_date) = MONTH(CURRENT_DATE()) AND YEAR(payment_date) = YEAR(CURRENT_DATE))";

$tresult = mysqli_query($conn, $tquery);
$totalPayment = mysqli_fetch_assoc($tresult)['total_amount'];

$pdf->Cell(150, 5, 'Total Payment', 1, 0);
$pdf->Cell(30, 5, 'PHP ' . $totalPayment, 1, 1, 'R'); // Add a space after 'PHP' for better formatting

$pdf->Output();
?>
