<?php

namespace App;

use App\Session;
use \Exception;
use Filterus\Filter;

class Form
{
	private $_inputField     = array();

	public $tokenName;
	public $tokenValue;

	public $error            = false;
	public $inputName        = array();
	public $inputError       = array();
	public $inputValue       = array();
	public $inputFilterValue = array();


	/**
	 * Initialize form fields
	 *
	 * @param string $type Type of form
	 */
	public function __construct($type)
	{
		$this->tokenName  = '_token';
		$this->tokenValue = Session::getCsrfToken();

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
	private function _isCsrf()
	{
		if (isset($_POST[$this->tokenName]) &&
		    $_POST[$this->tokenName] == $this->tokenValue
		   )
		{
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
		try
		{
			if ($this->_isCsrf() === true)
			{
				$this->error = true;
				throw new Exception('Invalid! request');
			}


			foreach ($this->_inputField as $input => $filter)
			{
				$value  = isset($_POST[$input]) ? $_POST[$input] : null;
				$filter = Filter::factory($filter['filter']);

				if ($filter->validate($value) == false)
				{
					$this->error              = true;
					$this->inputError[$input] = true;
				}

				$this->inputValue[$name]       = $value;
				$this->inputFilterValue[$name] = Filter::factory($filter)
													->filter($value);
			}

			if ($this->error === true)
			{
				throw new Exception('Please fill up form correctly');
			}
			else
			{
				return true;
			}
		}
		catch (Exception $e)
		{
			die($e->getMessage());
			Session::setMessage('danger', $e->getMessage());
			return false;
		}
	}


}
