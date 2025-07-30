<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Only allow POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo "Invalid request method.";
  exit;
}

// CUSTOMER DETAILS
$name = $_POST["name"] ?? '';
$email = $_POST["email"] ?? '';
$phone = $_POST["phone"] ?? '';
$special = $_POST["special_requests"] ?? '';

// COOKIE QUANTITIES
$cookies = [
  "Banana Pudding Cookies" => (int) ($_POST["banana_pudding"] ?? 0),
  "Red Velvet Cookies" => (int) ($_POST["red_velvet"] ?? 0),
  "Salted Caramel Cookies" => (int) ($_POST["salted_caramel"] ?? 0),
  "S’mores Cookies" => (int) ($_POST["smores"] ?? 0),
  "Cookie Butter Cookies" => (int) ($_POST["cookie_butter"] ?? 0),
  "Cookie Monster Cookies" => (int) ($_POST["cookie_monster"] ?? 0),
  "Strawberry Crunch Cookies" => (int) ($_POST["strawberry_crunch"] ?? 0)
];

// PRICING FUNCTION
function calculatePrice($qty) {
  switch ($qty) {
    case 1: return 4;
    case 3: return 10;
    case 6: return 20;
    case 12: return 35;
    default: return 0;
  }
}

// CALCULATE ORDER
$total = 0;
$order_summary = "";

foreach ($cookies as $cookie => $qty) {
  if ($qty > 0) {
    $price = calculatePrice($qty);
    $order_summary .= "$cookie — $qty for \$$price\n";
    $total += $price;
  }
}

// CHECK FOR EMPTY ORDER
if ($total === 0) {
  http_response_code(400);
  echo "Error: No items selected.";
  exit;
}

// BUILD EMAIL
$admin_email = "jleonardmalone@gmail.com";
$subject = "New Order from $name – Jess So Sweet Treats";

$message = "Customer Name: $name\n";
$message .= "Email: $email\n";
$message .= "Phone: $phone\n\n";
$message .= "Order Summary:\n$order_summary";
$message .= "\nTotal: \$$total\n\n";
$message .= "Special Requests:\n$special\n";

// HEADERS
$headers = "From: orders@jesssosweettreats.com\r\n";
$headers .= "Reply-To: $email\r\n";

// SEND EMAILS
$sent_to_owner = mail($admin_email, $subject, $message, $headers);
$sent_to_customer = mail($email, "Your Order Confirmation – Jess So Sweet Treats", "Thank you for your order!\n\n$message", $headers);

// RETURN RESPONSE
if ($sent_to_owner && $sent_to_customer) {
  http_response_code(200);
  echo "Order placed successfully.";
} else {
  http_response_code(500);
  echo "Email sending failed. Owner: " . ($sent_to_owner ? "yes" : "no") . ", Customer: " . ($sent_to_customer ? "yes" : "no");
}
?>
