<?php

namespace TropicSkincare\Api;

use \GuzzleHttp\Client as HttpClient;

class Resource extends BaseObject
{
	/**
	 * Retrieve all of this object
	 *
	 * @param array $options Pass options on the URL
	 * @return Collection
	 */
	public static function all(array $options = [])
	{
		$resourceName = get_called_class();

		return self::get($resourceName::ENDPOINT, $options);
	}


	/**
	 * Return a single object
	 *
	 * @param string $id The ID of the object to return
	 * @param array $options Pass options on the URL
	 * @return ApiResource The processed response from the API
	 */
	public static function find($id, array $options = [])
	{
		$resourceName = get_called_class();

		return self::get($resourceName::ENDPOINT . '/' . $id, $options);
	}


	/**
	 * Dummy method to catch Creates on this resource
	 * This can be overridden using the TropicSkincare\Api\Operations\Create trait
	 */
	public static function create(array $values)
	{
		$resourceName = Utilities::stripNamespace(get_called_class());

		throw new Exception("A $resourceName resource can not be created through this client", 400);
	}

	
	/**
	 * Make a GET HTTP request
	 *
	 * @param string $url The URL to call
	 * @param array $getValues Parameters to add to the URL
	 * @return ApiResource The processed response from the API
	 */
	public static function get(string $url, array $getValues = [])
	{
		return self::request('get', $url, $getValues);
	}


	/**
	 * Make a POST HTTP request
	 *
	 * @param string $url The URL to call
	 * @param array $postValues Parameters to add to the post body
	 * @param array $getValues Parameters to add to the URL
	 * @return ApiResource The processed response from the API
	 */
	public static function post(string $url, array $postValues = [], array $getValues = [])
	{
		return self::request('post', $url, $getValues, $postValues);
	}


	/**
	 * Make a PUT HTTP request
	 *
	 * @param string $url The URL to call
	 * @param array $postValues Parameters to add to the PUT body
	 * @param array $getValues Parameters to add to the URL
	 * @return ApiResource The processed response from the API
	 */
	public static function put(string $url, array $postValues = [], array $getValues = [])
	{
		return self::request('put', $url, $getValues, $postValues);
	}


	/**
	 * Make an HTTP request
	 *
	 * @param string $method The HTTP method to use
	 * @param string $url The URL to call
	 * @param array $getParams Parameters to add to the URL
	 * @param array $postParams Parameters to use in a POST body
	 * @return ApiResource The processed response from the API
	 * @throws \Tropic\Api\Exception
	 */
	public static function request($method, $url, array $getParams = [], array $postParams = [])
	{
		$className = get_called_class();
		$serviceName = Utilities::getServiceName($className);

		/**
		 * If the URL is not a full absolute path
		 * then prefix the service URL
		 */
		if ( substr($url, 0, 4) != 'http' )
		{
			$url = Service::getServiceUrl($serviceName) . $url;
		}


		/**
		 * If there are GET parameters, then build them into a query string
		 */
		if ( ! empty($getParams) )
		{
			$url .= '?' . http_build_query($getParams);
		}


		/**
		 * Start building the Guzzle params
		 */
		$requestParams = [
			'headers' => [
				'Accept'     => 'application/json',
			]
		];


		/**
		 * Add bearer token (if it exists)
		 */
		if ( Service::hasBearerToken($serviceName) )
		{
			$requestParams['headers']['Authorization'] = 'Bearer ' . Service::getBearerToken($serviceName);
		}


		/**
		 * Add the post body parameters (if required)
		 */
		if ( ! empty($postParams) )
		{
			$requestParams['form_params'] = $postParams;
		}


		try
		{
			/**
			 * Make the request
			 */
			$httpClient = new HttpClient;
			$response = $httpClient->request($method, $url, $requestParams);


			/**
			 * Decode the JSON response payload
			 */
			$data = json_decode((string) $response->getBody());

	
			/**
			 * Run our response builder and return the data
			 */
			return self::buildObjectFromResponse($data);
		}
		catch ( \GuzzleHttp\Exception\ClientException $e )
		{
			/**
			 * Something went wrong with the client data provided
			 * (ie, we received a 4** HTTP response)
			 */

			/**
			 * Decode the JSON response payload
			 */
			$data = json_decode((string) $e->getResponse()->getBody(true));


			/**
			 * Throw our error
			 */
			$errors = $data->errors ?? [];

			throw new Exception($data->message, $e->getCode(), $errors);
		}
		catch ( \Exception $e )
		{
			/**
			 * An unhandled error occurred
			 */
			throw new Exception('An error occurring talking to the API: ' . $e->getMessage(), 500);
		}
	}


	/**
	 * Convert response into an Object
	 *
	 * @param array $response The JSON object API response
	 * @return object
	 */
	public static function buildObjectFromResponse($response)
	{
		$className = get_called_class();

		/**
		 * Check if this response is a collection
		 */
		if ( property_exists($response, 'data') && property_exists($response, 'meta') )
		{
			return new Collection($response, $className);
		}
		else
		{
			return new $className($response);
		}
	}


	/**
	 * Every call to the API returns an object name which helps us map
	 * it to a local class, this method converts that name to title case
	 * Example: 'payment_demand' would become PaymentDemand
	 *
	 * @param string $name
	 * @return string
	 */
	private static function convertObjectNameToClassName(string $name) : string
	{
		$words = explode('_', $name);
		$className = '';

		foreach ( $words as $w )
		{
			$className .= ucfirst($w);
		}


		/**
		 * Split the class name (inc namespace) of the called class
		 * This is so we can find the correct object when un-bundling
		 * the response object(s)
		 */
		$namespace = explode('\\', get_called_class());


		/**
		 * Build array of namespaces to find the classes
		 */
		$tries = [
			$namespace[0] . '\\' . $namespace[1],
			$namespace[0] . '\\Api'
		];	


		foreach ( $tries as $tryNamespace )
		{
			$tryClassName = $tryNamespace . '\\' . $className;

			if ( class_exists($tryClassName) )
			{
				return $tryClassName;
			}
		}


		/**
		 * No matching namespace/class was found, use the BaseObject 
		 */
		return $namespace[0] . '\\Api\BaseObject';
	}


	/**
	 * Objectified (non-static) methods
	 */

	
	/**
	 * Dummy method to catch updates on this resource
	 * This can be overridden using the TropicSkincare\Api\Operations\Update trait
	 */
	public function update(array $data)
	{
		$resourceName = Utilities::stripNamespace(get_called_class());

		throw new Exception("$resourceName resources can not be updated through this client", 400);
	}


	/**
	 * Dummy method to catch delete on this resource
	 * This can be overridden using the TropicSkincare\Api\Operations\Delete trait
	 */
	public function delete()
	{
		$resourceName = Utilities::stripNamespace(get_called_class());

		throw new Exception("$resourceName resources can not be deleted through this client", 400);
	}


	/**
	 * Call a link URL
	 *
	 * @param string $name The name of the link to request
	 * @return ApiResource The processed response from the API
	 */
	public function getLink($name)
	{
		return self::request('get', $this->links[$name]);
	}


	/**
	 * Get the self link (or make one if it isn't available)
	 *
	 * @return string 
	 */
	public function getSelfLink()
	{
		if ( isset($this->links->self) )
		{
			return $this->links->self;
		}
		else
		{
			return $this->links->self = self::ENDPOINT . '/' . $this->id;
		}
	}
	
}