<?php

namespace TropicSkincare\Websites;


class Website extends \TropicSkincare\Api\Resource
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
	const ENDPOINT = '/websites';


	/**
	 * Retrieve a website using it's 'slug'
	 *
	 * @param string $slug The URL slug
	 * @return Website
	 */
	public static function findBySlug(string $slug, array $options = [])
	{
		return self::get(self::ENDPOINT . '/slug/' . $slug, $options);
	}
}