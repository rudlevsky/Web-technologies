<?php
		$str="Корабль Джеймса Кука, на котором знаменитый 
			мореплаватель совершил свое tut@gmail.com первое кругосветное путешествие mail@mail.ru";
						
		if (!is_string($str))				  
			exit("Uncorrect data");
						
		//Explode string in words
		$str=explode(' ',$str);               						 				
		for($i=0;$i<count($str);$i++){
		if (preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-.]+$/", $str[$i]))
			$str[$i] = "<a style='color: red'; href=mailto:".$str[$i].">".$str[$i]."</a>";
		}
						
		//Implode words in string
		$str=implode(' ',$str);									    
		echo $str;	
