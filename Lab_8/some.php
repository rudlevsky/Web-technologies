<?php	
		
	function SendMail($mailTo, $from, $subject, $message, $file = false)
	{
		$separator = "---"; 
		
		// Заголовки письма
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "From: $from\nReply-To: $from\n"; 
		$headers .= "Content-Type: multipart/mixed; boundary=\"$separator\""; 

		// Тело письма
		$body = "--$separator\n"; 
		$body .= "Content-type: text/html; charset='utf-8'\n"; // Кодировка письма
		$body .= "Content-Transfer-Encoding: quoted-printable"; // Конвертация письма
		$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename($file))."?=\n\n"; 
		$body .= $message."\n"; 
		$body .= "--$separator\n";
		
		$fileRead = fopen($file, "r"); 
		$contentFile = fread($fileRead, filesize($file));
		fclose($fileRead);
		
		$body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode(basename($file))."?=\n"; 
		$body .= "Content-Transfer-Encoding: base64\n"; 
		$body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename($file))."?=\n\n";
		$body .= chunk_split(base64_encode($contentFile))."\n"; // Прикрепляем файл
		$body .= "--".$separator ."--\n";

		return mail($mailTo, $subject, $body, $headers); 
	}
				
	function generate()
	{
		$length = 8;
		$chars = 'abdefhiknrstyz1234567890';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++)
		{
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}
		
	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$mail = $_POST["mail"];
	
	if (($name == '') || ($surname == '') || ($mail == ''))
	{	
		exit('Заполните все поля');		
	}
	
	if (!(preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $mail)))
	{
		exit('Некорректный e-mail');		
	}
		       
	$connection = mysqli_connect('127.0.0.1', 'root', 'root', 'users');
	
	if ($connection == false)
	{
		echo mysqli_connect_error();
		echo('Ошибка подключения');
	}
	else
	{
		
		$result_sql = mysqli_query($connection,'SELECT * FROM `all_users`');		
	  
		for($i = 0; $i < mysqli_num_rows($result_sql); $i++)
		{
			$result = mysqli_fetch_row($result_sql);
			if($result[3] == $mail) 
			{
				mysqli_close($connection);
				exit('Данный аккаунт уже регистрировался');
			}
		}
		
		$code = generate();
			
		mysqli_query($connection,'INSERT INTO `all_users` (`Имя`,`Фамилия`,`e-mail`,`Код`) VALUES (\''.$name.'\',\''.$surname.'\',\''.$mail.'\',\''.$code.'\')');
		mysqli_free_result($result_sql);
		mysqli_close($connection);	
	
		$file = "./file.docx"; 
		$from = "luis_mop@mail.ru";
		$subject = "Подтверждение подписки"; 
		$message = '<p>Здравствуйте!</p>';
		$message .= '<p>Для подтверждения подписки перейдите по следующей <a href="http://parus.com/access.php?code='.$code.'">ссылке</a></p>';
		$result = SendMail($mail, $from, $subject, $message, $file); 
		echo ($result)?'Подтвердите подписку на своей почте':'Ошибка отправки';
	}
		
	