<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\Filter\Func;
use Kir\Data\ArrayObjectConverter\Mock\TestObj1;
use Kir\Data\ArrayObjectConverter\Mock\TestObj2;
use Kir\Data\ArrayObjectConverter\Mock\TestObj3;
use Kir\Data\ArrayObjectConverter\Mock\TestObj4;

class GetterTest extends \PHPUnit_Framework_TestCase {
	public function testPublic() {
		$testObj = new TestObj1();
		$testObj->property = 1234;
		
		$getter = $this->createHandler($testObj, new Filters());
		$values = $getter->get();
		
		$this->assertArrayHasKey('data', $values);
		$this->assertEquals(1234, $values['data']);
	}
	
	public function testPrivate() {
		$testObj = new TestObj2();
		$testObj->setProperty(1234);
		
		$getter = $this->createHandler($testObj, new Filters());
		$values = $getter->get();
		
		$this->assertArrayHasKey('data', $values);
		$this->assertEquals(1234, $values['data']);
	}
	
	public function testPublicFilter() {
		$testObj = new TestObj3();
		$testObj->property = "this is a test";
		
		$filters = new Filters();
		$filters->add('uppercase', new Func(function ($input) {
				return strtoupper($input);
			}));
		$getter = $this->createHandler($testObj, $filters);
		$values = $getter->get();
		
		$this->assertArrayHasKey('data', $values);
		$this->assertEquals("THIS IS A TEST", $values['data']);
	}
	
	public function testPrivateFilter() {
		$testObj = new TestObj4();
		$testObj->setProperty = "this is a test";
		
		$filters = new Filters();
		$filters->add('uppercase', new Func(function ($input) {
				return strtoupper($input);
			}));
		$getter = $this->createHandler($testObj, $filters);
		$values = $getter->get();
		
		$this->assertArrayHasKey('data', $values);
		$this->assertEquals("THIS IS A TEST", $values['data']);
	}

	/**
	 * @param object $object
	 * @param Filters $filters
	 * @return GetterHandler
	 */
	private function createHandler($object, Filters $filters) {
		$provider = new PhpDocDefinitionProvider($object);
		return new GetterHandler($object, $provider, $filters);
	}
}
 