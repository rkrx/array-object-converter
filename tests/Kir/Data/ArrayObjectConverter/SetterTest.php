<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\Filter\Func;
use Kir\Data\ArrayObjectConverter\Mock\TestObj1;
use Kir\Data\ArrayObjectConverter\Mock\TestObj2;
use Kir\Data\ArrayObjectConverter\Mock\TestObj3;
use Kir\Data\ArrayObjectConverter\Mock\TestObj4;

class SetterTest extends \PHPUnit_Framework_TestCase {
	public function testPublic() {
		$testObj = new TestObj1();
		$setter = $this->createHandler($testObj, new Filters());
		$setter->set(['data' => 123]);
		$this->assertEquals(123, $testObj->property);
	}

	public function testPrivate() {
		$testObj = new TestObj2();
		$setter = $this->createHandler($testObj, new Filters());
		$setter->set(['data' => 123]);
		$this->assertEquals(123, $testObj->getProperty());
	}

	public function testPublicFilter() {
		$testObj = new TestObj3();

		$filters = new Filters();
		$filters->add(
			'lowercase',
			new Func(function ($input) {
				return strtolower($input);
			})
		);
		$setter = $this->createHandler($testObj, $filters);
		$setter->set(['data' => 'THIS IS A TEST']);

		$this->assertEquals("this is a test", $testObj->property);
	}

	public function testPrivateFilter() {
		$testObj = new TestObj4();

		$filters = new Filters();
		$filters->add(
			'lowercase',
			new Func(function ($input) {
				return strtolower($input);
			})
		);
		$setter = $this->createHandler($testObj, $filters);
		$setter->set(['data' => 'THIS IS A TEST']);

		$this->assertEquals("this is a test", $testObj->getProperty());
	}

	/**
	 * @param object $object
	 * @param Filters $filters
	 * @return SetterHandler
	 */
	private function createHandler($object, Filters $filters) {
		$provider = new PhpDocDefinitionProvider($object);
		return new SetterHandler($object, $provider, $filters);
	}
}
 