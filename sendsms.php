<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';
include 'header.php';
include 'sidebar.php';
include 'footer.php';

if (isset($_SESSION['id']) && isset($_SESSION['uname'])) {
?>

<div class="container-fluid">
    <div class="row my-5">
        <h2>User Information</h2>
        <div class="card">
            <div class="card-body">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">SMS Form</h5>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label for="apiKey" class="form-label">API Key:</label>
                                <input type="text" id="apiKey" name="apiKey" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="recipientNumbers" class="form-label">Recipient Numbers (comma-separated):</label>
                                <input type="text" id="recipientNumbers" name="recipientNumbers" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                                <small id="messageHelp" class="form-text text-muted">
                                    You can use placeholders like [Client name], [users table id], [Amount], [Due Date].
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="sendername" class="form-label">Sender Name:</label>
                                <input type="text" id="sendername" name="sendername" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Send SMS</button>
                        </form>

                        <div class="mt-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Guide Message</h5>
                                <p>
                                    Dear [Client name],<br>
                                    This is a friendly reminder about your upcoming bill.<br><br>
                                    Account Number: [users table id]<br>
                                    Bill Amount: $[Amount]<br>
                                    Due Date: [Due Date]<br><br>
                                    To ensure on-time payment and avoid any late fees, kindly settle your bill by the due date.<br><br>
                                    Thank you for choosing our services!<br><br>
                                    Best regards,<br>
                                    [RWSAWAL]
                                </p>
                            </div>
                        </div>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Your existing code for sending SMS...
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Retrieve form data
                                $apiKey = $_POST['apiKey'];
                                $recipientNumbers = $_POST['recipientNumbers']; // Comma-separated numbers
                                $message = $_POST['message'];
                                $sendername = $_POST['sendername'];

                                // Construct API parameters
                                $parameters = array(
                                    'apikey' => $apiKey,
                                    'number' => $recipientNumbers,
                                    'message' => $message,
                                    'sendername' => $sendername
                                );

                                // Initialize cURL session
                                $ch = curl_init();

                                // Set cURL options
                                curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                // Execute cURL session
                                $output = curl_exec($ch);

                                // Check for cURL errors
                                if (curl_errno($ch)) {
                                    echo 'Curl error: ' . curl_error($ch);
                                } else {
                                    // Decode the JSON response
                                    $responseData = json_decode($output, true);

                                    // Display the response in a user-friendly way
                                    echo '<div class="mt-3 alert alert-' . (isset($responseData['success']) && $responseData['success'] ? 'success' : 'danger') . '" role="alert">';
                                    echo '<strong>' . (isset($responseData['success']) && $responseData['success'] ? 'Success!' : 'Error!') . '</strong> ' . (isset($responseData['message']) ? $responseData['message'] : 'Unknown error occurred.');
                                    echo '</div>';
                                }

                                // Close cURL session
                                curl_close($ch);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the common footer content -->
<?php include 'footer.php'; ?>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
