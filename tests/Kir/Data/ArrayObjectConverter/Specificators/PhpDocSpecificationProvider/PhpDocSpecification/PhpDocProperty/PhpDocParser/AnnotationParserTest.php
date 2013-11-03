<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser;

class AnnotationParserTest extends \PHPUnit_Framework_TestCase {
	public function testUnparameterized() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseDefinition('param');
		$this->assertArrayHasKey('name', $annotation);
		$this->assertEquals('param', $annotation['name']);
	}

	public function testParameterized() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseDefinition('var int');
		$this->assertArrayHasKey('name', $annotation);
		$this->assertEquals('var', $annotation['name']);
		$this->assertArrayHasKey('value', $annotation);
		$this->assertEquals('int', $annotation['value']);
	}

	public function testParameterizedWithOptions() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseDefinition('var int test=1234');
		$this->assertArrayHasKey('name', $annotation);
		$this->assertEquals('var', $annotation['name']);
		$this->assertArrayHasKey('value', $annotation);
		$this->assertEquals('int', $annotation['value']);
		$this->assertArrayHasKey('params', $annotation);
		$this->assertArrayHasKey('test', $annotation['params']);
		$this->assertEquals(1234, $annotation['params']['test']);
	}
}
 