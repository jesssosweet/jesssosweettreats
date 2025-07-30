function updateTotal() {
  const selects = document.querySelectorAll("form select");
  let totalQty = 0;

  selects.forEach(select => {
    totalQty += parseInt(select.value) || 0;
  });

  let total = 0;

  if (totalQty >= 12) {
    total = 35;
  } else if (totalQty >= 6) {
    total = 20;
  } else if (totalQty >= 3) {
    total = 10;
  } else {
    total = totalQty * 4;
  }

  document.getElementById("totalAmount").textContent = total.toFixed(2);
}

document.querySelectorAll("form select").forEach(select => {
  select.addEventListener("change", updateTotal);
});

document.getElementById("orderForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;
  const data = new FormData(form);

  fetch("order.php", {
    method: "POST",
    body: data,
  })
    .then((res) => {
      if (res.ok) {
        document.getElementById("confirmationPopup").classList.remove("hidden");
        form.reset();
        updateTotal();
      } else {
        alert("There was a problem. Please try again.");
      }
    })
    .catch((err) => alert("Error: " + err));
});
