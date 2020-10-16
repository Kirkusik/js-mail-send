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


var http = new XMLHttpRequest();
var url = 'get_data.php';
var params = 'orem=ipsum&name=binny';
http.open('POST', url, true);

//Send the proper header information along with the request
http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
        alert(http.responseText);
    }
}
http.send(params);
//jquery
formSubmit('#subscribesForm');
	
	function formSubmit(selector){
		$(selector).on('submit', function(evt){
			evt.preventDefault();
			submitHandler(this.id);
		});
	};

	function submitHandler(formId){
		$.ajax({
			url:"/send-mail.php", //url страницы (action_ajax_form.php)
			type:"POST", //метод отправки
			data: $('#'+formId).serialize(),  // Сеарилизуем объект
			success: function(response) { //Данные отправлены успешно
				document.getElementById(formId).reset();
				console.log('response: '+response);
			},
			error: function(response) { // Данные не отправлены

			}
		});
	};
