<?php

namespace TropicSkincare\Stem;


class Customer extends \TropicSkincare\Api\Resource
{
	/**
	 * List operations that can be performed on this resource
	 */
	use \TropicSkincare\Api\Operations\Create;
	use \TropicSkincare\Api\Operations\Update;
	use \TropicSkincare\Api\Operations\Delete;


	/**
	 * The URL to the endpoint for this resource
	 *
	 * @var const
	 */
	const ENDPOINT = '/customers';


	/**
	 * Get the customer's full name
	 *
	 * @return string
	 */
	public function fullName()
	{
		return trim($this->firstname . ' ' . $this->lastname);
	}
}