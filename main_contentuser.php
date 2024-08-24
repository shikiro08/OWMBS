<?php
include('db.php');
session_start();

// Assuming $id is the user ID of the logged-in user
$id = $_SESSION['id'];

$query = "SELECT billing.id, client.cname, billing.amount, billing.pdate, billing.status,
          billing.prev, billing.pres
          FROM billing
          JOIN client ON client.usid = $id
          WHERE client.id = billing.user_Id
          ORDER BY billing.id DESC";


$vquery = "SELECT * FROM relay_events ORDER BY valve_id DESC LIMIT 1";
$xquery = "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1";

$result = mysqli_query($conn, $query);
$vresult = mysqli_query($conn, $vquery);
$xresult = mysqli_query($conn, $xquery);

// Function to handle query errors
function handleQueryError($result, $conn, $query)
{
    if (!$result) {
        die("Query failed: " . mysqli_error($conn) . "<br>Query: " . $query);
    }
}

handleQueryError($result, $conn, $query);
handleQueryError($vresult, $conn, $vquery);
handleQueryError($xresult, $conn, $xquery);

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {
?>

<div id="page-content-wrapper">
    <?php include('header.php'); // Include your header file ?>

    <div class="container-fluid px-4">
        <!-- Main content here -->
        <div class="row g-3 my-2">
            <?php while ($rows = mysqli_fetch_assoc($vresult)) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $rows['valve_id']; ?></h3>
                            <p class="fs-5">Active Valve</p>
                        </div>
                        <i class="fas fa-water fs-2 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            <?php } ?>
            <?php // Fetch the billing rows again after fetching the valve rows ?>
            <?php $result = mysqli_query($conn, $query); ?>
            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <?php
                            $price_per_ml = $_POST['price'] ?? 10;
                            $prev = $rows['prev'];
                            $pres = $rows['pres'];
                            $price = $price_per_ml; // Add your logic for $price if needed
                            $totalcons = abs($pres - $prev);
                            $bill = $totalcons * $price;
                            ?>
                            <h3 class="fs-2">₱ <?php echo $bill; ?></h3>
                            <p class="fs-5">Total Monthly Collection</p>
                        </div>
                        <i class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            <?php } ?>
            <?php // Fetch the billing rows again after fetching the sensor rows ?>
            <?php $result = mysqli_query($conn, $query); ?>
            <?php while ($rows = mysqli_fetch_assoc($xresult)) { ?>
                <div class="col-md-3 col-sm-6">
                    <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                        <div>
                            <h3 class="fs-2"><?php echo $rows['sensor1_value']; ?> <?php echo $rows['sensor2_value']; ?></h3>
                            <p class="fs-5">Water Quality Status</p>
                            <a href="Sensor_data.php">View</a>
                        </div>
                        <i class="fas fa-flask fs-2 primary-text border rounded-full secondary-bg p-3"></i>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row my-5">
            <h3 class="fs-4 mb-3">Recent Billings</h3>
            <div class="col">
                <div class="table-responsive">
                    <table class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Previous Reading</th>
                                <th scope="col">Present Reading</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php mysqli_data_seek($result, 0); // Reset the pointer to the beginning of the result set ?>
                            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['cname']; ?></td>
                                    <td><?php echo $rows['amount']; ?></td>
                                    <td><?php echo $rows['prev']; ?></td>
                                    <td><?php echo $rows['pres']; ?></td>
                                    <?php
                                    $prev = $rows['prev'];
                                    $pres = $rows['pres'];
                                    $price = $price_per_ml; // Add your logic for $price if needed
                                    $totalcons = abs($pres - $prev);
                                    $bill = $totalcons * $price;
                                    ?>
                                    <td><?php echo $bill; ?></td>
                                    <td><?php echo $rows['pdate']; ?></td>
                                    <td><?php echo $rows['status']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); // Include your footer file ?>
</div>

<?php
}
?>
