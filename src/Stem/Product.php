<?php

namespace TropicSkincare\Stem;


class Product extends \TropicSkincare\Api\Resource
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
	const ENDPOINT = '/products';


	/**
	 * Retrieve a product using it's source
	 * This is a composite key in the format:
	 * <source>-<id>  (shopify-239823, for example)
	 *
	 * @param string $source The source
	 * @return Product
	 */
	public static function findBySource(string $source, array $options = [])
	{
		return self::get(self::ENDPOINT . '/source/' . $source, $options);
	}
}