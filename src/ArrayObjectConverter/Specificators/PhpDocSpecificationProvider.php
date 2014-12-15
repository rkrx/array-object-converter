<?php
namespace Kir\Data\ArrayObjectConverter\Specificators;

use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProvider;

class PhpDocSpecificationProvider implements SpecificationProvider {
	/**
	 * @param object $object
	 * @return Specification
	 */
	public function fromObject($object) {
		return new PhpDocSpecificationProvider\PhpDocSpecification($object);
	}
} 