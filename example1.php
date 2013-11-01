<?php
namespace Example1;

require_once '_inc/autoloader.php';

use Kir\Data\ArrayObjectConverter;

class Entity {
	/**
	 * @var int
	 * @aoc-array-key id
	 */
	public $id = 123;

	/**
	 * @var int
	 * @aoc-array-key name
	 */
	public $name = 'Hello World';
}

$entity = new Entity();
$converter = new ArrayObjectConverter($entity);
$data = $converter->getArray();
print_r($data);