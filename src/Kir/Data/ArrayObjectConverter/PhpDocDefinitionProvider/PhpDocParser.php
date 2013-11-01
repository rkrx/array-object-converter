<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider;

use Kir\Data\ArrayObjectConverter\Patterns\Pattern;
use Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser\AnnotationParser;

class PhpDocParser {
	/**
	 * @var AnnotationParser
	 */
	private $annotationParser = null;

	/**
	 */
	public function __construct() {
		$this->annotationParser = new AnnotationParser();
	}

	/**
	 * @param string $input
	 * @return PhpDocParser\ParserAnnotation[]
	 */
	public function parse($input) {
		$result = [];
		$lines = explode("\n", $input);
		$pattern = Pattern::create('^\\s*\\*\\s*@([\\w\\-]+.*)$', 'iu');
		foreach ($lines as $line) {
			if ($pattern->setSubject($line)->isMatching()) {
				$string = $pattern->getFirst();
				$annotation = $this->annotationParser->parseLine($string);
				$result[] = $annotation;
			}
		}
		return $result;
	}
}