<?php
include 'db.php';

ob_start(); // Start output buffering

if (isset($_POST['insert_admin'])) {
    // Check if user_id is set in the $_POST array
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $uname = isset($_POST['uname']) ? $_POST['uname'] : '';
    $pword = isset($_POST['pword']) ? $_POST['pword'] : '';

    $hashed_pword = md5($pword);

    // Check if the database connection is established
    if ($conn) {
        // Check if any existing data with similar values
        $check_query = "SELECT * FROM admins WHERE  name = ? OR position = ? OR uname = ? OR pword = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);

        if ($check_stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($check_stmt, "ssss", $name, $position, $uname, $hashed_pword);

            // Execute the statement
            mysqli_stmt_execute($check_stmt);

            // Store the result so that we can fetch it
            mysqli_stmt_store_result($check_stmt);

            // Check if any rows are returned
            if (mysqli_stmt_num_rows($check_stmt) > 0) {
                $error_msg = "The username, position, email, or password is already taken, please choose another.";
                header("Location: admin.php?error=$error_msg&name=$name&position=$position&uname=$uname");
                echo '<script> 
                        alert("The username, position, email, or password is already taken, please choose another"); 
                        window.location.href = "admin.php";
                      </script>';
                exit();
            }

            // Close the statement
            mysqli_stmt_close($check_stmt);

            // Insert admin if no similar data exists
            $insert_query = "INSERT INTO admins (`name`,`position`,`uname`,`pword`) VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_query);

            if ($insert_stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $position, $uname, $hashed_pword);

                // Execute the statement
                $query_run = mysqli_stmt_execute($insert_stmt);

                if ($query_run) {
                    echo '<script> 
                            alert("Data Added Successfully"); 
                            window.location.href = "adminboard.php";
                          </script>';
                } else {
                    $error_msg = mysqli_error($conn);
                    echo '<script> 
                            alert("Error: ' . $error_msg . '"); 
                          </script>';
                }

                // Close the statement
                mysqli_stmt_close($insert_stmt);
            } else {
                $error_msg = "Statement Preparation Error";
                echo '<script> 
                        alert("Error: ' . $error_msg . '"); 
                      </script>';
            }
        } else {
            $error_msg = "Statement Preparation Error";
            echo '<script> 
                    alert("Error: ' . $error_msg . '"); 
                  </script>';
        }
    } else {
        echo '<script> 
                alert("Database Connection Error"); 
              </script>';
    }
}

ob_end_flush(); // Flush output buffer
?>
