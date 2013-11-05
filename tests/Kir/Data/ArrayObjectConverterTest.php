<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\Property;
use Kir\Data\ArrayObjectConverter\Filtering\Filters\Func;
use Kir\Data\ArrayObjectConverter\Mock\TestObj5;
use Kir\Data\ArrayObjectConverter\Mock\TestObj6;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider;

class ArrayObjectConverterTest extends \PHPUnit_Framework_TestCase {
	public function testObjectToArray() {
		$object = new TestObj5();
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

		$object = new TestObj5();
		$this->createAoc($object)->setArray($data);

		$this->assertEquals(123, $object->getId());
		$this->assertEquals('Max Musterman', $object->getName());
		$this->assertEquals('1981-09-29', $object->getBirthdate()->format('Y-m-d'));
	}

	public function testRecursiveGetter() {
		$object = new TestObj6();
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

		$object = new TestObj6();
		$this->createAoc($object)->setArray($data);

		$this->assertEquals(1234, $object->subObj->id);
	}

	/**
	 * @param object $object
	 * @return ArrayObjectConverter
	 */
	private function createAoc($object) {
		$aoc = new ArrayObjectConverter($object);

		$aoc->getAccessor()->getter()->filters()->add('datetime', new Func(function (Property $property) {
			/* @var $datetime \DateTime */
			$datetime = $property->getNewValue();
			return $datetime->format($property->parameters()->get('format')->getValue());
		}));
		$aoc->getAccessor()->setter()->filters()->add('datetime', new Func(function (Property $property) {
			return \DateTime::createFromFormat($property->parameters()->get('format')->getValue(), $property->getNewValue());
		}));

		$aoc->getAccessor()->getter()->filters()->add('object', new Func(function (Property $property) {
			return $this->createAoc($property->getOldValue())->getArray($property->getNewValue());
		}));
		$aoc->getAccessor()->setter()->filters()->add('object', new Func(function (Property $property) {
			return $this->createAoc($property->getOldValue())->setArray($property->getNewValue());
		}));

		return $aoc;
	}
} 