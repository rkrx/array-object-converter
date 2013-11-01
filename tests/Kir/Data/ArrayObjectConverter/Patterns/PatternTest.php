<?php
namespace Kir\Data\ArrayObjectConverter\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {
	public function testInstancing() {
		$instance = Pattern::create('^\\w+$');
		$this->assertInstanceOf(Pattern::class, $instance);
	}
	
	public function testMatching() {
		$result = Pattern::create('^\\d+$')->setSubject('1234')->isMatching();
		$this->assertEquals(true, $result);
	}
	
	public function testNotMatching() {
		$result = Pattern::create('^\\d+$')->setSubject('!1234')->isMatching();
		$this->assertEquals(false, $result);
	}
	
	public function testArray() {
		$result = Pattern::create('^(\\d+)-(\\d+)-(\\d+)$')->setSubject('2000-01-02')->getArray();
		$this->assertEquals('["2000","01","02"]', json_encode($result));
	}
}
