<?php
namespace Example4;

require_once '_inc/autoloader.php';

use Kir\Data\ArrayObjectConverter;
use Kir\Data\ArrayObjectConverter\Filtering\Filters\Func;
use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;

class Entity {
	/**
	 * @var int
	 * @aoc-array-key id
	 * @aoc-getter-filter test param1="\"String\"", param2=true, param3=false, param4=null, param5=123, param6=123.45
	 */
	public $id = 1234;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}

/**
 */
class LocalArrayObjectConverter extends ArrayObjectConverter {
	/**
	 * @param object $object
	 */
	public function __construct($object) {
		parent::__construct($object);

		$this->getAccessor()->getter()->filters()->add('test', new Func(function (Property $property) {
				foreach($property->parameters()->getAll() as $parameter) {
					echo sprintf("%s: %s\n", $parameter->getName(), json_encode($parameter->getValue()));
				}
			}));
	}
}

$entity = new Entity();
$converter = new LocalArrayObjectConverter($entity);
$data = $converter->getArray();
print_r($data);
