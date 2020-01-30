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
