<?php
declare(strict_types=1);

namespace Zadorin
{
	/**
	 * Gets the value of an environment variable.
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	function env(string $key, $default = null)
	{
		$defaultValue = fn() => $default instanceof \Closure ? $default() : $default;

		if (\array_key_exists($key, $_ENV)) {
			$value = $_ENV[$key];
			if (!isset($value)) {
				return $defaultValue();
			}
		} else {
			$value = \getenv($key);
			if ($value === false) {
				return $defaultValue();
			}
		}

		switch (\strtolower($value)) {
			case 'true':
			case '(true)':
				return true;
			case 'false':
			case '(false)':
				return false;
			case 'null':
			case '(null)':
				return null;
		}

		if (\preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
			return $matches[2];
		}

		return $value;
	}
}
