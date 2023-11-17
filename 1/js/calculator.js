function calculateTotalPrice() {
  var productCards = document.getElementsByClassName('product-card');
  var totalPrice = 0;

  for (var i = 0; i < productCards.length; i++) {
    var priceElement = productCards[i].getElementsByClassName('product-price')[0];
    var quantityElement = productCards[i].getElementsByClassName('product-quantity')[0];
    var price = parseFloat(priceElement.innerText);
    var quantity = parseInt(quantityElement.value);

    if (!isNaN(price) && !isNaN(quantity)) {
      totalPrice += price * quantity;
    }
  }

  document.getElementById('total-price').innerText = totalPrice.toFixed(2);
}
function decreaseQuantity(button) {
var quantityInput = button.previousElementSibling;
var currentQuantity = parseInt(quantityInput.value);

if (currentQuantity > 0) {
quantityInput.value = currentQuantity - 1;
calculateTotalPrice();
}
}

function increaseQuantity(button) {
var quantityInput = button.previousElementSibling.previousElementSibling;
var currentQuantity = parseInt(quantityInput.value);

quantityInput.value = currentQuantity + 1;
calculateTotalPrice();
}