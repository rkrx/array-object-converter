<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider;

class PhpDocDefinitionProviderTest extends \PHPUnit_Framework_TestCase {
	public function testPropertyCount() {
		$object = new Mock\TestObj2();
		$provider = new PhpDocDefinitionProvider($object);

		$properties = $provider->getProperties();
		$this->assertCount(1, $properties);
		$this->assertEquals('property', $properties[0]->getName());

		$annotations = $properties[0]->annotations();
		$this->assertEquals(true, $annotations->has('var'));
		$this->assertEquals('int', $annotations->getFirst('var')->getValue());
		$this->assertEquals(true, $annotations->has('array-key'));
		$this->assertEquals('data', $annotations->getFirst('array-key')->getValue());
	}
}
 