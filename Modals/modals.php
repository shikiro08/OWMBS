<!-- Modal for Adding Student Data -->
<?php
include 'header_modal.php';

?>
 <div class="modal fade" id="billingaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Billing Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="add_billing.php" method="POST">
                <div class="modal-body">
                    <!-- Add other billing form fields here -->
                   <?php $userQuery = "SELECT id, cname FROM client";
                        $userResult = mysqli_query($conn, $userQuery);

                    // Check for errors
                    if (!$userResult) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    ?>
                    <!-- Dropdown for selecting user -->
                    <div class="form-group">
                        <label for="userId">Select Client:</label>
                        <select class="form-control" id="userId" name="user_id" required>
                            <?php while ($user = mysqli_fetch_assoc($userResult)) : ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['cname']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label> Amount </label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
                    </div>

                    <div class="form-group">
                        <label> Payment Date </label>
                        <input type="date" name="pdate" id="pdate" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label> Status </label>
                        <input type="text" name="status" class="form-control" placeholder="Enter Status" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="insert_billing" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="useraddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Users Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="add_user.php" method="POST">
                <div class="modal-body">
                    <!-- Dropdown for selecting user -->
                    <div class="form-group">
                        <label for="userId">User Name</label>
                        <input type="text" name="uname" class="form-control" placeholder="Enter User Name" required>
                    </div>

                    <div class="form-group">
                        <label>Contact number</label>
                        <input type="text" name="contact" class="form-control" placeholder="Enter Contact Number" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter Email Address" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pword" class="form-control" placeholder="Enter Password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="insert_user" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for Editing user Data -->
<!-- Modal -->
<div class="modal fade" id="editusermodal" tabindex="-1" role="dialog" aria-labelledby="user modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModal"> Edit User Data </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="update_user.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label> Password </label>
                        <input type="password" name="pword" class="form-control" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <label> Confirm Password </label>
                        <input type="password" name="cpword" class="form-control" placeholder="confirm Password" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php
include("db.php"); // Include the database connection code at the beginning

// Initialize variables to avoid "Undefined variable" warning
$id = $amount = $status = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM billing WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    } else {
        while ($row = mysqli_fetch_array($result)) {
            // Assign values to variables
            $amount = $row['amount'];
            $status = $row['status'];
        }
    }
}
?>
<!-- Modal for Editing billing Data -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="Billing modal"
    aria-hidden="true">
    <!-- Edit Student Data Form -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Edit Student Data Form Content -->
            <div class="modal-header">
                <h5 class="modal-title" id="Billing Modal"> Edit Billing Data (ID: <?php echo $id; ?>) </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="update_billing.php" method="POST">

                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label> Amount </label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" required value="<?php echo $amount; ?>">
                    </div>

                    <div class="form-group">
                        <label> Status </label>
                        <input type="text" name="status" class="form-control" placeholder="Enter Status" required value="<?php echo $status; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for Deleting Student Data -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <!-- Delete Student Data Confirmation Form -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Delete Student Data Confirmation Form Content -->
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="deletecode.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4> Do you want to Delete this Data ??</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Modal for Viewing Student Data -->
<div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <!-- View Student Data Form -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- View Student Data Form Content -->
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> View Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="deletecode.php" method="POST">

                    <div class="modal-body">

                        <input type="text" name="view_id" id="view_id">

                        <!-- <p id="fname"> </p> -->
                        <h4 id="fname"> <?php echo ''; ?> </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
                        <!-- <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button> -->
                    </div>
                </form>
        </div>
    </div>
</div>



<script>
    // Function to toggle password visibility
    function togglePassword() {
        var passwordInput = document.getElementById("passwordInput");
        var toggleButton = document.getElementById("toggleButton");

        // Check the type of the password input
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.innerHTML = "Hide Password";
        } else {
            passwordInput.type = "password";
            toggleButton.innerHTML = "Show Password";
        }
    }
</script>
<?php include 'footer_modal.php'; ?>