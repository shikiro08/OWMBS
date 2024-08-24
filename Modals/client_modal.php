<!-- Modal for Adding Student Data -->
<?php
include 'header_modal.php';

?>
 <div class="modal fade" id="clientaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Client Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="add_client.php" method="POST">
                <div class="modal-body">
                    <!-- Add other billing form fields here -->
                   <?php $userQuery = "SELECT id, uname FROM users";
                        $userResult = mysqli_query($conn, $userQuery);

                    // Check for errors
                    if (!$userResult) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    ?>
                    <!-- Dropdown for selecting user -->
                    <div class="form-group">
                        <label for="userId">Select Client:</label>
                        <select class="form-control" id="userId" name="usid" required>
                            <?php while ($user = mysqli_fetch_assoc($userResult)) : ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['uname']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label> First Name </label>
                        <input type="text" name="cname" class="form-control" placeholder="Enter First name" required>
                    </div>

                    <div class="form-group">
                        <label> Last Name </label>
                        <input type="text" name="lname" class="form-control" placeholder="Enter Last name" required>
                    </div>

                    <div class="form-group">
                        <label> Mi </label>
                        <input type="text" name="Mi" class="form-control" placeholder="Enter Mi" required>
                    </div>

                    <div class="form-group">
                        <label> address </label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" required>
                    </div>

                    <div class="form-group">
                        <label> Phonenumber </label>
                        <input type="text" name="pnumber" class="form-control" placeholder="Enter Phonenumber" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="insert_client" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Student Data -->
<div class="modal fade" id="edit_client_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit client Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="update_client.php" method="POST">
                <div class="modal-body">
                    <?php
                    if (isset($_GET['id'])) {
                        include("db.php");
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM client WHERE id=$id";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                    }
                    ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <h1><?php echo $id; ?></h1>
                    <div class="form-group">
                        <label for="cname">First Name</label>
                        <input type="text" name="cname" class="form-control" value="<?php echo $row['cname']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo $row['lname']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Mi">Middle Name</label>
                        <input type="text" name="Mi" class="form-control" value="<?php echo $row['Mi']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo $row['Address']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pnumber">Phonenumber</label>
                        <input type="text" name="pnumber" class="form-control" value="<?php echo $row['Phonenumber']; ?>" required>
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


<!-- Modal for Deleting Client Data -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <!-- Delete Student Data Confirmation Form -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Delete Student Data Confirmation Form Content -->
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete client Data </h5>
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
<?php include 'footer_modal.php'; ?>