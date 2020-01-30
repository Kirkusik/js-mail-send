 <?php

  // Если поле выбора вложения не пустое - закачиваем его на сервер 

 if (!empty($_FILES['user_file']['tmp_name'])) 

 { 

    // Закачиваем файл 

 	$path = $_FILES['user_file']['name']; 

 	if (copy($_FILES['user_file']['tmp_name'], $path)) $picture = $path; 

 }

 $project_name = 'Skytech-polymer';
 // $admin_email = 'viktorkan9@gmail.com';
 // $admin_email = 'inweb@ua.fm';
 $admin_email = trim($_POST['mailto']);

 $form_type = trim($_POST['formType']);

 switch ($form_type) {
 	case 'modalOrderForm':
 	$formTitle = 'Заявка';
 	break;

 	case 'promoFeedbackForm':
 	$formTitle = 'Запрос на связь с менеджером';
 	break;

 	case 'simpleForm':
 	$formTitle = 'Запрос на сотрудничество';
 	break;

 	case 'subscribesForm':
 	$formTitle = 'Запрос на подписку';
 	break;

 	case 'contactForm':
 	$formTitle = 'Задали вопрос';
 	break;

 	case 'promoOrderForm':
 	$formTitle = 'Сборный заказ';
 	break;

 	default:
 	$formTitle = 'Письмо';
 	break;
 }

 $form_subject = $formTitle." с сайта skytech-polymer";

 if (isset($_POST['formType'])) {

 	foreach ( $_POST as $key => $value ) {

 		if ($key == 'formType' || $key == 'mailto') {
 			continue;
 		}

 		if ($key == 'user_name') {
 			$fieldName = "Имя";
 		}
 		if ($key == 'user_tel') {
 			$fieldName = "Телефон";
 		}
 		if ($key == 'user_text') {
 			$fieldName = "Текст сообщения";
 		}
 		if ($key == 'user_email') {
 			$fieldName = "Email";
 		}


 		$message .= "
 		" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
 		<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>".$fieldName."</b></td>
 		<td style='padding: 10px; border: #e9e9e9 1px solid;'>".$value."</td>
 		</tr>
 		";

 	}


 }
 $message = "<table style='width: 100%;'>".$message."</table>";

 $thm = $form_subject;

 $msg = $message;

 $mail_to = $admin_email;

  // Отправляем почтовое сообщение 

 $headers = "Content-Type: text/html; charset=UTF-8 \r\n"; 

 $headers .= "From: Skytech-polymer <form>\r\n";


 if(empty($picture)){ 

 	mail($mail_to, $thm, $msg, $headers);
 	$form_type->formId = $form_type;
 	$form_type = json_encode($form_type);
 	echo $form_type;
 }

 else {
 	
 	send_mail($mail_to, $thm, $msg, $picture);
 	$form_type->formId = $form_type;
 	$form_type = json_encode($form_type);
 	echo $form_type;
 }
  // Вспомогательная функция для отправки почтового сообщения с вложением 

 function send_mail($to, $thm, $html, $path) 

 { 

 	$fp = fopen($path,"r"); 

 	if (!$fp) 

 	{ 

 		print "Файл $path не может быть прочитан"; 

 		exit(); 

 	} 

 	$file = fread($fp, filesize($path)); 

 	fclose($fp); 



    $boundary = "--".md5(uniqid(time())); // генерируем разделитель 

    $headers .= "MIME-Version: 1.0\n"; 

    $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"\n"; 

    $headers .= "From: Skytech-polymer <form>\r\n";

    $multipart .= "--$boundary\n"; 

    $kod = 'UTF-8'; // или $kod = 'windows-1251'; 

    $multipart .= "Content-Type: text/html; charset=$kod\n"; 

    $multipart .= "Content-Transfer-Encoding: Quot-Printed\n\n"; 

    $multipart .= "$html\n\n"; 



    $message_part = "--$boundary\n"; 

    $message_part .= "Content-Type: application/octet-stream\n"; 

    $message_part .= "Content-Transfer-Encoding: base64\n"; 

    $message_part .= "Content-Disposition: attachment; filename = \"".$path."\"\n\n"; 

    $message_part .= chunk_split(base64_encode($file))."\n"; 

    $multipart .= $message_part."--$boundary--\n"; 



    if(!mail($to, $thm, $multipart, $headers)) 

    { 

    	echo "К сожалению, письмо не отправлено"; 

    	exit(); 

    } 

} 
