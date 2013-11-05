<?php
namespace Kir\Data\ArrayObjectConverter\Accessor\Handler;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

interface Property {
	/**
	 * @return mixed
	 */
	public function getPrevValue();

	/**
	 * @return mixed
	 */
	public function getValue();

	/**
	 * @return Parameters
	 */
	public function parameters();
}