<?php
// Database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Your Twilio credentials
$username = 'Deniell';
$password = 'D3@th089';

// Check if the form is submitted
if (isset($_POST['send_sms'])) {
    // Fetch client contact numbers with necessary data
    $query = "SELECT billing.id, billing.user_id, client.cname, client.pnumber, billing.prev, billing.pres, billing.pdate, billing.status
              FROM billing
              JOIN client ON billing.user_id = client.usid
              WHERE billing.id IN (
                  SELECT MAX(id) AS id
                  FROM billing
                  GROUP BY user_id
              )";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Loop through the results and construct SMS API URL
    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate additional values
        $totalcons = abs($row['pres'] - $row['prev']);
        $price = 10; // Adjust the price per your requirements
        $bill = $totalcons * $price;

        // Construct message based on database values
        $message = "Bill ID: {$row['id']}, User ID: {$row['user_id']}, Client Name: {$row['cname']}, Contact Number: {$row['pnumber']}, Previous Reading: {$row['prev']}, Present Reading: {$row['pres']}, Total Consumption: {$totalcons}, Price: {$price}, Date: {$row['pdate']}, Bill Amount: {$bill}, Status: {$row['status']}";

        // URL encode the message
        $message = urlencode($message);

        // Twilio API URL
        $apiUrl = 'http://192.168.2.107:8090/SendSMS';

        // Construct SMS API URL
        $smsApiUrl = "$apiUrl?username=$username&password=$password&phone={$row['pnumber']}&message=$message";

        // Display a confirmation message
        echo "SMS will be sent with the following message:\n";
        echo $message . "\n";
        echo "SMS API URL: $smsApiUrl\n";
        
    }
}

// Close database connection
mysqli_close($conn);
?>
