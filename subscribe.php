<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Path to store subscription data (create a writable directory)
    $filePath = __DIR__ . '/subscribed_emails.txt';

    // Retrieve and sanitize form data
    $email = sanitizeInput($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if the email already exists in the file
    if (file_exists($filePath) && strpos(file_get_contents($filePath), $email) !== false) {
        echo "exists";
        exit;
    }

    // Append email to the file
    if (file_put_contents($filePath, $email . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
        echo "success";
    } else {
        echo "failure";
    }
} else {
    // Not a POST request, show an error message
    echo "Method not allowed.";
}

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
