<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser;

class AnnotationParser {
	/**
	 * @param string $line
	 * @return array
	 */
	public function parseDefinition($line) {
		$pattern = Pattern::create('^([\\w\\-]+)(\\s+.+)?$', 'iu')->setSubject($line);
		if ($pattern->isMatching()) {
			$data = $pattern->getArray();
			$name = $data[0];
			$paramsStr = count($data) > 1 ? $data[1] : '';
			list($value, $params) = $this->parseValue($paramsStr);
			return ['name' => $name, 'value' => $value, 'params' => $params];
		}
		return ['name' => null, 'value' => null, 'params' => []];
	}

	/**
	 * @param string $value
	 * @return array
	 */
	private function parseValue($value) {
		$value = ltrim($value);
		$params = [];
		$pattern = Pattern::create('^([\w\\\\]+)(\s+.*)?$')->setSubject($value);
		if ($pattern->isMatching()) {
			$matches = $pattern->getArray();
			$matches = array_map('trim', $matches);
			$value = $matches[0];
			$optionsStr = count($matches) > 1 ? $matches[1] : null;
			if ($optionsStr !== null) {
				$params = $this->parseParams($optionsStr);
			}
		}
		return array($value, $params);
	}

	/**
	 * @param string $optionsStr
	 * @return array
	 */
	private function parseParams($optionsStr) {
		$decoder = new ParameterDecoder();
		return $decoder->decode($optionsStr);
	}
} 