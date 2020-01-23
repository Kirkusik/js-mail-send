let form = document.querySelector('form')
form.addEventListener('submit', submitHandler)
function submitHandler(){
  fetch("mail.php", {
    method: "POST",
    body: new FormData(form);
  })
  .then(response => response.json())
  .then(function(json) { /* process your JSON further */ })
  .catch(function(error) { console.log(error); });
});
