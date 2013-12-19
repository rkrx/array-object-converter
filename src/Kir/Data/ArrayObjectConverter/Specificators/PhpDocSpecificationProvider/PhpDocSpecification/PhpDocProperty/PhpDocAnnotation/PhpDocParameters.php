<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotation;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\NoSuchParameterException;
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
	 * @throws NoSuchParameterException
	 * @return Parameter
	 */
	public function get($name) {
		if(!$this->has($name)) {
			return [];
		}
		return $this->params[$this->paramNames[$name]];
	}

	/**
	 * @param string $name
	 * @param bool|int|float|string|null $default
	 * @return bool|int|float|string|null
	 */
	public function getValue($name, $default=null) {
		if($this->has($name)) {
			return $this->get($name)->getValue();
		}
		return $default;
	}
} 
