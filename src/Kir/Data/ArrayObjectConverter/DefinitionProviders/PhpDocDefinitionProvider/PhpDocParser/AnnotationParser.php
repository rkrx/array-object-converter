<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\PhpDocParser;

use Kir\Data\ArrayObjectConverter\Patterns\Pattern;
use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\PhpDocParser\ParserAnnotation;

class AnnotationParser {
	/**
	 * @param string $line
	 * @return ParserAnnotation
	 */
	public function parseLine($line) {
		$pattern = Pattern::create('^([\\w\\-]+)(\\s+.+)?$', 'iu')->setSubject($line);
		if ($pattern->isMatching()) {
			$data = $pattern->getArray();
			$data = array_map('trim', $data);
			$key = $data[0];
			$key = preg_replace('/^(aoc-)(.*)$/', '$2', $key);
			$valueStr = count($data) > 1 ? $data[1] : '';
			$value = $this->parseValue($valueStr);
			$annotation = new ParserAnnotation($key, $value);
			return $annotation;
		}
		return null;
	}

	/**
	 * @param string $input
	 * @return string
	 */
	private function parseValue($input) {
		$options = [];
		$value = $input;
		$pattern = Pattern::create('^([\w\\\\]+)(\s+.*)?$')->setSubject($input);
		if ($pattern->isMatching()) {
			$matches = $pattern->getArray();
			$matches = array_map('trim', $matches);
			$value = $matches[0];
			$optionsStr = count($matches) > 1 ? $matches[1] : null;
			if ($optionsStr !== null) {
				$options = $this->parseOptions($optionsStr);
			}
		}
		return array('value' => $value, 'options' => $options);
	}

	/**
	 * @param string $optionsStr
	 * @return array
	 */
	private function parseOptions($optionsStr) {
		$decoder = new ParameterDecoder();
		return $decoder->decode($optionsStr);
	}
} 