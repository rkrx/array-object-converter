<?php
namespace Example3;

require_once '_inc/autoloader.php';

use Kir\Data\ArrayObjectConverter;
use Kir\Data\ArrayObjectConverter\Filtering\Filters\Func;
use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;

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
	 * @var \DateTime
	 * @aoc-array-key date
	 * @aoc-getter-filter datetime format="Y-m-d\\TH:i:sO"
	 * @aoc-setter-filter datetime format="Y-m-d\\TH:i:sO"
	 */
	private $date=null;

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

	/**
	 * @param \DateTime $date
	 * @return $this
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}
}

class LocalArrayObjectConverter extends ArrayObjectConverter {
	/**
	 * @param object $object
	 */
	public function __construct($object) {
		parent::__construct($object);

		$this->getAccessor()->setter()->filters()->add('datetime', new Func(function (Property $property) {
			return \DateTime::createFromFormat($property->parameters()->getValue('format', 'Y-m-d\\TH:i:sO'), $property->getValue());
		}));

		$this->getAccessor()->getter()->filters()->add('datetime', new Func(function (Property $property) {
			return $property->getValue()->format($property->parameters()->getValue('format', 'Y-m-d\\TH:i:sO'));
		}));
	}
}

$entity = new Entity();
$converter = new LocalArrayObjectConverter($entity);
$converter->setArray(array('id' => 456, 'name' => 'Hello World', 'date' => '2009-06-30T18:30:00+02:00'));

print_r($entity);

$data = $converter->getArray();

print_r($data);