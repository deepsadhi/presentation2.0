<?php

namespace App;

use Session;

class Form2
{
	private $_session;
	private $_inputField = array();

	public $error      = false;
	public $inputName  = array();
	public $inputError = array();
	public $inputValue = array();
	public $errorMessage;
	public $csrfToken;


	/**
	 * Initialize form fields
	 *
	 * @param string $type Type of form
	 */
	public function __construct($type)
	{
		$this->_session   = new Session;
		$this->tokenName  = $this->getTokenName;
		$this->tokenValue = $this->_session->getCsrfToken();

		switch ($type)
		{
			case 'login':
			{
				$this->_inputField['username'] = array(
				                               'filter' => 'alnum,min:3,max:10)'
				                               );
				$this->_inputField['password'] = array(
				                               'filter' => 'raw,min:6,max:20'
				                               );

				break;
 			}

			default:
			{
			}
		}
	}

	/**
	 * Check Cross Site Request Forgery
	 *
	 * @return bool Request is valid or not
	 */
	private isCsrf()
	{
		if (isset($_POST[$this->tokenName]) &&
		    $_POST[$this->csrfToken] == $_session->getCsrfToken()
		   )
		{
			$this->error        = true;
			$this->errorMessage = 'Invalid! request';

			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Validate and filter form fields
	 */
	public function validate()
	{
		if ($this->
		foreach ($this->_inputField as $input => $filter)
		{
			$value                    = isset($_POST[$input]) ?
											$_POST[$input] ? null;
			$filter                   = Filter::factory($filter['filter']);

			if ($filter->validate($value) == false)
			{
				$this->error              = true;
				$this->inputError[$input] = true;
			}

			$this->inputValue = Filter::factory($filter)->filter($value);
		}
	}


}
