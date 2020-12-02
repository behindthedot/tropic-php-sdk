<?php

namespace TropicSkincare\Api;

class BaseObject
{
	/**
	 * Holds all the data for this resource
	 *
	 * @var array
	 */
	private $transient = [];


	/**
	 * Constructor
	 *
	 * @param object $data The properties for the object
	 */
	public function __construct(object $data)
	{
		$this->transient = $data;
	}


	/**
	 * Magic Setter
	 *
	 * @param string $name The property name
	 * @param mixed $value The value
	 */
	public function __set($name, $value)
	{
		$this->transient->$name = $value;
	}


	/**
	 * Magic Getter
	 *
	 * @param string $name The property name
	 */
	public function __get($name)
	{
		return $this->transient->$name;
	}


	/**
	 * Magic Isset
	 *
	 * @param string $name The property name
	 */
	public function __isset($name)
	{
		return isset($this->transient->$name);
	}
}