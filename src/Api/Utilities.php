<?php

namespace TropicSkincare\Api;

class Utilities
{
	/**
	 * Remove the namespace path from a class name
	 *
	 * @param string $className The full name of the class
	 * @return string Just the class name
	 */
	public static function stripNamespace($className) : string
	{
		$parts = explode('\\', $className);

		return array_pop($parts);
	}

	/**
	 * Return just the namespace portion of the class name
	 *
	 * @param string $name The class name
	 * @return string
	 */
	public static function getNamespace($className) : string 
	{
		$parts = explode('\\', $className);

		array_pop($parts);

		return join('\\', $parts);
	}


	/**
	 * Return the service name
	 * (this is always the last section of the namespace)
	 *
	 * @param string $name The class name
	 * @return string
	 */
	public static function getServiceName($className) 
	{
		$parts = explode('\\', $className);

		return isset($parts[1]) ? strtolower($parts[1]) : null;
	}
}