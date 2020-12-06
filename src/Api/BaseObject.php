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
	public function __construct($data)
	{
		/*
		foreach ( $data as $name => $element )
		{
			if ( ! is_object($element) )
			{
				continue;
			}

			echo "Sending the following to buildObjectFromResponse:<br/>";

			echo '<pre style="color: red">';
			print_r($element);
			echo '</pre>';

			$out = Resource::buildObjectFromResponse($element);

			echo "Received the following back from buildObjectFromResponse:<br/>";

			echo '<pre style="color: green">';
			print_r($out);
			echo '</pre>';

			$data->{$name} = Resource::buildObjectFromResponse($element);
		}*/

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
		$this->transient[$name] = $value;
	}


	/**
	 * Magic Getter
	 *
	 * @param string $name The property name
	 */
	public function __get($name)
	{
		return $this->transient[$name];
	}


	/**
	 * Magic Isset
	 *
	 * @param string $name The property name
	 */
	public function __isset($name)
	{
		return isset($this->transient[$name]);
	}
}