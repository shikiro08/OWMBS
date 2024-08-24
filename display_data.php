<!-- display_data.php -->
<?php
include('db.php');  // Include your database connection file
include 'header.php';
include 'sidebar.php';
include 'footer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve start and end dates from the form
    $start_date = mysqli_real_escape_string($conn, $_POST["start_date"]);
    $end_date = mysqli_real_escape_string($conn, $_POST["end_date"]);
    
    // Perform a query to get data within the selected date range
    $query = "SELECT billing.id, client.cname, billing.amount, billing.pdate, billing.status
              FROM client
              JOIN billing ON client.id = billing.user_id
              WHERE billing.pdate BETWEEN '$start_date' AND '$end_date'
              ORDER BY billing.id DESC";
    $result = mysqli_query($conn, $query);
?>
<?php include 'header.php'; ?>

<div class="container-fluid px-4">
    <!-- Main content here -->
    <div class="container-fluid px-4">
        <!-- Your billing-specific content goes here -->
        <div class="row my-5">
            <h2> Billing Information </h2>
            <div class="card">
                <div class="card-body">
                    <!-- Include your modal content -->
                    <?php include 'Modals/modals.php'; ?>
                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#billingaddmodal">
                        ADD DATA
                    </button>
                    
                     <button type="button" class="btn btn-primary" onclick="printBilling()">
                        Print
                    </button>
                <div class="card-body">
                    <form method="post" action="display_data.php">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>

                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" required>

                        <button type="submit">Submit</button>
                    </form>

                </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="billingTable" class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">status</th>
                                <th scope="col">Options</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['cname']; ?></td>
                                    <td><?php echo $rows['amount']; ?></td>
                                    <td><?php echo $rows['pdate']; ?></td>
                                    <td><?php echo $rows['status']; ?></td>
                                    <td>
                                        <!-- Add delete button with a form -->
                                        <form method="post" action="delete_billing.php" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            <input type="hidden" name="delete_billing" value="<?php echo $billingRecord['id']; ?>"> <!-- Replace with the actual billing ID -->
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_billing">Delete</button>
                                        </form>

                                        <!-- Add update button linking to update_billing.php -->
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editmodal">
                                            EDIT DATA
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the common footer content -->
<?php include 'footer.php'; ?>

<script>
    function printBilling() {
        window.location.href = 'billing_pdf.php';
    }
</script>

<?php
} else {
    // Redirect to the login page if the user is not authenticated
    header("Location: login.php");
    exit();
}
?>
