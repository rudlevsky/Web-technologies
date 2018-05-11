<?php

	$code = $_GET["code"];
	
	if ($code == '')
	{	
		exit('Некорректная ссылка');		
	}
	
	$connection = mysqli_connect('127.0.0.1', 'root', 'root', 'users');
	
	if ($connection == false)
	{
		echo mysqli_connect_error();
		exit('Ошибка подключения');
	}
	else
	{		
		$result_sql = mysqli_query($connection,"SELECT * FROM `all_users`");		
	  
		$flag = false;
		for($i = 0; $i < mysqli_num_rows($result_sql); $i++)
		{
			$result = mysqli_fetch_row($result_sql);
			if($result[4] == $code) 
			{			
				$flag = true;
				break;
			}
		}
		  
		if ($flag) 
		{
			mysqli_query($connection,"UPDATE `all_users` SET `Статус`=1 WHERE `Код`='{$code}'");
			echo file_get_contents("access.html");
		}
		else 
		{
			echo file_get_contents("access_denied.html");
		}	
		
		mysqli_free_result($result_sql);
		mysqli_close($connection);
	}

