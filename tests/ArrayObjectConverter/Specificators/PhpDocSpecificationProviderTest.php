<?php
namespace Kir\Data\ArrayObjectConverter\Specificators;

use Kir\Data\ArrayObjectConverter\Mock\Subject1;

class PhpDocSpecificationProviderTest extends \PHPUnit_Framework_TestCase {
	public function testPublicPropertyIntrospection() {
		$provider = new PhpDocSpecificationProvider();
		
		$obj = new Subject1();
		$specification = $provider->fromObject($obj);
		$properties = $specification->getProperties();
		$property = $properties[0];
		
		$this->assertEquals('property', $property->getName());
		$this->assertEquals('int', $property->getType());
		$this->assertEquals(true, $property->annotations()->has('array-key'));
		$this->assertEquals('data', $property->annotations()->getFirst('array-key')->getValue());
	}
}
 