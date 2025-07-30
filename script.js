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
      } else {
        alert("There was a problem. Please try again.");
      }
    })
    .catch((err) => alert("Error: " + err));
});
