<?php

namespace TropicSkincare\Id;

use \TropicSkincare\Api\Service as ApiService;
use \GuzzleHttp\Client as HttpClient;

class Authenticator
{
	/**
	 * Return the URL to the Auth service
	 *
	 * @param string $verificationToken The token used to validate the request
	 * @param string $scope The list of scopes to request auth to
	 * @return string $url The URL to the auth service
	 */
	public static function getAuthUrl(string $verificationToken, string $scope = '*') : string
	{
		/**
		 * Build the HTTP request
		 */
		$query = http_build_query([
	        'client_id' => Service::getClientId(),
	        'redirect_uri' => Service::getCallbackUrl(),
	        'response_type' => 'code',
	        'scope' => $scope,
	        'state' => $verificationToken
    	]);

		return ApiService::getServiceUrl('id') . '/oauth/authorize?' . $query;
	}


	/**
	 * Convert a code provided by the auth service into a bearer token
	 *
	 * @param string $code The code provided by the auth service
	 * @param string $verificationToken The token used to verify this request
	 * @return array The response from the conversion
	 */
	public static function convertAccessCodeToBearerToken(string $code, string $verificationToken)
	{
		$httpClient = new HttpClient;

		/**
		 * Request the bearer token from the auth service
		 */
		$response = $httpClient->post(ApiService::getServiceUrl('id') . '/oauth/token', [
			'form_params' => [
	            'grant_type' => 'authorization_code',
	            'client_id' => Service::getClientId(),
	            'client_secret' => Service::getClientSecret(),
	            'redirect_uri' => Service::getCallbackUrl(),
	            // Our verification code
	            'code_verifier' => $verificationToken,
	            // The code returned from the auth service
	            'code' => $code
	        ]
    	]);


		/**
		 * Grab the response
		 */
    	$payload = (string) $response->getBody();


    	/**
    	 * Try to decode JSON
    	 */
    	$data = json_decode($payload);

    	if ( null === $data )
    	{
    		/**
    		 * Unable to decode JSON :( 
    		 */
    		throw new \TropicSkincare\Api\Exception('Unable to decode JSON response from Id Service');
    	}
    	else
    	{
    		/**
    		 * All good
    		 */
    		return $data;
    	}
	}


	/**
	 * Return the URL for the ID service logout
	 *
	 * @return string
	 */
	public static function getLogoutUrl() : string
	{
		return ApiService::getUrl('id') . '/logout';
	}


	/**
	 * Return a random string to use for verifying the response
	 * from OAuth
	 *
	 * @return string The random string
	 */
	public static function makeVerificationToken() : string
	{
		return md5(time() . rand(0, 100000000) . rand(0, 10000000000));
	}
}