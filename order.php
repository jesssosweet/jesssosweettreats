<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Your contact info
  $to = "jleonardmalone@gmail.com";
  $textTo = "16293087729@vtext.com"; // Text notification (adjust carrier if needed)

  // Customer input
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $special = $_POST['special_requests'];

  // Treat quantities
  $items = [
    'Banana Pudding' => $_POST['banana_pudding'],
    'Red Velvet' => $_POST['red_velvet'],
    'Salted Caramel' => $_POST['salted_caramel'],
    'S’mores' => $_POST['smores'],
    'Cookie Butter' => $_POST['cookie_butter'],
    'Cookie Monster' => $_POST['cookie_monster'],
    'Strawberry Crunch' => $_POST['strawberry_crunch']
  ];

  // Count total cookies and build order summary
  $totalQty = 0;
  $orderDetails = "";

  foreach ($items as $treat => $qty) {
    $qty = intval($qty);
    if ($qty > 0) {
      $totalQty += $qty;
      $orderDetails .= "$treat: $qty\n";
    }
  }

  // Apply pricing rules
  if ($totalQty >= 12) {
    $total = 35;
  } elseif ($totalQty >= 6) {
    $total = 20;
  } elseif ($totalQty >= 3) {
    $total = 10;
  } else {
    $total = $totalQty * 4;
  }

  // Build final message for business
  $fullMessage = "New Order from $name\nEmail: $email\nPhone: $phone\n\nTreats:\n$orderDetails\nTotal: \$$total\n\nSpecial Requests:\n$special";

  // Send email to business
  mail($to, "New Jess So Sweet Order", $fullMessage);

  // Send text to business phone
  mail($textTo, "", $fullMessage);

  // Send confirmation email to customer
  $subject = "Jess So Sweet Treats — Order Confirmation";
  $customerMessage = "Hi $name,\n\nThank you for placing your order with Jess So Sweet Treats! Here's what we received:\n\n$orderDetails";
  $customerMessage .= "\nTotal: \$$total\n";
  $customerMessage .= "\nSpecial Requests:\n$special\n\nWe’ll be in touch soon to confirm pickup/delivery details.\n\n🍪 With love,\nJess So Sweet Treats";
  $headers = "From: Jess So Sweet Treats <jleonardmalone@gmail.com>";

  mail($email, $subject, $customerMessage, $headers);

  // Respond OK to JavaScript fetch
  http_response_code(200);
  echo "Order received.";
} else {
  http_response_code(403);
  echo "Forbidden.";
}
?>
