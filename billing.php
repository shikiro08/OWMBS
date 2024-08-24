<!-- billing.php -->

<?php
session_start();
include 'db.php';
include 'header.php';
include 'sidebar.php';
include 'footer.php';

$query = "SELECT * from client";
$result = mysqli_query($conn, $query);
if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {
?>

<!-- Include the common header content -->

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
                     <button type="button" class="btn btn-primary" onclick="printBilling()">
                        Print
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="datatableid" class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Middle Initial</th>
                                <th scope="col">address</th>
                                <th scope="col">phonenumnber</th>
                                <th scope="col">Options</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['cname'];?></td>
                                    <td><?php echo $rows['lname'];?></td>
                                    <td><?php echo $rows['Mi'];?></td>
                                    <td><?php echo $rows['address'];?></td>
                                    <td><?php echo $rows['pnumber']; ?></td>
                                
                                    <td>
                                        <a rel='facebox' href='viewbill.php?id=<?php echo $rows['id']; ?>'>
                                            <span class="btn btn-danger btn-xs">
                                                <i class="fas fa-eye"></i> View
                                            </span>
                                        </a>
                                    </td>

                                    <td>
                                    <a rel='facebox' href='paybill.php?id=<?php echo $rows['id']; ?>'>
                                        <span class="btn btn-info btn-xs glyphicon glyphicon-usd">Run</span>
                                    </a>
                                    </td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the common footer content -->
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        $('#datatableid').DataTable();
    });
</script>

<script>
    $(document).ready(function () {
        $('.editbtn').on('click', function () {
            $('#editmodal').modal('show');

            // Get the ID from the data-id attribute
            var id = $(this).data('id');

            // Log the ID to the console (optional)
            console.log('Edit button clicked for ID:', id);

            // Use the ID as needed
            $('#update_id').val(id);

            // Fetch the data from the table row
            var $tr = $(this).closest('tr');
            var user_Id = $tr.find('td:eq(1)').text(); // Replace with the correct column index
            var amount = $tr.find('td:eq(2)').text();   // Replace with the correct column index
            var status = $tr.find('td:eq(4)').text();   // Replace with the correct column index

            // Populate the form fields
            $('#user_Id').val(user_Id);
            $('#amount').val(amount);
            $('#status').val(status);
        });
    });
</script>

<script>
    function printBilling() {
        window.location.href = 'billing_pdf.php';
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#datatableid').DataTable();
    });
</script>

<?php
} else {
    // Redirect to the login page if the user is not authenticated
    header("Location: login.php");
    exit();
}
?>
