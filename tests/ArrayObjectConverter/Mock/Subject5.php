<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class Subject5 {
	/**
	 * @var int
	 * @aoc-array-key id
	 */
	private $id = 0;

	/**
	 * @var string
	 * @aoc-array-key name
	 */
	private $name = "";

	/**
	 * @var \DateTime
	 * @aoc-array-key birthdate
	 * @aoc-getter-filter datetime format="Y-m-d"
	 * @aoc-setter-filter datetime format="Y-m-d"
	 */
	private $birthdate = null;

	/**
	 */
	public function __construct() {
		$this->birthdate = new \DateTime();
	}

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
	 * @param string $name
	 * @return $this
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param \DateTime $birthdate
	 * @return $this
	 */
	public function setBirthdate(\DateTime $birthdate) {
		$this->birthdate = $birthdate;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getBirthdate() {
		return $this->birthdate;
	}
}