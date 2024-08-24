<?php
include 'db.php';

ob_start(); // Start output buffering

if (isset($_POST['insert_client'])) {
    // Check if usid is set in the $_POST array
    $usid = isset($_POST['usid']) ? $_POST['usid'] : '';
    $cname = $_POST['cname'];
    $lname = $_POST['lname'];
    $Mi = $_POST['Mi'];
    $address = $_POST['address'];
    $pnumber = $_POST['pnumber'];

    // Debugging: Print received values
    echo "Debug: usid=$usid, cname=$cname, lname=$lname, Mi=$Mi, address=$address, pnumber=$pnumber";

    // Check if the database connection is established
    if ($conn) {
        // Check if any existing data with similar values
        $check_query = "SELECT COUNT(*) FROM client WHERE usid = ? OR (cname = ? AND lname = ? AND Mi = ? AND address = ? AND pnumber = ?)";
        $check_stmt = mysqli_prepare($conn, $check_query);

        if ($check_stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($check_stmt, "ssssss", $usid, $cname, $lname, $Mi, $address, $pnumber);

            // Execute the statement
            mysqli_stmt_execute($check_stmt);

            // Bind result variables
            mysqli_stmt_bind_result($check_stmt, $count);

            // Fetch result
            mysqli_stmt_fetch($check_stmt);

            // Close the statement
            mysqli_stmt_close($check_stmt);

            if ($count > 0) {
                $error_msg = "Client with usid $usid or similar data already exists. Cannot create a duplicate account.";
            } else {
                // Insert client if usid doesn't exist
                $insert_query = "INSERT INTO client (`usid`,`cname`, `lname`, `Mi`,`address`,`pnumber`) VALUES (?, ?, ?, ?, ?, ?)";
                $insert_stmt = mysqli_prepare($conn, $insert_query);

                if ($insert_stmt) {
                    // Bind parameters
                    mysqli_stmt_bind_param($insert_stmt, "ssssss", $usid, $cname, $lname, $Mi, $address, $pnumber);

                    // Execute the statement
                    $query_run = mysqli_stmt_execute($insert_stmt);

                    if ($query_run) {
                        $success_msg = "Data Added Successfully";
                        echo '<script> 
                            alert("Data Added Successfully"); 
                            window.location.href = "client.php";
                        </script>';
                    } else {
                        $error_msg = "Data Not Saved";
                    }

                    // Close the statement
                    mysqli_stmt_close($insert_stmt);
                } else {
                    $error_msg = "Statement Preparation Error";
                }
            }
        } else {
            $error_msg = "Statement Preparation Error";
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        $error_msg = "Database Connection Error";
    }

    // Display error or success message
    if (isset($error_msg)) {
        echo '<div style="color: red;">' . $error_msg . '</div>';
    } elseif (isset($success_msg)) {
        echo '<div style="color: green;">' . $success_msg . '</div>';
    }
}

ob_end_flush(); // Flush output buffer
?>
