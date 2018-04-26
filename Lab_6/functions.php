<?php
    function GetMainInfo($flag, $info = 0) 
    {
		if ($flag) 
		{
			$url = "http://www.cbr-xml-daily.ru/daily_json.js";
		}
		else 
		{
			$url = "http:" . $info->PreviousURL;
		}
		
        $data = file_get_contents($url);
        if ($data) 
        {
            return json_decode($data);
        }
        else return null;
    }
	
    function GetInfo($info)
    {
        return Get_Dollar($info) . Get_Euro($info) . Get_Rub($info);
    }
		
    function GetDayDate($flag) 
	{ 
		if ($flag) 
		{
			return time();
		}
		else	
		{
			return time() - (24 * 60 * 60); 
		}
	}
	
    function Get_Dollar($info) 
    {
        return "Доллар" . "<br/>". "Покупка: " . $info->Valute->USD->Value . " " . "Продажа: " . $info->Valute->USD->Previous . "<br/><br/>";
    }

    function Get_Euro($info)
    {
        return "Евро" . "<br/>". "Покупка: " . $info->Valute->EUR->Value . " " . "Продажа: " . $info->Valute->EUR->Previous . "<br/><br/>";
    }

    function Get_Rub($info)
    {
        return "Злотый" . "<br/>". "Покупка: " . $info->Valute->PLN->Value . " " . "Продажа: " . $info->Valute->PLN->Previous . "<br/><br/>";
    }