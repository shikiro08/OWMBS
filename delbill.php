<?php
session_start();

include 'db.php';

// Check if 'id' is set in the request
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

if ($id === null) {
    // Handle the case where 'id' is not set or is null
    // You may redirect the user, show an error message, etc.
    die("Invalid request. Please provide a valid 'id'.");
}

// Use a prepared statement to avoid SQL injection
$stmt = mysqli_prepare($conn, "SELECT * FROM billing WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error: Data not found..");
}

$test = mysqli_fetch_array($result);

// The variable $id is already set, so use a different name for the fetched id
$recordId = $test['id'];
$lname = $test['user_Id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
</head>
<body>

<form action="delbillexec.php" method="post">
    <h1>Are you sure you want to delete this record <?php echo $recordId; ?></h1>
    <input type="hidden" name="id" value="<?php echo $recordId; ?>" />
    <input type="submit" name="ok" value="Delete">
</form>

</body>
</html>
