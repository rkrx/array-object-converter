<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject\ReflProperty;

abstract class SimpleAccessor {
	/**
	 * @param ReflProperty $property
	 * @return string
	 */
	protected function getCamelCaseMethodName(ReflProperty $property) {
		$methodName = $property->getName();
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