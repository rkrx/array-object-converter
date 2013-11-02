<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider;

use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\PhpDocParser;

class PhpDocParserTest extends \PHPUnit_Framework_TestCase {
	public function testPhpDoc() {
		$comment = "\t/**\n\t * @var int\n\t */";
		$parser = new PhpDocParser();
		$result = $parser->parse($comment);
		$this->assertCount(1, $result);
		$annotation = $result[0];
		$this->assertEquals('var', $annotation->getKey());
		$this->assertEquals('int', $annotation->getValue());
	}
}
 