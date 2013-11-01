<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser;

use Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser\ParameterDecoder;

class ParameterDecoderTest extends \PHPUnit_Framework_TestCase {
	public function testSingleNull() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var=null');
		$value = $this->getValue($result, 'var');
		$this->assertEquals(null, $value);
	}

	public function testSingleTrue() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var=true');
		$value = $this->getValue($result, 'var');
		$this->assertEquals(true, $value);
	}

	public function testSingleFalse() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var=false');
		$value = $this->getValue($result, 'var');
		$this->assertEquals(false, $value);
	}

	public function testSingleInteger() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var=123');
		$value = $this->getValue($result, 'var');
		$this->assertEquals(123, $value);
	}

	public function testSingleFloat() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var=123.45');
		$value = $this->getValue($result, 'var');
		$this->assertEquals(123.45, $value);
	}

	public function testSingleString() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('var="test"');
		$value = $this->getValue($result, 'var');
		$this->assertEquals("test", $value);
	}

	public function testMultipleValues() {
		$decoder = new ParameterDecoder();
		$result = $decoder->decode('a=true, b=null, c=123, d=123.45, e="abc"');

		$value = $this->getValue($result, 'a');
		$this->assertEquals(true, $value);

		$value = $this->getValue($result, 'b');
		$this->assertEquals(null, $value);

		$value = $this->getValue($result, 'c');
		$this->assertEquals(123, $value);

		$value = $this->getValue($result, 'd');
		$this->assertEquals(123.45, $value);

		$value = $this->getValue($result, 'e');
		$this->assertEquals("abc", $value);
	}

	/**
	 * @param string $params
	 * @param string $name
	 * @return mixed
	 */
	private function getValue($params, $name) {
		if(!is_array($params)) {
			return null;
		}
		if(!array_key_exists($name, $params)) {
			return null;
		}
		return $params[$name];
	}
}
 