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
	public function findBySlug(string $slug, array $options = [])
	{
		return $this->get(self::ENDPOINT . '/slug/' . $slug, $options);
	}
}