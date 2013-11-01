<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser;

class AnnotationParserTest extends \PHPUnit_Framework_TestCase {
	public function testUnparameterized() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseLine('param');
		$this->assertEquals('param', $annotation->getKey());
	}

	public function testParameterized() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseLine('var int');
		$this->assertEquals('var', $annotation->getKey());
		$this->assertEquals('int', $annotation->getValue());
	}

	public function testParameterizedWithOptions() {
		$parser = new AnnotationParser();
		$annotation = $parser->parseLine('var int test=1234');
		$this->assertEquals('var', $annotation->getKey());
		$this->assertEquals('int', $annotation->getValue());
		$this->assertEquals(true, $annotation->options()->has('test'));
		$this->assertEquals(1234, $annotation->options()->get('test'));
	}
}
 