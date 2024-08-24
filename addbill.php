<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Start output buffering

if (isset($_POST['insert_billing'])) {
    // Check if client_id is set in the $_POST array
    $client_id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Ensure it's an integer
    $prev = floatval($_POST['prev']);
    $pres = floatval($_POST['pres']);
    $totalcun = abs($prev - $pres);
    $price = floatval($_POST['price']);
    $pricetotal = $totalcun * $price;
    $status = $_POST['status'];

    // Check if the database connection is established
    if ($conn) {
        // Use prepared statement for INSERT into billing
        $insertQuery = "INSERT INTO billing (`user_Id`, `prev`, `pres`, `amount`, `pdate`, `status`) VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmtInsert = mysqli_prepare($conn, $insertQuery);

        // Use prepared statement for INSERT into billing_history
        $inserttQuery = "INSERT INTO billing_history (`C_id`, `amount`, `payment_date`) VALUES (?, ?, NOW())";
        $stmttInsert = mysqli_prepare($conn, $inserttQuery);

        // Execute the INSERT statement for billing table
        if ($stmtInsert) {
            // Bind parameters for INSERT
            mysqli_stmt_bind_param($stmtInsert, "iddds", $client_id, $prev, $pres, $pricetotal, $status);

            // Execute the INSERT statement
            $queryRunInsert = mysqli_stmt_execute($stmtInsert);

            // Close the INSERT statement
            mysqli_stmt_close($stmtInsert);

            if (!$queryRunInsert) {
                // Data not saved, display error message
                echo '<script> alert("Data Not Saved"); </script>';
            }
        } else {
            // Statement preparation failed, display error message
            echo '<script> alert("Statement Preparation Error for billing table"); </script>';
        }

        // Execute the INSERT statement for billing_history table
        if ($stmttInsert) {
            // Bind parameters for INSERT into billing_history
            mysqli_stmt_bind_param($stmttInsert, "dd", $client_id, $pricetotal);
        
            // Execute the INSERT statement for billing_history
            $queryRunInsertt = mysqli_stmt_execute($stmttInsert);
        
            // Close the INSERT statement for billing_history
            mysqli_stmt_close($stmttInsert);
        
            if (!$queryRunInsertt) {
                // Data not saved, display error message
                echo '<script> alert("Data Not Saved for billing_history"); </script>';
            }
        } else {
            // Statement preparation failed, display error message
            echo '<script> alert("Statement Preparation Error for billing_history table"); </script>';
        }

        // If both inserts are successful, redirect with success message
        if ($queryRunInsert && $queryRunInsertt) {
            header("Location: billing.php?success=true");
            exit();
        }
    } else {
        // Database connection error, display error message
        echo '<script> alert("Database Connection Error"); </script>';
    }
}

ob_end_flush(); // Flush output buffer
?>
