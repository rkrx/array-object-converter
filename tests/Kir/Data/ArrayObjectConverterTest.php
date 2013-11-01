<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation\Options;
use Kir\Data\ArrayObjectConverter\Filter\Func;
use Kir\Data\ArrayObjectConverter\Mock\TestObj5;
use Kir\Data\ArrayObjectConverter\Mock\TestObj6;

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
	
	public function testRecursiveSetter() {
		$this->markTestSkipped('must be revisited.');
		return;
		
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
		$aoc->getterFilters()->add('datetime', new Func(function (\DateTime $input, Options $options) {
				return $input->format($options->get('format'));
			}));
		$aoc->setterFilters()->add('datetime', new Func(function ($input, Options $options) {
				return \DateTime::createFromFormat($options->get('format'), $input);
			}));
		return $aoc;
	}
} 