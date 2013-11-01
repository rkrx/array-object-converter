<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation;
use Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser;
use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property AS IProperty;

class Property implements IProperty {
	/**
	 * @var string
	 */
	private $name = null;

	/**
	 * @var array
	 */
	private $annotations = [];

	/**
	 * @param string $name
	 * @param Annotation[] $annotations
	 */
	public function __construct($name, array $annotations) {
		$this->name = $name;
		$this->annotations = new Property\AnnotationStore($annotations);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return Annotation[]
	 */
	public function annotations() {
		return $this->annotations;
	}
}