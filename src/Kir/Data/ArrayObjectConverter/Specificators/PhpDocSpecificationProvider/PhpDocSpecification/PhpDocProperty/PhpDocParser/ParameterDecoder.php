<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser;

/**
 * Class ParameterDecoder
 * TODO Not error prove
 */
class ParameterDecoder {
	/**
	 * @var array
	 */
	private $result = array();

	/**
	 * @param string $input
	 * @return array
	 */
	public function decode($input) {
		if (strlen($input) > 0) {
			$this->extractKey($input);
		}
		return $this->result;
	}

	/**
	 * @param string $input
	 */
	private function extractKey($input) {
		$input = ltrim($input);
		if (preg_match('/^\w+\\s*=/', $input)) {
			list($key, $rest) = explode('=', $input, 2);
			list($value, $rest) = $this->extractValue($rest);
			$this->result[$key] = $value;
			$this->tryNextParam($rest);
		}
	}

	/**
	 * @param string $input
	 * @throws ParserException
	 * @return array
	 */
	private function extractValue($input) {
		$input = ltrim($input);
		if (preg_match('/^\\"/', $input)) {
			return $this->extractString($input);
		}
		if (preg_match('/^(true|false|\\d+|\\d*\\.\\d+|null)/', $input)) {
			return $this->extractScalarValue($input);
		}
		throw new ParserException();
	}

	/**
	 * @param string $input
	 * @return array
	 */
	private function extractString($input) {
		$input = ltrim($input, '"');
		list($string, $rest) = preg_split('/(?<!\\\\)"/', $input, 2);
		$string = strtr($string, array('\\\\' => '\\', '\\"' => '"'));
		return array($string, $rest);
	}

	/**
	 * @param string $input
	 * @return array
	 */
	private function extractScalarValue($input) {
		list($value, $rest) = $this->regExpGet('/^(true|false|null|\\d*\\.\\d+|\\d+)(.*)$/i', $input);
		$value = strtolower($value);
		if ($value == 'true' || $value == 'false') {
			$value = $value == 'true';
		} elseif ($value == 'null') {
			$value = null;
		}
		return array($value, $rest);
	}

	/**
	 * @param string $input
	 * @throws ParserException
	 */
	private function tryNextParam($input) {
		$input = trim($input);
		if (substr($input, 0, 1) == ',') {
			// One more parameter
			$input = ltrim($input, ',');
			$this->extractKey($input);
		} elseif (substr($input, 0, 1) == '#') {
			// Comment
			return;
		} elseif ($input != '') {
			throw new ParserException("Unexpected end near \"{$input}\"");
		}
	}

	/**
	 * @param string $pattern
	 * @param string $input
	 * @return bool
	 */
	private function regExpGet($pattern, $input) {
		$matches = array();
		preg_match($pattern, $input, $matches);
		array_shift($matches);
		$matches = array_map('trim', $matches);
		return $matches;
	}
}