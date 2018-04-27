<?php	
	function get_forms($msg='', $name='', $value='', $time='')
	{	
		$temp = '<!DOCTYPE html><html><head><link rel="stylesheet" href="styles.css"/>
		<title>Куки</title></head><body>';
		$temp .= '<div class="block"><p class="msg">'.$msg.'</p>';
		$temp .= '<form action="' . $_SERVER['PHP_SELF'] . '" method="get">';
		$temp .= '<input type="text" placeholder="name" name="name" value="'.$name.'" /><br/>';
		$temp .= '<input type="text" placeholder="value" name="value" value="'.$value.'" /><br/>';
		$temp .= '<input type="number" placeholder="time" min=1 name="time" value="'.$time.'" /><br/><br/>';
		$temp .= '<input type="submit" value="Установить" /><br/>';
		
		foreach ($_COOKIE as $key => $val) 
		{
			if($key != 'PHPSESSID')
				$temp .= "<b>$key : $val </b><br>";	
    	}
		$temp .= '</form></div></body></html>';

		return $temp;
	}

	
	if (!isset($_GET['name']))
	{
		echo get_forms();
	}
	else
	{
		if(($_GET['name'] == '') || ($_GET['value'] == '') || ($_GET['time'] == '')) 
		{
			exit('Некорректные данные');
		}
		
		$name = $_GET['name'];
		$value = $_GET['value'];
		$time = time() + $_GET['time'];
		setcookie($name, $value, $time);
		echo get_forms('Установлен куки ' . $name);
	}
	