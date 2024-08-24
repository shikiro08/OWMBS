
<?php
include 'db.php';
if (isset($_POST["edit"])) {
    $cname = mysqli_real_escape_string($conn, $_POST["cname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $Mi = mysqli_real_escape_string($conn, $_POST["Mi"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $pnumber = mysqli_real_escape_string($conn, $_POST["pnumber"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE client SET  cname = '$cname', lname = '$lname', Mi = '$Mi', address = '$address', pnumber = '$pnumber' WHERE id='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Client Updated Successfully!";
        header("Location:client.php");
    }else{
        die("Something went wrong");
    }
}
?>