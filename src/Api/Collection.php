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
	public function __construct($data)
	{
		$this->items = isset($data['data']) ? $data['data'] : [];
		$this->meta = isset($data['meta']) ? $data['meta'] : [];
		$this->links = isset($data['links']) ? $data['links'] : [];
	}


	/**
	 * To String
	 *
	 * @return string The json respresentation of this object
	 */
	public function __toString()
	{
		return json_encode([
			'items' => $this->items,
			'meta' => $this->meta,
			'links' => $this->links
		]);
	}
}