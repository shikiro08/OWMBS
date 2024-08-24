<?php
if (isset($_POST['delete_admin'])) {
    include("db.php");
    $id = $_POST['id'];

    // Check if $id is a non-empty string
    if (!empty($id) && is_string($id)) {
        $sql = "DELETE FROM admins WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            session_start();
            $_SESSION["delete"] = "User Deleted Successfully!";
        } else {
            die("Something went wrong");
        }
    } else {
        echo "Invalid or empty client id";
    }

    header("Location: adminboard.php");
    exit();
}
?>


