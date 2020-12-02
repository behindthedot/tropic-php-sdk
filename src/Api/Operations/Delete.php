<?php

namespace TropicSkincare\Api\Operations;

trait Delete
{
	/**
	 * Delete this resource
	 *
	 * @return ApiResource The response from the API
	 */
	public function delete()
	{
		return self::request('delete', $this->getSelfLink());
	}
}