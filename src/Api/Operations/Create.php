<?php

namespace TropicSkincare\Api\Operations;

trait Create
{
	/**
	 * Create an object
	 *
	 * @param array $values The data to use in the creation
	 */
	public static function create(array $values)
	{
		$resourceName = get_called_class();

		return self::post($resourceName::ENDPOINT, $values);
	}
}