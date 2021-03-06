<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\Property;
use Kir\Data\ArrayObjectConverter\Filtering\Filters\Func;
use Kir\Data\ArrayObjectConverter\Mock\Subject5;
use Kir\Data\ArrayObjectConverter\Mock\Subject6;
use Kir\Data\ArrayObjectConverter\Mock\Subject7;
use Kir\Data\ArrayObjectConverter\Mock\Subject8;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider;

class ArrayObjectConverterTest extends \PHPUnit_Framework_TestCase {
	public function testObjectToArray() {
		$object = new Subject5();
		$object->setId(123);
		$object->setName('Max Musterman');
		$object->setBirthdate(\DateTime::createFromFormat('Y-m-d', '1981-09-29'));

		$data = $this->createAoc($object)->getArray();

		$this->assertArrayHasKey('id', $data);
		$this->assertArrayHasKey('name', $data);
		$this->assertArrayHasKey('birthdate', $data);
	}

	public function testArrayToObject() {
		$data = [
			'id' => 123,
			'name' => 'Max Musterman',
			'birthdate' => '1981-09-29',
		];

		$object = new Subject5();
		$this->createAoc($object)->setArray($data);

		$this->assertEquals(123, $object->getId());
		$this->assertEquals('Max Musterman', $object->getName());
		$this->assertEquals('1981-09-29', $object->getBirthdate()->format('Y-m-d'));
	}

	public function testRecursiveGetter() {
		$object = new Subject6();
		$object->subObj->id = 123;

		$data = $this->createAoc($object)->getArray();

		$this->assertEquals(123, $data['sub']['id']);
	}

	public function testRecursiveSetter() {
		$data = [
			'sub' => [
				'id' => 1234,
			]
		];

		$object = new Subject6();
		$this->createAoc($object)->setArray($data);

		$this->assertEquals(1234, $object->subObj->id);
	}

	/**
	 */
	public function testSetBy() {
		$obj = new Subject7();
		$obj->setIsActive(false);
		$this->assertEquals(false, $obj->isActive());
		$aoc = $this->createAoc($obj);
		$aoc->setArray(['active' => true]);
		$this->assertEquals(true, $obj->isActive());
	}

	/**
	 */
	public function testGetBy() {
		$obj = new Subject7();
		$obj->setIsActive(true);
		$aoc = $this->createAoc($obj);
		$data = $aoc->getArray();
		$this->assertArrayHasKey('active', $data);
		$this->assertEquals(true, $data['active']);
	}

	public function testForceWriteToProperty() {
		$obj = new Subject8();
		$obj->setActiveX(false);
		$aoc = $this->createAoc($obj);
		$aoc->setArray(['active' => true]);
		$this->assertEquals(true, $obj->getActiveX());
	}

	public function testForceReadFromProperty() {
		$obj = new Subject8();
		$obj->setActiveX(true);
		$aoc = $this->createAoc($obj);
		$data = $aoc->getArray();
		$this->assertArrayHasKey('active', $data);
		$this->assertEquals(true, $data['active']);
	}

	/**
	 * @param object $object
	 * @return ArrayObjectConverter
	 */
	private function createAoc($object) {
		$aoc = new ArrayObjectConverter($object);
		$this->injectDatetimeFiltersIntoAoc($aoc);
		$this->injectObjectFilterIntoAoc($aoc);
		return $aoc;
	}

	/**
	 * @param $aoc
	 */
	private function injectDatetimeFiltersIntoAoc($aoc) {
		$aoc->getAccessor()->getter()->filters()->add('datetime', new Func(function (Property $property) {
			/* @var $datetime \DateTime */
			$datetime = $property->getValue();
			return $datetime->format($property->parameters()->get('format')->getValue());
		}));
		$aoc->getAccessor()->setter()->filters()->add('datetime', new Func(function (Property $property) {
			return \DateTime::createFromFormat($property->parameters()->get('format')
				->getValue(), $property->getValue());
		}));
	}

	/**
	 * @param $aoc
	 */
	private function injectObjectFilterIntoAoc($aoc) {
		$aoc->getAccessor()->getter()->filters()->add('object', new Func(function (Property $property) {
			return $this->createAoc($property->getPrevValue())->getArray($property->getValue());
		}));
		$aoc->getAccessor()->setter()->filters()->add('object', new Func(function (Property $property) {
			return $this->createAoc($property->getPrevValue())->setArray($property->getValue());
		}));
	}
} 