<?php
class Pattern
{
	private $now_pattern = NULL;
	private $var_pattern = NULL;

	function __construct($html_name)
	{
		if (!file_exists($html_name . '.html')) return;
		$this->now_pattern= file_get_contents($html_name . '.html');
	}

	function assign($vars)
	{
		$this->var_pattern = $this->now_pattern;
		foreach ($vars as $blockname => $value) 
		{
			$this->var_pattern = preg_replace('/{' . $blockname . '}/', $value, $this->var_pattern);
		}
	}

	function get_patt()
	{
		return $this->var_pattern;
	}
}