//Gör att man kan trycka på enter i sökfältet
document.querySelector('#search').addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    searchProd();
  }
});
