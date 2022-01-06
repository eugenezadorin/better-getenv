# Better getenv()

Package provides framework-agnostic helper `env($key, $default)` to retrieve environment variables in convenient way.

Highly inspired by Laravel env helper.

## Installation

    composer require zadorin/better-getenv

## Usage

```php
$varName = 'APP_ENV';
$defaultValue = 'prod';

$value = env($varName, $defaultValue);
```

Second parameter can be function. In that case helper will use result of this function as default value:

```php
$value = env('CACHE_STORAGE', function () {
    return env('APP_ENV', 'prod') === 'prod' ? 'redis' : 'file';
});
```

## Usage Notes

Helper will search variable in `$_ENV` first, using `getenv()` as fallback.

If `env()` function already exists in your codebase, you can use namespaced call with same signature:

```php
$value = Zadorin\env('APP_ENV', 'prod');
```

Helper automatically casts string values `'true', 'false'` to boolean type. Also `'null'` string casts to null.

## Tests

    ./vendor/bin/pest