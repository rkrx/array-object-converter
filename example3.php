<?php
namespace Example3;

require_once '_inc/autoloader.php';

use Kir\Data\ArrayObjectConverter;

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
	 * @aoc-getter-filter datetime format="c"
	 * @aoc-setter-filter datetime format="c"
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

		$this->setterHandler()->filters()->add('datetime', new Func(function ($value, Options $options) {
			return \DateTime::createFromFormat($options->get('format'), $value);
		}));

		$this->getterHandler()->filters()->add('datetime', new Func(function (\DateTime $value, Options $options) {
			return $value->format($options->get('format'));
		}));
	}
}

$entity = new Entity();
$converter = new LocalArrayObjectConverter($entity);
$converter->setArray(array('id' => 456, 'name' => 'Hello World', 'date' => '2009-06-30T18:30:00+02:00'));

print_r($entity);

$data = $converter->getArray();

print_r($data);