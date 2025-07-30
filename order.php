$totalQty = 0;
$orderDetails = "";
foreach ($items as $treat => $qty) {
  if ($qty > 0) {
    $totalQty += $qty;
    $orderDetails .= "$treat: $qty\n";
  }
}

// Apply bundle discount based on totalQty
if ($totalQty >= 12) {
  $total = 35;
} elseif ($totalQty >= 6) {
  $total = 20;
} elseif ($totalQty >= 3) {
  $total = 10;
} else {
  $total = $totalQty * 4;
}
