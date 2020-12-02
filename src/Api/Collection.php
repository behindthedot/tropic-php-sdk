<?php

namespace TropicSkincare\Api;

class Collection
{
	/**
	 * @var array
	 */
	public $items = [];


	/**
	 * @var array
	 */
	public $meta = [];


	/**
	 * @var array
	 */
	public $links = [];


	/**
	 * Constructor
	 *
	 * @param array $data The API response
	 */
	public function __construct(object $data, $collectedClassName = null)
	{
		/**
		 * If no collected class is provide, we default to our BaseObject
		 */
		if ( null === $collectedClassName )
		{
			$collectedClassName = '\TropicSkincare\Api\BaseObject';
		}


		/**
		 * Iterate through data items and build objects
		 */
		foreach ( $data->data as $item )
		{
			$this->items[] = new $collectedClassName($item);
		}

		$this->meta = $data->meta;
		$this->links = $data->links;
	}
}