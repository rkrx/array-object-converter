<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Method;

interface Argument {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getType();
} 