
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f0f0; /* Set your desired background color */
        }
        form {
            max-width: 350px;
            background-color: #ffffff; /* Set background color for the form */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<?php
session_start();
include 'db.php';

// Assuming 'client_id' is passed as a query parameter
$client_id = $_REQUEST['id'];

// Fetch client information
$result = mysqli_query($conn, "SELECT * FROM client WHERE id = '$client_id'");
$client = mysqli_fetch_array($result);
if (!$result || mysqli_num_rows($result) == 0) {
    //header("Location: billing.php");
    die("Error: Data not found.");
}


$id = $client['id'];
$cname = $client['cname'];
$lname = $client['lname'];
$mi = $client['Mi']; // Corrected the variable name
$address = $client['address'];
$contact = $client['pnumber'];

// Fetch previous reading from tempo_bill
$q = mysqli_query($conn, "SELECT pres FROM billing WHERE user_Id = '$client_id' ORDER BY pdate DESC LIMIT 1");

if (!$q || mysqli_num_rows($q) == 0) {
    $previous = null;  // Set to a default value or handle accordingly
} else {
    $tempoResult = mysqli_fetch_array($q);
    $previous = $tempoResult['pres'];
}
?>
<p><h1>Client Bill <?php echo $id;?></h1></p>
<h1>Name: <?php echo $lname . '&nbsp;' . $cname . '&nbsp;' . $mi; ?></h1>
<p><?php $date = date('y/m/d H:i:s');
    echo $date; ?></p>
<form method="post" action="addbill.php">
    <table width="346" border="1">
        <tr>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <td width="118">Previous Reading:</td>
            <td width="66"><input type="text" name="prev" value="<?php echo $previous; ?>" pattern="[0-9]*" title="Please enter only numbers"/></td>
            <td>ml</td>
        </tr> 
        <tr>
            <td>Present Reading:</td>
            <td><input type="text" name="pres" pattern="[0-9]*"  required/></td>
            <td>ml</td>
        </tr>
        <tr>
            <td>Price/ml</td>
            <td><input type="text" name="price" value="10" pattern="[0-9]*" required/></td>
            <td>Tshs</td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>
                <select name="status">
                    <option value="active">Active</option>
                    <option value="cut">Disconnected</option>
                    <option value="pending">Pending</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="insert_billing" value="submit" /></td>
        </tr>
    </table>
</form>
</body>
</html>
