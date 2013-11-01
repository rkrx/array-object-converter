<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;

abstract class PropertyAccessor {
	/**
	 * @param \ReflectionProperty $refProperty
	 * @return string
	 */
	protected function getCamelCaseMethodName(\ReflectionProperty $refProperty) {
		$methodName = $refProperty->getName();
		$lowerCamelCaseMethodName = preg_replace_callback('/(_[A-Za-z])/', function ($matches) {
				$token = $matches[1];
				$token = ltrim($token, '_');
				$token = strtoupper($token);
				return $token;
			}, $methodName);
		$lowerCamelCaseMethodName = ucfirst($lowerCamelCaseMethodName);
		return $lowerCamelCaseMethodName;
	}
} 