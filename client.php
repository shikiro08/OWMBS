<?php
session_start();
include 'db.php';
include 'header.php';
include 'sidebar.php';
include 'footer.php';

$query = "SELECT * FROM client";
$result = mysqli_query($conn, $query);

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) :
?>

<!-- Include the common header content -->
<?php include 'header.php'; ?>

<div class="container-fluid px-4">
    <!-- Main content here -->
    <div class="container-fluid px-4">
        <!-- Your client-specific content goes here -->
        <div class="row my-5">
            <h2> Client Information </h2>
            <div class="card">
                <div class="card-body">
                    <!-- Include your modal content -->
                    <?php include 'Modals/client_modal.php'; ?>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clientaddmodal">
                            ADD DATA
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <?php
                    // Check if the search parameter is set
                    if(isset($_GET['search'])) {
                        $filtervalues = $_GET['search'];

                        // Add commas between the fields in CONCAT
                        $query = "SELECT * FROM client WHERE CONCAT(usid, ', ', cname, ', ', lname, ', ', Mi, ', ', address, ', ', pnumber) LIKE '%$filtervalues%'";
                        $query_run = mysqli_query($conn, $query);
                    ?>
                        <table id="clientTable" class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">User_id</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Mi</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone number</th>
                                    <th scope="col">Options</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (mysqli_num_rows($query_run) > 0) {
                                    while ($rows = mysqli_fetch_assoc($query_run)) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $rows['id']; ?></th>
                                            <td><?php echo $rows['usid']; ?></td>
                                            <td><?php echo $rows['cname']; ?></td>
                                            <td><?php echo $rows['lname']; ?></td>
                                            <td><?php echo $rows['Mi']; ?></td>
                                            <td><?php echo $rows['address']; ?></td>
                                            <td><?php echo $rows['pnumber']; ?></td>
                                            <td>
                                                <!-- Add delete button with a form -->
                                                <form method="post" action="delete_client.php" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                    <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="delete_client">Delete</button>
                                                </form>
                                            </td>
                                            <!-- Add update button linking to update_billing.php -->
                                            <td>
                                                <a href="update_client_form.php?id=<?php echo $rows['id']; ?>" class="btn btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No Record Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    } else {
                        // Display all records if no search parameter is set
                    ?>
                        <table id="clientTable" class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">User_id</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Mi</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone number</th>
                                    <th scope="col">Options</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($rows = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $rows['id']; ?></th>
                                        <td><?php echo $rows['usid']; ?></td>
                                        <td><?php echo $rows['cname']; ?></td>
                                        <td><?php echo $rows['lname']; ?></td>
                                        <td><?php echo $rows['Mi']; ?></td>
                                        <td><?php echo $rows['address']; ?></td>
                                        <td><?php echo $rows['pnumber']; ?></td>
                                        <td>
                                            <!-- Add delete button with a form -->
                                            <form method="post" action="delete_client.php" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" name="delete_client">Delete</button>
                                            </form>
                                        </td>
                                        <!-- Add update button linking to update_billing.php -->
                                        <td>
                                            <a href="update_client_form.php?id=<?php echo $rows['id']; ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the common footer content -->
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        $('#clientTable').DataTable();
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

<?php endif; ?>
