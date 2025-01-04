<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $notes = htmlspecialchars(trim($_POST['details']));
    $flavours = $_POST['flavour']; // Flavours array with quantities

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        die("All required fields must be filled out.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Prepare flavours with quantities
    $flavourDetails = "";
    foreach ($flavours as $flavour => $quantity) {
        if ($quantity > 0) {
            $flavourDetails .= "$flavour: $quantity\n";
        }
    }

    if (empty($flavourDetails)) {
        die("Please select at least one flavour.");
    }

    // Prepare the email
    $to = "adzokatsekaleb@gmail.com"; // Replace with your email
    $subject = "New Chin Chin Order from $name";
    $message = "Order Details:\n\n"
             . "Name: $name\n"
             . "Email: $email\n"
             . "Phone: $phone\n"
             . "Delivery Address: $address\n\n"
             . "Flavours:\n$flavourDetails\n"
             . "Further Details: $details\n";
    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you, $name! Your order has been received.";
    } else {
        echo "Sorry, there was an error sending your order. Please try again later.";
    }
}
?>