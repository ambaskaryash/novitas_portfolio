<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set your email address where you want to receive emails.
    $toEmail = "ambaskaryash@novitaswebworks.in"; // Replace with your email address

    // Retrieve and sanitize form data
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $message = sanitizeInput($_POST['message']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.html?status=error"); // Redirect with error status
        exit;
    }

    // Email subject
    $subject = "New Contact Form Submission";

    // Email content
    $emailContent = "Name: $name\n";
    $emailContent .= "Email: $email\n\n";
    $emailContent .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($toEmail, $subject, $emailContent, $headers)) {
        header("Location: contact.html?status=success"); // Redirect with success status
        exit;
    } else {
        header("Location: contact.html?status=error"); // Redirect with error status
        exit;
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
