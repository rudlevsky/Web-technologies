<?php

function main_proc($comand)
{
	$row = array();
	$mysqli = new mysqli('127.0.0.1', 'root', 'root', 'test');

	if ($mysqli->connect_error)
	{
		die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}
	else
	{
		$comand = explode(' - ',$comand);
		
		$mysqli->query('SET names "utf8"');
		$mtime = microtime();
		$mtime = explode(" ", $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$tstart = $mtime; 
		
		//cycle of all commands
		for($i=0;$i<count($comand);$i++) 
		{
			if ($comand[$i] != '')
			{
				echo $comand[$i] . "<br><br>";
				
				//request to the database
				$resultMySQL = $mysqli->query($comand[$i]);
				if (!$resultMySQL)
				{
					echo "Command is not correct";
				}
				else
				{
					$resultMySQL = $mysqli->query($comand[$i]);
					$pos = strpos('1' . $comand[$i], 'SELECT');
					if ($pos != 0)
					{
						while ($row = $resultMySQL->fetch_array(MYSQLI_ASSOC)) 
							if (isset($row)) {
								print_r($row); 
								echo "</br>";
							}
							else 
								echo "no result found";
						echo "<br>";
					}
					echo "Command was implemented<br><br><br>";
				}
			}
		}
		//calculation of time
		$mtime = microtime();
		$mtime = explode(" ", $mtime);
		$mtime = $mtime[1] + $mtime[0];
		$tpassed = $mtime - $tstart;
		echo 'Памяти использовано: ', round(memory_get_usage()/1024/1024,4), ' MB<br>';
		echo "Время выполнения " . round($tpassed,6) . "<br>";
	}
	$mysqli->close();
}

if (isset($_POST["start"]))
{
    $comand = ($_POST["start"]);
    main_proc($comand);
}
