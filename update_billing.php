<?php
include 'db.php';

if (isset($_POST['updatedata'])) {
    // Check if billing_id and other fields are set in the $_POST array
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $pdate = mysqli_real_escape_string($conn, $_POST["pdate"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    // Check if the database connection is established
    if ($conn) {
        // Create the UPDATE query
        $query = "UPDATE billing SET amount = '$amount', pdate = '$pdate', status = '$status' WHERE id = '$id'";
        
        // Perform the update query
        $query_run = mysqli_query($conn, $query);

        // Check if the update was successful
        if ($query_run) {
            echo '<script> 
                alert("Data Updated"); 
                window.location.href = "billing.php";
            </script>';
            
        } else {
            echo '<script> 
                alert("Error updating data: ' . mysqli_error($conn) . '"); 
            </script>';
        }
    }
}
?>
