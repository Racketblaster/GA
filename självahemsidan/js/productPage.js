//Laddar in informationen i produkthemsidan
var productId = (new URLSearchParams(window.location.search)).get('productId');
loadProduct(productId);