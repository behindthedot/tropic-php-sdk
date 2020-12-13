<?php

namespace TropicSkincare\Api;

class Service
{	
	/**
	 * A list of service names that this client library will work with
	 *
	 * @var array
	 */
	const SERVICE_NAMES = [
		'id', 'pay', 'stem', 'websites'
	];


	/**
	 * The URLs for the various Tropic API services
	 *
	 * @var array
	 */
	private static $serviceUrls = [
		'id' => 'https://id.tropic.software',
		'pay' => 'https://api.pay.tropic.software',
		'stem' => 'https://api.stem.tropic.software',
		'websites' => 'https://api.websites.tropic.software'
	];


	/**
	 * Stored Auth bearer tokens for each service
	 *
	 * @var array
	 */
	private static $bearerTokens = [];


	/**
	 * Overide the default URLs for services
	 *
	 * @param array $services Associated array of ServiceName => URL
	 */
	public static function setServiceUrls(array $services)
	{
		foreach ( $services as $name => $url )
		{
			self::setServiceUrl($name, $url);
		}
	}


	/**
	 * Set the URL for a service
	 *
	 * @param string $serviceName The name of the web service
	 * @param string $url The URL
	 */
	public static function setServiceUrl(string $serviceName, $url)
	{
		if ( null === $url )
		{
			return;
		}

		self::verifyServiceName($serviceName);

		self::$serviceUrls[$serviceName] = $url;
	}


	/**
	 * Return the URL to a service
	 *
	 * @param string $serviceName
	 * @return string The URL to the service
	 * @throws \TropicSkincare\Api\Exception
	 */
	public static function getServiceUrl(string $serviceName) : string 
	{
		if ( isset(self::$serviceUrls[$serviceName]) )
		{
			return self::$serviceUrls[$serviceName];
		}
		else
		{
			throw new \Exception("Service URL for '$serviceName' not found");
		}
	}


	/**
	 * Set the bearer token for a service
	 * (By default we will be using the same token across all services
	 * but for development purposes we may need to override a particular
	 * service to use a local Auth)
	 *
	 * @param string $token The Bearer token
	 * @param string $serviceName The name of the service
	 */
	public static function setBearerToken(string $token, $serviceName = 'shared')
	{
		self::verifyServiceName($serviceName, 'shared');

		self::$bearerTokens[$serviceName] = $token;
	}


	/**
	 * Return the bearer token for a service
	 *
	 * @param string $serviceName
	 * @return string
	 * @throws \TropicSkincare\Api\Exception
	 */
	public static function getBearerToken($serviceName = null) : string
	{
		if ( isset(self::$bearerTokens[$serviceName]) )
		{
			/**
			 * If a specific service token is available
			 */
			return self::$bearerTokens[$serviceName];
		}
		elseif ( isset(self::$bearerTokens['shared']) )
		{
			/**
			 * If the shared bearer token is available
			 */
			return self::$bearerTokens['shared'];
		}
		else
		{
			/**
			 * No bearer token has been set
			 */
			throw new Exception("The bearer token has not been set", 400);
		}
	}


	/**
	 * Is a bearer token available?
	 *
	 * @return bool
	 */
	public static function hasBearerToken($serviceName = 'shared') : bool
	{
		if ( isset(self::$bearerTokens[$serviceName]) )
		{
			return true;
		}
		elseif ( isset(self::$bearerTokens['shared']) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 * Verify a service name is valid for this client library
	 *
	 * @param string $name The service name to validate
	 * @param string $alsoAllow Another name to allow
	 * @return bool
	 * @throws \TropicSkincare\Api\Exception
	 */
	public static function verifyServiceName($name, $alsoAllow = null) : bool 
	{
		if ( in_array($name, self::SERVICE_NAMES) || $name == $alsoAllow )
		{
			return true;
		}
		else
		{
			throw new Exception("Service '$name' is not valid for this client library", 400);
		}
	}
}