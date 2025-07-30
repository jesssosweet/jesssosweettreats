<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo "Invalid request method.";
  exit;
}

// Get customer details
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$phone   = $_POST['phone'] ?? '';
$special = $_POST['special_requests'] ?? '';

// Get cookie quantities (default to 0)
$items = [
  "Banana Pudding Cookies"    => $_POST['banana_pudding'] ?? 0,
  "Red Velvet Cookies"        => $_POST['red_velvet'] ?? 0,
  "Salted Caramel Cookies"    => $_POST['salted_caramel'] ?? 0,
  "S’mores Cookies"           => $_POST['smores'] ?? 0,
  "Cookie Butter Cookies"     => $_POST['cookie_butter'] ?? 0,
  "Cookie Monster Cookies"    => $_POST['cookie_monster'] ?? 0,
  "Strawberry Crunch Cookies" => $_POST['strawberry_crunch'] ?? 0
];

// Price logic based on quantity
function getPrice($qty) {
  switch ((int)$qty) {
    case 1:  return 4;
    case 3:  return 10;
    case 6:  return 20;
    case 12: return 35;
    default: return 0;
  }
}

// Build order summary
$orderDetails = "";
$total = 0;

foreach ($items as $cookie => $qty) {
  if ((int)$qty > 0) {
    $price = getPrice($qty);
    $total += $price;
    $orderDetails .= "$cookie: $qty - \$$price\n";
  }
}

// Error if nothing ordered
if (trim($orderDetails) === "") {
  http_response_code(400);
  echo "You must select at least one cookie.";
  exit;
}

// Email to customer
$customerSubject = "Your Jess So Sweet Treats Order Confirmation";
$customerMessage = "Hi $name,\n\nThanks for ordering from Jess So Sweet Treats!\n\n";
$customerMessage .= "Your Order:\n$orderDetails";
$customerMessage .= "\nTotal: \$$total\n\n";
$customerMessage .= "Special Requests:\n$special\n\n";
$customerMessage .= "We’ll reach out soon to confirm pickup or delivery.\n\n";
$customerMessage .= "🍪 With love,\nJess So Sweet Treats";

// Email to business owner
$ownerSubject = "New Order from $name";
$ownerMessage = "You've got a new order:\n\n$orderDetails\nTotal: \$$total\n\n";
$ownerMessage .= "Name: $name\nEmail: $email\nPhone: $phone\n\n";
$ownerMessage .= "Special Requests:\n$special";

// Send both emails
$customerSent = mail($email, $customerSubject, $customerMessage);
$ownerSent    = mail("jleonardmalone@gmail.com", $ownerSubject, $ownerMessage);

// Optional: Send SMS alert via email-to-text
// mail("6293087729@vtext.com", $ownerSubject, $ownerMessage); // Verizon example

// Send response to frontend
if ($customerSent && $ownerSent) {
  http_response_code(200);
  echo "Order placed successfully.";
} else {
  http_response_code(500);
  echo "There was a problem sending emails.";
}
?>
