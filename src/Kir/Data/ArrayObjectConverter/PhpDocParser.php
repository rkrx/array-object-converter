<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\PhpDocParser\ParameterDecoder;

class PhpDocParser {
	/**
	 * @param string $comment
	 * @return array
	 */
	public function parse($comment) {
		return $this->parseDocComment($comment);
	}

	/**
	 * @param string $comment
	 * @return array
	 */
	private function parseDocComment($comment) {
		$result = array();
		$lines = explode("\n", $comment);
		foreach($lines as $line) {
			$matches = array();
			if($this->regExpMatch('/^\\s*\\*\\s+@([^\\s]+)\\s+(.+)$/iu', $line, $matches)) {
				list($key, $value) = $matches;
				$value = $this->parseValue($value);
				$result[] = array('key' => $key, 'value' => $value);
			}
		}
		return $result;
	}

	/**
	 * @param string $input
	 * @return string
	 */
	private function parseValue($input) {
		$matches = array();
		$this->regExpMatch('/^([\w\\\\]+)(\s+.*)?$/', $input, $matches);
		$value = $matches[0];
		$optionsStr = array_key_exists(1, $matches) ? $matches[1] : null;
		$options = array();
		if($optionsStr !== null) {
			$options = $this->parseOptions($optionsStr);
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

	/**
	 * @param string $pattern
	 * @param string $input
	 * @param array $matches
	 * @return bool
	 */
	private function regExpMatch($pattern, $input, array &$matches) {
		$result = preg_match($pattern, $input, $matches);
		array_shift($matches);
		$matches = array_map('trim', $matches);
		return $result;
	}
}