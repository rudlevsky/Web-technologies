<?php
	$str="это обычный текст для теста кода";
	$num=0;		
	$letter=0;
	$counter=0;	

	if (!is_string($str)) 
		exit("Некорректные данные");
	
	$str=explode(' ',$str);          

    for($i=0;$i<count($str);$i++){
				
		if ($counter == 2) {	
		//String in uppercase		  
			$str[$i]=mb_convert_case($str[$i],MB_CASE_UPPER);    
			$counter = -1;
		}
		//Explodes string on letters
		$alph=preg_split('/(?!^)(?=.)/u',$str[$i]);             
 
		for($j=0;$j<count($alph);$j++) {
						
			if (($alph[$j] == 'о') || ($alph[$j] == 'О') ||      
				($alph[$j] == 'o') || ($alph[$j] == 'O')) $num++;
			if ($letter == 2) {
				$alph[$j]='<span style="color:#9400d3;">'.$alph[$j].'</span>';
				$letter = -1;
			}
			$letter++;
		}
		$counter++;
				
        $str[$i]=implode('',$alph);     						
    }

	//String in word
    $str=implode(' ',$str);									    
    echo $str.'<br/>'.'"О" и "о" встречается '.$num.' раз.';
