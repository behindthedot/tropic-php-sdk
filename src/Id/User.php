<?php

namespace TropicSkincare\Id;

class User extends \TropicSkincare\Api\Resource
{
	/**
	 * List operations that can be performed on this resource
	 */


	/**
	 * The URL to the endpoint for this resource
	 *
	 * @var const
	 */
	const ENDPOINT = '/api/user';


	/**
	 * @var object|null
	 */
	private static $cache = null;


	/**
	 * Return the authenticated user
	 *
	 * @return \TropicSkincare\Id\User
	 */
	public static function getAuthenticated()
	{
		if ( null !== self::$cache )
		{
			return self::$cache;
		}

		return self::$cache = self::all();
	}
}