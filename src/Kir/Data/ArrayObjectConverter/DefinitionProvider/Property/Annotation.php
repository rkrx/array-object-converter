<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;

interface Annotation {
	/**
	 * @return Annotation\Options
	 */
	public function options();

	/**
	 * @return string
	 */
	public function getValue();

	/**
	 * @return string
	 */
	public function getKey();
}