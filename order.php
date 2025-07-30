<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Make sure this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Method Not Allowed
  echo "Invalid request method.";
  exit;
}

// Get posted form data safely
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$phone   = $_POST['phone'] ?? '';
$special = $_POST['special_requests'] ?? '';

$items = [
  "Banana Pudding Cookies"    => $_POST['banana_pudding'] ?? 0,
  "Red Velvet Cookies"        => $_POST['red_velvet'] ?? 0,
  "Salted Caramel Cookies"    => $_POST['salted_caramel'] ?? 0,
  "S’mores Cookies"           => $_POST['smores'] ?? 0,
  "Cookie Butter Cookies"     => $_POST['cookie_butter'] ?? 0,
  "Cookie Monster Cookies"    => $_POST['cookie_monster'] ?? 0,
  "Strawberry Crunch Cookies" => $_POST['strawberry_crunch'] ?? 0
];

// Pricing function
function getPrice($qty) {
  switch ((int)$qty) {
    case 1:  return 4;
    case 3:  return 10;
    case 6:  return 20;
    case 12: return 35;
    default: return 0;
  }
}

// Build the order summary
$orderDetails = "";
$total = 0;

foreach ($items as $treat => $qty) {
  if ($qty > 0) {
    $price = getPrice($qty);
    $total += $price;
    $orderDetails .= "$treat: $qty - \$$price\n";
  }
}

// If no items were selected, return error
if (trim($orderDetails) === "") {
  http_response_code(400);
  echo "No items selected.";
  exit;
}

// Email to customer
$customerSubject = "Your Jess So Sweet Treats Order Confirmation";
$customerMessage = "Hi $name,\n\nThank you for placing an order with Jess So Sweet Treats! Here's what you ordered:\n\n";
$customerMessage .= $orderDetails;
$customerMessage .= "\nTotal: \$$total\n\n";
$customerMessage .= "Special Requests:\n$special\n\n";
$customerMessage .= "We'll be in touch soon to confirm pickup or delivery.\n\n";
$customerMessage .= "🍪 Sweetly,\nJess So Sweet Treats";

// Email to you (the business)
$ownerSubject = "New Order from $name";
$ownerMessage = "New order received:\n\n$orderDetails\nTotal: \$$total\n\n";
$ownerMessage .= "Customer Info:\nName: $name\nEmail: $email\nPhone: $phone\n";
$ownerMessage .= "Special Requests:\n$special";

// Send emails
$customerSent = mail($email, $customerSubject, $customerMessage);
$ownerSent    = mail("jleonardmalone@gmail.com", $ownerSubject, $ownerMessage);

// Optional: send SMS via email-to-text (carrier dependent)
// mail("6293087729@vtext.com", $ownerSubject, $ownerMessage);

if ($customerSent && $ownerSent) {
  http_response_code(200);
  echo "Order received and emails sent!";
} else {
  http_response_code(500);
  echo "There was a problem sending emails. Please try again.";
}
?>
