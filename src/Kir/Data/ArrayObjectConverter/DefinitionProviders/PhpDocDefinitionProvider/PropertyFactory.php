<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation;
use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\PhpDocParser;
use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\Property;

class PropertyFactory {
	/**
	 * @var object
	 */
	private $obj = null;

	/**
	 * @param object $obj
	 */
	public function __construct($obj) {
		$this->obj = $obj;
	}

	/**
	 * @return Property[]
	 */
	public function getAll() {
		$refObj = new \ReflectionClass($this->obj);
		$properties = array();
		foreach ($refObj->getProperties() as $refProperty) {
			$name = $refProperty->getName();
			$doc = $refProperty->getDocComment();
			$annotations = $this->parseDoc($doc);
			$properties[] = new Property($name, $annotations);
		}
		return $properties;
	}

	/**
	 * @param $doc
	 * @return Annotation[]
	 */
	private function parseDoc($doc) {
		$parser = new PhpDocParser();
		return $parser->parse($doc);
	}
} 