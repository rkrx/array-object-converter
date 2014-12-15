<?php
namespace Kir\Data\ArrayObjectConverter\Specification;

interface Method {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return bool
	 */
	public function hasArguments();

	/**
	 * @return Method\Argument[]
	 */
	public function getArguments();
} 