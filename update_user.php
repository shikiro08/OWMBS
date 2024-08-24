<?php
include 'db.php';

if (isset($_POST["edit"])) {
    $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
    $contact = mysqli_real_escape_string($conn, $_POST["contact"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pword = mysqli_real_escape_string($conn, $_POST["pword"]);

    $hashed_pword = md5($pword);

    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    // Check if there is already existing data with the same name, contact, email, and password
    $check_sql = "SELECT * FROM users WHERE uname='$uname' AND contact='$contact' AND email='$email' AND pword='$hashed_pword' AND id <> '$id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Existing data found, show an error message
        $error_msg = "The user with the same name, contact, email, and password already exists.";
        header("Location: edit_user_form.php?id=$id&error=$error_msg");
        exit();
    }

    // Proceed with the update
    $sqlUpdate = "UPDATE users SET uname = '$uname', contact = '$contact', email = '$email', pword = '$hashed_pword' WHERE id='$id'";
    
    if(mysqli_query($conn, $sqlUpdate)){
        $affected_rows = mysqli_affected_rows($conn);

        if ($affected_rows == 1) {
            // Only one row was affected, which is expected
            session_start();
            $_SESSION["update"] = "User Updated Successfully!";
            header("Location: users.php");
        } elseif ($affected_rows == 0) {
            // No rows were affected, which means the user with the given ID doesn't exist
            die("User with ID $id not found");
        } else {
            // More than one row affected, which might indicate an issue
            die("Error: More than one row affected. Something went wrong.");
        }
    } else {
        die("Something went wrong");
    }
}
?>
