<?php

namespace TropicSkincare\Id;

use \GuzzleHttp\Client as HttpClient;

class Service
{
	/**
	 * @var string
	 */
	private static $clientId = '';


	/**
	 * @var string
	 */
	private static $callbackUrl = '';


	/**
	 * @var string
	 */
	private static $clientSecret = '';


	/**
	 * Set the OAuth client id
	 * 
	 * @param string $clientId The OAuth client Id
	 */
	public static function setClientId(string $clientId)
	{
		self::$clientId = $clientId;
	}


	/**
	 * Return the OAuth client id
	 *
	 * @return string
	 */
	public static function getClientId() : string
	{
		return self::$clientId;
	}


	/**
	 * Set OAuth callback URL
	 *
	 * @param string $url The callback URL
	 */
	public static function setCallbackUrl(string $url)
	{
		self::$callbackUrl = $url;
	}


	/**
	 * Return the callback URL
	 *
	 * @return string
	 */
	public static function getCallbackUrl() : string
	{
		return self::$callbackUrl;
	}


	/**
	 * Set the OAuth client secret
	 * 
	 * @param string $clientId The OAuth client secret
	 */
	public static function setClientSecret(string $secret)
	{
		self::$clientSecret = $secret;
	}


	/**
	 * Return the OAuth client secret
	 *
	 * @return string
	 */
	public static function getClientSecret() : string
	{
		return self::$clientSecret;
	}


	/**
	 * Return the URL for the ID service logout
	 *
	 * @return string
	 */
	public static function getLogoutUrl() : string
	{
		return \TropicSkincare\Api\Service::getServiceUrl('id') . '/logout';
	}
}