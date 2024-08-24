<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
include 'db.php';
include 'header.php';
include 'sidebar.php';
include 'footer.php';

$query = "SELECT * FROM admins"; // Change the table name to 'admins'
$result = mysqli_query($conn, $query);

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {
?>

<!-- Include the common header content -->
<?php include 'header.php'; ?>

<div class="container-fluid px-4">
    <!-- Main content here -->
    <div class="container-fluid px-4">
        <!-- Your user-specific content goes here -->
        <div class="row my-5">
            <h2>Admin Information</h2>
            <div class="card">
                <div class="card-body">
                    <!-- Include your modal content -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adminaddmodal">
                        ADD DATA
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="userTable" class="table bg-white rounded shadow-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">User_name</th>
                                <th scope="col">pword</th>
                                <th scope="col">Options</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['name']; ?></td>
                                    <td><?php echo $rows['position']; ?></td>
                                    <td><?php echo $rows['uname']; ?></td>
                                    <td><?php echo $rows['pword']; ?></td>
                                    <td>
                                        <!-- Add delete button with a form -->
                                        <form method="post" action="delete_admin.php" onsubmit="return confirmDelete(<?php echo $rows['id']; ?>, '<?php echo $rows['uname']; ?>');">
                                            <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_admin">Delete</button>
                                        </form>
                                    </td>
                                    <!-- Add update button linking to update_user.php -->
                                    <td>
                                        <a href="update_admin_form.php?id=<?php echo $rows['id']; ?>" class="btn btn-warning">Edit</a>
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
<?php
echo '<div class="modal fade" id="adminaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="add_admin.php" method="POST">
                <div class="modal-body">
                
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                
                    <!-- Input for Position (assuming contact is position) -->
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" name="position" class="form-control" placeholder="Enter Position" required>
                    </div>
                    
                    <!-- Input for User Name -->
                    <div class="form-group">
                        <label for="uname">User Name:</label>
                        <input type="text" name="uname" class="form-control" placeholder="Enter User Name" required>
                    </div>

                    <!-- Input for Password -->
                    <div class="form-group">
                        <label for="pword">Password:</label>
                        <input type="password" name="pword" class="form-control" placeholder="Enter Password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="insert_admin" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>';
?>

<!-- Include the common footer content -->
<?php include 'footer.php'; ?>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable();

        function confirmDelete(userId, userName) {
            var confirmation = confirm("Are you sure you want to delete the user with ID " + userId + " and username " + userName + "?");

            return confirmation; // Return true or false to allow or prevent form submission
        }
    });
</script>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
