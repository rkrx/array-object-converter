<?php
namespace Kir\Data\ArrayObjectConverter;

class Annotations {
	/**
	 * @var Annotation[]
	 */
	private $annotations = array();

	/**
	 * @param array $data
	 */
	public function __construct(array $data) {
		$this->annotations = array();
		foreach($data as $param) {
			$key = $param['key'];
			$value = $param['value'];
			if(!array_key_exists($key, $data)) {
				$this->annotations[$key] = array();
			}
			$this->annotations[$key][] = new Annotation($key, $value);
		}
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->annotations);
	}

	/**
	 * @param string $name
	 * @return Annotation
	 */
	public function getFirst($name) {
		if($this->has($name)) {
			$annotations = $this->get($name);
			$firstAnnotation = array_shift($annotations);
			return $firstAnnotation;
		}
		return null;
	}

	/**
	 * @param string $name
	 * @throws Exception
	 * @return Annotation[]
	 */
	public function get($name) {
		if($this->has($name)) {
			$annotations = $this->annotations[$name];
			if(!is_array($annotations)) {
				throw new Exception("Invalid annotation");
			}
			return $annotations;
		}
		return array();
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->annotations;
	}
} 