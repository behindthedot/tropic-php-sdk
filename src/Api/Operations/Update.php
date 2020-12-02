<?php

namespace TropicSkincare\Api\Operations;

trait Update
{
	/**
	 * Update/Save the loaded model
	 *
	 * @param array $data The data to save
	 * @return ApiResource The processed response from the API
	 */
	public function update(array $data)
	{
		return self::put($this->getSelfLink(), [], $data);
	}
}