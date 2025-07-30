<?php
// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$special = $_POST['special_requests'];

$items = [
  "Banana Pudding Cookies" => $_POST['banana_pudding'],
  "Red Velvet Cookies" => $_POST['red_velvet'],
  "Salted Caramel Cookies" => $_POST['salted_caramel'],
  "S’mores Cookies" => $_POST['smores'],
  "Cookie Butter Cookies" => $_POST['cookie_butter'],
  "Cookie Monster Cookies" => $_POST['cookie_monster'],
  "Strawberry Crunch Cookies" => $_POST['strawberry_crunch']
];

// Pricing logic
function getPrice($qty) {
  switch ($qty) {
    case "1": return 4;
    case "3": return 10;
    case "6": return 20;
    case "12": return 35;
    default: return 0;
  }
}

// Build order details
$orderDetails = "";
$total = 0;

foreach ($items as $treat => $qty) {
  if ($qty > 0) {
    $price = getPrice($qty);
    $total += $price;
    $orderDetails .= "$treat: $qty - \$$price\n";
  }
}

// Compose message to customer
$customerSubject = "Thank You for Your Order – Jess So Sweet Treats!";
$customerMessage = "Hi $name,\n\nThank you for placing your order with Jess So Sweet Treats! Here's what we received:\n\n";
$customerMessage .= $orderDetails;
$customerMessage .= "\nTotal: \$$total\n\n";
$customerMessage .= "Special Requests:\n$special\n\n";
$customerMessage .= "We’ll be in touch soon to confirm pickup or delivery.\n\n🍪 With love,\nJess So Sweet Treats";

// Compose message to business
$ownerSubject = "New Order from $name";
$ownerMessage = "New order details:\n\n$orderDetails\nTotal: \$$total\n\n";
$ownerMessage .= "Name: $name\nEmail: $email\nPhone: $phone\n\nSpecial Requests:\n$special";

// Send emails
mail($email, $customerSubject, $customerMessage);
mail("jleonardmalone@gmail.com", $ownerSubject, $ownerMessage);

// Send SMS via email-to-text (optional)
// mail("6293087729@your-carrier-email.com", $ownerSubject, $ownerMessage); // Replace with real SMS gateway

// Return success response
http_response_code(200);
?>
