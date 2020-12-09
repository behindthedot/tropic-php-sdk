<?php

namespace TropicSkincare\Stem;


class PartyGuest extends \TropicSkincare\Api\Resource
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
	const ENDPOINT = '/partyguests';


	/**
	 * Get the guest's full name
	 *
	 * @return string
	 */
	public function fullName()
	{
		return trim($this->firstname . ' ' . $this->lastname);
	}
}