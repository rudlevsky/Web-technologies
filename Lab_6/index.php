<?php
	include 'functions.php';
	include 'Pattern.php';
	
	$flag = true;
	$info = GetMainInfo($flag);
	if ($info == NULL) exit('Connection error.');
	
	$day1 = new Pattern('Day');
	$day1->assign(array('date'=>date("d.m.y", GetDayDate($flag)). "<br/>", 'info'=>GetInfo($info)));

	
	$flag = false;	
	$info2 = GetMainInfo($flag,$info);
	if ($info2 == NULL) exit('Connection error.');
	
	$day2 = new Pattern('Day');
	$day2->assign(array('date'=>date("d.m.y", GetDayDate($flag)). "<br/>", 'info'=>GetInfo($info2)));
		
				
	$block = new Pattern('Block');
	$block->assign(array('day1'=>($day1->get_patt()), 'day2'=>($day2->get_patt())));

	$result = new Pattern('main');
	$result->assign(array('Block'=>($block->get_patt())));
	echo $result->get_patt();	
	