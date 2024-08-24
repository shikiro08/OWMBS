<?php
require('fpdf17/fpdf.php');

include 'db.php';

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;



?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Your custom script goes here -->
    <script>
        function printModal(modalId) {
            var printContents = document.getElementById(modalId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        function printBilling() {
            window.location.href = 'billing_pdfuser.php';
        }
    </script>
</head>

<body>

<h4>Note: Bill Amount = Total Consumption * Price/unit<br />&copy; 2024</h4>

<!-- Back Button -->
<td>
    <a href="billing.php" class="btn btn-Primary">Back</a>
</td>

<?php
$result = mysqli_query($conn, "SELECT * FROM billing WHERE user_Id='$id' order by id desc ");

echo "<table class=\"table table-striped table-hover table-bordered\">
<tr>
<th>Id</th>
<th>Previous Reading</th>
<th>Present Reading</th>
<th>Consumption</th>
<th>Price</th>
<th>Date</th>
<th>Bill Amount</th>
<th>Status</th>
<th>Action</th>
</tr>";

$price_per_ml = $_POST['price'] ?? 10;

while ($row = mysqli_fetch_array($result)) {
    $prev = $row['prev'];
    $pres = $row['pres'];
    $price = $price_per_ml;
    $totalcons = abs($pres - $prev);
    $bill = $totalcons * $price;

    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $prev . "</td>";
    echo "<td>" . $pres . "</td>";
    echo "<td>" . $totalcons . "</td>";
    echo "<td>" . $price . "</td>";
    echo "<td>" . $row['pdate'] . "</td>";
    echo "<td>" . $bill . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>
            <a href='#viewModal" . $row['id'] . "' data-toggle='modal'>
                <span class='glyphicon glyphicon-eye-open'>View
            </a>|
            <a rel='facebox' href='delbill.php?id=" . $row['id'] . "'>Del
            </td>";
    echo "</tr>";

    // Modal for each row
    echo "<div id='viewModal" . $row['id'] . "' class='modal fade' role='dialog'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>View Payment Details</h4>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>
                    <div class='modal-body'>
                        <p>Bill ID: " . $row['id'] . "</p>
                        <p>Previous Reading: " . $prev . "</p>
                        <p>Present Reading: " . $pres . "</p>
                        <p>Total Consumption: " . $totalcons . "</p>
                        <p>Price: " . $price . "</p>
                        <p>Date: " . $row['pdate'] . "</p>
                        <p>Bill Amount: " . $bill . "</p>
                        <p>Status: " . $row['status'] . "</p>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        <button type='button' class='btn btn-primary' onclick='printBilling()'>Print</button>
                    </div>
                </div>
            </div>
        </div>";
}

echo "</table>";

?>

</body>
</html>
