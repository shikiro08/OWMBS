<?php
include 'db.php';

ob_start(); // Start output buffering

if (isset($_POST['insert_user'])) {
    // Check if user_id is set in the $_POST array
    $uname = isset($_POST['uname']) ? $_POST['uname'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pword = isset($_POST['pword']) ? $_POST['pword'] : '';

    $hashed_pword = md5($pword);

    // Check if the database connection is established
    if ($conn) {
        $check_sql = "SELECT * FROM users WHERE uname='$uname' OR contact='$contact' OR email='$email' OR pword='$hashed_pword'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $error_msg = "The username, contact, email, or password is already taken, please choose another.";
            header("Location: users.php?error=$error_msg&uname=$uname&contact=$contact&email=$email");
            echo '<script> 
                    alert("The username, contact, email, or password is already taken, please choose another"); 
                    window.location.href = "users.php";
                  </script>';
            exit();
        }

        $query = "INSERT INTO users (`uname`,`contact`,`email`,`pword`) VALUES ('$uname','$contact','$email','$hashed_pword')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo '<script> 
                    alert("Data Added Successfully");
                    window.location.href = "users.php";
                  </script>';
        } else {
            $error_msg = mysqli_error($conn);
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
