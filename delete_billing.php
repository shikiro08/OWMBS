<?php
include 'db.php';

if (isset($_POST['delete_billing'])) {
    // Check if billing_id is set in the $_POST array
    $billing_id = isset($_POST['delete_billing']) ? $_POST['delete_billing'] : '';

    // Check if the database connection is established
    if ($conn) {
        // Create the DELETE query for the billing table
        $query = "DELETE FROM billing WHERE id = ?";

        // Use a prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $billing_id);

        // Debug: Log the SQL query
        error_log("SQL Query: " . $query);

        // Perform the deletion query
        $query_run = mysqli_stmt_execute($stmt);

        // Check if the deletion was successful
        if ($query_run) {
            echo '<script> 
                    var result = ' . json_encode($query_run) . ';
                    alert("Data Deleted. Result: " + result); 
                    window.location.href = "billing.php";
                  </script>';
        } else {
            echo '<script> 
                    alert("Data Not Deleted: ' . mysqli_stmt_error($stmt) . '"); 
                  </script>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo '<script> alert("Database Connection Error"); </script>';
    }
}
?>
