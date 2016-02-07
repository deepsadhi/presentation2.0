<?php

namespace App;

use Parsedown;

class Slide
{
	private $_content;
	private $_slideCount;
	private $_contents;
	private $_parser;

	public $prev;
	public $next;
	public $slideNumber;

	public function __construct($filePath)
	{
		// TOTO: check file exists
		$this->_contents   = file_get_contents($filePath);
		$this->_contents   = explode(PHP_EOL.PHP_EOL.PHP_EOL, $this->_contents);
		$this->_slideCount = count($this->_contents);
		$this->slideNumber = 0;

		$this->prev        = false;
		$this->next        = false;

		$this->_parser = new Parsedown;
	}


	public function render($action = 'start')
	{
		$this->prev = false;
		$this->next = false;

		if ($action == 'start')
		{
			$this->prev        = true;
			$this->next        = false;
			$this->slideNumber = 0;
		}
		else if ($action == 'prev')
		{
			if (($this->slideNumber - 1) >= 0 )
			{
				$this->slideNumber--;
			}
		}
		else if ($action == 'next')
		{
			if (($this->slideNumber + 1) <= ($this->_slideCount - 1))
			{
				$this->slideNumber++;
			}
		}

		if ($this->slideNumber <= 0)
		{
			$this->prev = true;
		}

		if ($this->slideNumber >= ($this->_slideCount - 1))
		{
			$this->next = true;
		}

		$slide = $this->_parser->text($this->_contents[$this->slideNumber]);
		$slide = str_replace("'",     "\'", $slide);
		$slide = str_replace(PHP_EOL, "",   $slide);
		$slide = str_replace('<a href=', '<a target="_blank" href=', $slide);

		return $slide;
	}

	public function renderForAjax($slideNumber)
	{
		$this->prev = false;
		$this->next = false;

		if ($slideNumber <= 0 )
		{
			$slideNumber = 0;
			$this->prev = true;
		}
		else if ($slideNumber >= ($this->_slideCount - 1))
		{
			$slideNumber = $this->_slideCount - 1;
			$this->next = true;
		}

		$slide = $this->_parser->text($this->_contents[$slideNumber]);
		$slide = str_replace("'",     "\'", $slide);
		$slide = str_replace(PHP_EOL, "",   $slide);
		$slide = str_replace('<a href=', '<a target="_blank" href=', $slide);

		$msg = array('prev' => $this->prev, 'next' => $this->next,
		             'slide' => $slide, 'count' => ($this->_slideCount - 1));
		$msg = json_encode($msg);

		return $msg;
	}

}