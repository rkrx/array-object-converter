<?php
namespace Kir\Data\ArrayObjectConverter;

interface SpecificationProvider {
	/**
	 * @param object $object
	 * @return Specification
	 */
	public function fromObject($object);
} 