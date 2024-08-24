<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Start output buffering

if (isset($_POST['insert_billing'])) {
    // Check if user_id is set in the $_POST array
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0; // Ensure it's an integer
    $amount = $_POST['amount'];
    $pdate = $_POST['pdate'];
    $status = $_POST['status'];

    // Check if the database connection is established
    if ($conn) {
        // Use prepared statement
        $query = "INSERT INTO billing (`user_Id`,`amount`,`pdate`,`status`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "iiss", $user_id, $amount, $pdate, $status);

            // Execute the statement
            $query_run = mysqli_stmt_execute($stmt);

            if ($query_run) {
                // Data added successfully, redirect with success message
                header("Location: billing.php?success=true");
                exit();
            } else {
                // Data not saved, display error message
                echo '<script> alert("Data Not Saved"); </script>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Statement preparation failed, display error message
            echo '<script> alert("Statement Preparation Error"); </script>';
        }
    } else {
        // Database connection error, display error message
        echo '<script> alert("Database Connection Error"); </script>';
    }
}

ob_end_flush(); // Flush output buffer
?>
