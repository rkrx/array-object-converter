<?php
namespace Kir\Data\ArrayObjectConverter\Accessor\Handler;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameter;

interface Property {
	/**
	 * @return mixed
	 */
	public function getOldValue();

	/**
	 * @return mixed
	 */
	public function getNewValue();

	/**
	 * @return Parameter[]
	 */
	public function parameters();
}