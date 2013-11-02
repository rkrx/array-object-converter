<?php
namespace Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleHandler;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionProperty;

abstract class PropertyAccessor {
	/**
	 * @param ReflectionProperty $refProperty
	 * @return string
	 */
	protected function getCamelCaseMethodName(ReflectionProperty $refProperty) {
		$methodName = $refProperty->getName();
		$lowerCamelCaseMethodName = preg_replace_callback(
			'/(_[A-Za-z])/',
			function ($matches) {
				$token = $matches[1];
				$token = ltrim($token, '_');
				$token = strtoupper($token);
				return $token;
			},
			$methodName
		);
		$lowerCamelCaseMethodName = ucfirst($lowerCamelCaseMethodName);
		return $lowerCamelCaseMethodName;
	}
} 