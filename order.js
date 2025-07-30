document.getElementById('orderForm').addEventListener('submit', function (e) {
  e.preventDefault();

  // Simulate form submission
  document.getElementById('popup').classList.remove('hidden');

  // You can add email/text functionality in PHP or through an external form handler like Formspree.
});

function closePopup() {
  document.getElementById('popup').classList.add('hidden');
  document.getElementById('orderForm').reset();
}
