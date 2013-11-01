<?php
namespace Kir\Data\ArrayObjectConverter\Patterns;

class Pattern {
	/**
	 * @param string $pattern
	 * @param string $flags
	 * @return static
	 */
	public static function create($pattern, $flags = '') {
		return new static($pattern, $flags);
	}

	/**
	 * @var string
	 */
	private $pattern = null;

	/**
	 * @var string
	 */
	private $subject = null;

	/**
	 * @param string $pattern
	 * @param string $flags
	 */
	public function __construct($pattern, $flags = '') {
		$pattern = $this->normalizePattern($pattern, $flags);
		$this->pattern = $pattern;
	}

	/**
	 * @param string $subject
	 * @return $this;
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isMatching() {
		return !!preg_match($this->pattern, $this->subject);
	}

	/**
	 * @return string[]
	 */
	public function getArray() {
		$matches = [];
		if (preg_match($this->pattern, $this->subject, $matches)) {
			array_shift($matches);
			return $matches;
		}
		return [];
	}

	/**
	 * @return string
	 */
	public function getFirst() {
		$array = $this->getArray();
		return array_shift($array);
	}

	/**
	 * @param string $pattern
	 * @param string $flags
	 * @return string
	 */
	private function normalizePattern($pattern, $flags) {
		$pattern = strtr($pattern, ['/' => '\\/']);
		return "/{$pattern}/{$flags}";
	}
} 