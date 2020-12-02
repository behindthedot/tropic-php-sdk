<?php

namespace TropicSkincare\Api;

class Exception extends \Exception
{
	/**
	 * @var array
	 */
	public $errors = [];


	/**
	 * Constructor
	 */
	public function __construct(string $message, $code, $errors = [])
	{
		$this->errors = $errors;
		parent::__construct($message, $code);
	}	


	/**
	 * Return the list of errors with the submission
	 *
	 * @return array
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}