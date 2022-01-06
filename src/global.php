<?php
declare(strict_types=1);

if (!function_exists('env'))
{
	/**
	 * Gets the value of an environment variable.
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	function env(string $key, $default = null)
	{
		return \Zadorin\env($key, $default);
	}
}
