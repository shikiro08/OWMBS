<?php
// Database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

//$apiKey = '71e236ec7db2a8793a6fdd7555849329'; // Replace with your actual API key
$sendername = 'rwsawal'; // Replace with your desired sender name

// Fetch client contact numbers
$query = "SELECT billing.user_id, client.cname, client.lname, client.Mi, client.pnumber, billing.pres, billing.amount
          FROM billing
          JOIN client ON billing.user_id = client.id
          WHERE billing.id IN (
              SELECT MAX(id) AS id
              FROM billing
              GROUP BY user_id
          )";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Initialize cURL session
$ch = curl_init();

// Loop through the results and send messages to each client
while ($row = mysqli_fetch_assoc($result)) {
    // Fetched phone number
    $phoneNumber = $row['pnumber'];

    // Calculate additional values

    // Construct message for each client (customize this based on your needs)
    $message = "Client Name: {$row['cname']} {$row['lname']} {$row['Mi']}, Contact Number: {$row['pnumber']}, Present Reading: {$row['pres']}, Amount: {$row['amount']}";


    // Construct parameters array for Semaphore API
    $parameters = array(
        'apikey' => $apiKey,
        'number' => $phoneNumber,
        'message' => $message,
        'sendername' => $sendername
    );

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $output = curl_exec($ch);

    // Display raw response from Semaphore API for debugging
    echo '<pre>';
    print_r($output);
    echo '</pre>';

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        // Decode the JSON response
        $responseData = json_decode($output, true);

        // Display the response in a user-friendly way
        if (isset($responseData['success']) && $responseData['success']) {
            echo '<div class="mt-3 alert alert-success" role="alert">';
            echo '<strong>Success!</strong> Message sent successfully to ' . $phoneNumber;
            echo '</div>';
        } else {
            echo '<div class="mt-3 alert alert-danger" role="alert">';
            echo '<strong>Error!</strong> Failed to send message to ' . $phoneNumber . '. ' . (isset($responseData['message']) ? $responseData['message'] : 'Unknown error occurred.');
            echo '</div>';
        }
    }
}

// Close cURL session
curl_close($ch);

// Close database connection
mysqli_close($conn);
?>