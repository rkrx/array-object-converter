<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProvider;

interface Property {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return Property\Annotations
	 */
	public function annotations();
} 