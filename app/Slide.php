<?php

/**
 * Presentation2.0
 *
 * @link      https://github.com/deepsadhi/presentation2.0
 * @license   https://github.com/deepsadhi/presentation2.0/blob/master/LICENSE
 *            (GPLv3)
 */

namespace App;

use App\File;
use Parsedown;


/**
 * A Slide class
 *
 * Parses Markdown contents to HTML
 *
 * @package Presentation2.0
 */
class Slide
{
	/**
	 * Store Parsedown parser object
	 *
	 * @var object
	 */
	protected $parser;

	/**
	 * Contents of presentation file
	 *
	 * @var string
	 */
	protected $contents;

	/**
	 * Number of blocks ie number slide in the presentation
	 *
	 * @var int
	 */
	protected $slideCount;

	/**
	 * There is previous slide or not
	 *
	 * @var boolean
	 */
	public $prev;

	/**
	 * There is next slide or not
	 *
	 * @var boolean
	 */
	public $next;

	/**
	 * Slide number of the slide
	 *
	 * @var int
	 */
	public $slideNumber;


	/**
	 * Initialize slide
	 *
	 * @param string $filePath Path of presentation file
	 */
	public function __construct($filePath)
	{
		$file = new File($filePath);
		if ($file->load() === false)
		{
			echo 'Error! loading file .' .$filePath;
		}

		$this->contents    = $file->getContents();
		$this->contents    = explode(PHP_EOL.PHP_EOL.PHP_EOL, $this->contents);
		$this->slideCount  = count($this->contents);
		$this->slideNumber = 0;

		$this->prev        = false;
		$this->next        = false;

		$this->parser = new Parsedown;
	}

	/**
	 * Convert Markdown content to HTML
	 *
	 * @param  string $markdown Markdown content
	 * @return string           HTML content
	 */
	protected function parseHTML($markdown)
	{
		$slide = $this->parser->text($markdown);
		$slide = str_replace("'", "\'", $slide);
		$slide = str_replace(PHP_EOL, '', $slide);
		$slide = str_replace('<a href=', '<a target="_blank" href=', $slide);
		$slide = str_replace('<img src=',
		                     '<img class="img-responsive" src=',
						     $slide);

		return $slide;
	}


	/**
	 * Render Slide content for Web Socket clients
	 *
	 * @param  string $action Action
	 * @return string         Slide content
	 */
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
			if (($this->slideNumber + 1) <= ($this->slideCount - 1))
			{
				$this->slideNumber++;
			}
		}

		if ($this->slideNumber <= 0)
		{
			$this->prev = true;
		}

		if ($this->slideNumber >= ($this->slideCount - 1))
		{
			$this->next = true;
		}

		$slide = $this->parseHTML($this->contents[$this->slideNumber]);

		return $slide;
	}

	/**
	 * Render Slide contents for presenter for Ajax
	 *
	 * @param  int    $slideNumber Slide number
	 * @return array               Slide contents and controls
	 */
	public function renderForAjax($slideNumber)
	{
		$this->prev = false;
		$this->next = false;

		if ($slideNumber <= 0 )
		{
			$slideNumber = 0;
			$this->prev = true;
		}
		else if ($slideNumber >= ($this->slideCount - 1))
		{
			$slideNumber = $this->slideCount - 1;
			$this->next = true;
		}

		$slide = $this->parseHTML($this->contents[$slideNumber]);

		$msg = ['prev'  => $this->prev,
				'next'  => $this->next,
		        'slide' => $slide,
		        'count' => ($this->slideCount - 1)];

		return $msg;
	}

}
