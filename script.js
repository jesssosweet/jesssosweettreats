// Price calculation based on quantity
function calculatePrice(qty) {
  qty = parseInt(qty);
  switch (qty) {
    case 1: return 4;
    case 3: return 10;
    case 6: return 20;
    case 12: return 35;
    default: return 0;
  }
}

// Update total when user changes selection
function updateTotal() {
  const selects = document.querySelectorAll('select');
  let total = 0;

  selects.forEach(select => {
    total += calculatePrice(select.value);
  });

  document.getElementById('total').innerText = total;
}

// Attach change listeners to all selects
document.querySelectorAll('select').forEach(select => {
  select.addEventListener('change', updateTotal);
});

// Handle form submission
document.getElementById('orderForm').addEventListener('submit', function (e) {
  e.preventDefault(); // Stop default page reload

  const form = e.target;
  const formData = new FormData(form);

  // Show loading message
  const statusMsg = document.getElementById('statusMsg');
  statusMsg.innerText = "Submitting your order...";

  fetch('order.php', {
    method: 'POST',
    body: formData
  })
    .then(response => {
      if (!response.ok) throw new Error('Network error');
      return response.text();
    })
    .then(result => {
      // Show confirmation message
      statusMsg.style.color = "green";
      statusMsg.innerText = "Thank you! Your order has been placed.";
      form.reset();
      updateTotal();
      alert("Thank you! Your order was submitted successfully.");
    })
    .catch(error => {
      statusMsg.style.color = "red";
      statusMsg.innerText = "There was a problem placing your order. Please try again.";
    });
});

// Initialize total on page load
updateTotal();
