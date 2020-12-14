<?php

namespace TropicSkincare\Stem;


class Party extends \TropicSkincare\Api\Resource
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
	const ENDPOINT = '/parties';


	/**
	 * Retrieve a party using it's 'slug'
	 *
	 * @param string $slug The URL slug
	 * @return Party
	 */
	public static function findBySlug(string $slug, array $options = [])
	{
		return self::get(self::ENDPOINT . '/slug/' . $slug, $options);
	}


	/**
	 * Reset the password for the host portal
	 */
	public function resetHostPortalPassword(array $options = [])
	{
		return self::post(self::ENDPOINT . '/' . $this->id . '/reset-password', $options);
	}
}