let cart = [];

function closePopup() {
  document.getElementById("popup").style.display = "none";
}

function addToCart(item) {
  cart.push(item);
  updateCartDisplay();
}

function updateCartDisplay() {
  const cartList = document.getElementById("cart");
  if (!cartList) return;
  cartList.innerHTML = "";
  cart.forEach(item => {
    const li = document.createElement("li");
    li.textContent = item;
    cartList.appendChild(li);
  });
}

function checkout() {
  if (cart.length === 0) {
    alert("Cart is empty!");
    return;
  }
  document.getElementById("checkout-form").style.display = "block";
  document.getElementById("cartSummaryInput").value = cart.join(", ");
}
