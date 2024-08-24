
<?php
if (isset($_POST['delete_client'])) {
    include("db.php");
    $id = $_POST['id'];

    // Check if $id is a non-empty string
    if (!empty($id) && is_string($id)) {
        $sql = "DELETE FROM client WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            session_start();
            $_SESSION["delete"] = "Client Deleted Successfully!";
        } else {
            die("Something went wrong");
        }
    } else {
        echo "Invalid or empty client id";
    }

    header("Location: client.php");
    exit();
}
?>
