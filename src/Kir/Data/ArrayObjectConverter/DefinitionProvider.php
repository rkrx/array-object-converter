<?php
namespace Kir\Data\ArrayObjectConverter;

/**
 */
interface DefinitionProvider {
	/**
	 * @return DefinitionProvider\Property[]
	 */
	public function getProperties();
} 