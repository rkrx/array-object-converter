<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotation;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameter;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

class PhpDocParameters implements Parameters {
	/**
	 * @var Parameter[]
	 */
	private $params = [];
	
	/**
	 * @var string[]
	 */
	private $paramNames = [];
	
	/**
	 * @param Parameter[] $params
	 */
	public function __construct($params) {
		$this->params = $params;
		foreach($params as $id => $param) {
			$this->paramNames[$param->getName()] = $id;
		}
	}
	
	/**
	 * @return Parameter[]
	 */
	public function getAll() {
		return $this->params;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->paramNames);
	}

	/**
	 * @param string $name
	 * @return Parameter
	 */
	public function get($name) {
		return $this->params[$this->paramNames[$name]];
	}
} 