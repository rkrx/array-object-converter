<?php
namespace Example2;

use Kir\Data\ArrayObjectConverter;

require_once '_inc/autoloader.php';

class Entity {
	/**
	 * @var int
	 * @aoc-array-key id
	 */
	private $id = 456;

	/**
	 * @var int
	 * @aoc-array-key name
	 */
	private $name = 'Hello World';

	/**
	 * @param int $id
	 * @return $this
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $name
	 * @return $this
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getName() {
		return $this->name;
	}
}

$entity = new Entity();
$converter = new ArrayObjectConverter($entity);
$data = $converter->getArray();
print_r($data);