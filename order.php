<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $to = "jleonardmalone@gmail.com";
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $name = $_POST['name'];
  $special = $_POST['special_requests'];

  $items = [
    'Banana Pudding' => $_POST['banana_pudding'],
    'Red Velvet' => $_POST['red_velvet'],
    'Salted Caramel' => $_POST['salted_caramel'],
    'S’mores' => $_POST['smores'],
    'Cookie Butter' => $_POST['cookie_butter'],
    'Cookie Monster' => $_POST['cookie_monster'],
    'Strawberry Crunch' => $_POST['strawberry_crunch']
  ];

  $message = "New Order from $name\nEmail: $email\nPhone: $phone\n\nTreats:\n";

  foreach ($items as $treat => $qty) {
    if ($qty > 0) {
      $message .= "$treat: $qty\n";
    }
  }

  $message .= "\nSpecial Requests:\n$special";

  // Send Email
  mail($to, "New Jess So Sweet Order", $message);

  // Send Text (via Email-to-SMS gateway)
  $textTo = "16293087729@vtext.com"; // Adjust for carrier if needed
  mail($textTo, "", $message);

  http_response_code(200);
  echo "Order received.";
} else {
  http_response_code(403);
  echo "Forbidden.";
}
?>
