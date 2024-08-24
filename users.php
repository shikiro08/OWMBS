<?php
session_start();
include 'db.php';
include 'header.php';
include 'sidebar.php';
include 'footer.php';

$query = "SELECT * FROM users";
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
            <h2>User Information</h2>
            <div class="card">
                <div class="card-body">
                    <!-- Include your modal content -->
                    <?php include 'Modals/modals.php'; ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#useraddmodal">
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
                                <th scope="col">User_name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">pword</th>
                                <th scope="col">Options</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rows = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <th scope="row"><?php echo $rows['id']; ?></th>
                                    <td><?php echo $rows['uname']; ?></td>
                                    <td><?php echo $rows['contact']; ?></td>
                                    <td><?php echo $rows['email']; ?></td>
                                    <td><?php echo $rows['pword']; ?></td>
                                    <td>
                                        <!-- Add delete button with a form -->
                                        <form method="post" action="delete_user.php" onsubmit="return confirmDelete(<?php echo $rows['id']; ?>, '<?php echo $rows['uname']; ?>');">
                                            <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" name="delete_user">Delete</button>
                                        </form>
                                    </td>
                                    <!-- Add update button linking to update_user.php -->
                                    <td>
                                            <a href="update_user_form.php?id=<?php echo $rows['id']; ?>" class="btn btn-warning">Edit</a>
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
        $('#userTable').DataTable();
    });

    function confirmDelete(userId, userName) {
        var confirmation = confirm("Are you sure you want to delete the user with ID " + userId + " and username " + userName + "?");

        return confirmation; // Return true or false to allow or prevent form submission
    }
</script>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
