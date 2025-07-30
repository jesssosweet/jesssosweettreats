<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $to = "jleonardmalone@gmail.com, 6293087729@vtext.com";
  $subject = "New Order - Jess So Sweet Treats";
  $body = "Name: " . $_POST["name"] . "\n" .
          "Email: " . $_POST["email"] . "\n" .
          "Phone: " . $_POST["phone"] . "\n" .
          "Address: " . $_POST["address"] . "\n" .
          "Payment Method: " . $_POST["payment"] . "\n" .
          "Order Summary: " . $_POST["cartSummary"];

  $headers = "From: website@jesssosweettreats.com";

  mail($to, $subject, $body, $headers);

  echo "<script>alert('Order submitted! Jess will be in touch shortly.'); window.location.href='index.html';</script>";
}
?>
