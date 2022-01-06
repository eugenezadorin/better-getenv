<?php

beforeAll(function () {
	putenv('UPPERCASE_KEY=UPPERCASE_VALUE');
	putenv('MixedCaseKey=MixedValue');
	putenv("STRING_WITH_SINGLE_QUOTES='value'");
	putenv('STRING_WITH_DOUBLE_QUOTES="value"');
	putenv('NUMBER=123');
	putenv('BOOL_TRUE=true');
	putenv('BOOL_FALSE=false');
	putenv('BOOL_TRUTHY=1');
	putenv('NULL_VALUE=null');
	putenv('EMPTY_VALUE=');
	putenv('EMPTY_STRING_VALUE=""');
	putenv('DOTENV_KEY=PUTENV_VALUE');

	$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
});

test('functions exists', function () {
    expect(function_exists('\Zadorin\env'))->toBeTrue();
	expect(function_exists('env'))->toBeTrue();
});

test('case sensitive', function () {
	expect(env('UPPERCASE_KEY'))->toBe('UPPERCASE_VALUE');

	expect(env('Uppercase_KEY'))->toBeNull();

	expect(env('MixedCaseKey'))->toBe('MixedValue');
	expect(env('mixedcasekey'))->toBeNull();

	expect(env('DOTENV_KEY'))->toBe('DOTENV_VALUE');
	expect(env('DOTENV_key'))->toBeNull();
});

test('quoted values', function () {
	expect(env('STRING_WITH_SINGLE_QUOTES'))->toBe('value');
	expect(env('STRING_WITH_DOUBLE_QUOTES'))->toBe('value');
	expect(env('DOTENV_SINGLE_QUOTED'))->toBe('value');
	expect(env('DOTENV_DOUBLE_QUOTED'))->toBe('value');
});

test('numbers returns as strings', function () {
	expect(env('NUMBER'))->toBe('123');
	expect(env('NUMBER'))->not->toBe(123);

	expect(env('DOTENV_NUMBER'))->toBe('321');
	expect(env('DOTENV_NUMBER'))->not->toBe(321);
});

test('boolean values casts properly', function () {
	expect(env('BOOL_TRUE'))->toBeTrue();
	expect(env('BOOL_FALSE'))->toBeFalse();
	expect(env('BOOL_TRUTHY'))->toBe('1');
	expect(env('BOOL_TRUTHY'))->not->toBeTrue();

	expect(env('DOTENV_TRUE'))->toBeTrue();
	expect(env('DOTENV_FALSE'))->toBeFalse();
	expect(env('DOTENV_TRUTHY'))->toBe('1');
	expect(env('DOTENV_TRUTHY'))->not->toBeTrue();
	expect(env('DOTENV_FALSY'))->toBe('0');
	expect(env('DOTENV_FALSY'))->not->toBeFalse();
});

test('nullable values', function () {
	expect(env('NULL_VALUE'))->toBeNull();
	expect(env('EMPTY_VALUE'))->toBe('');
	expect(env('EMPTY_STRING_VALUE'))->toBe('');

	expect(env('DOTENV_NULL'))->toBeNull();
	expect(env('DOTENV_EMPTY'))->toBe('');
	expect(env('DOTENV_EMPTY_STRING'))->toBe('');
});

test('default value', function() {
	$result = env('UNKNOWN_VALUE', 12345);
	expect($result)->toBe(12345);
});

test('default function', function () {
	$expected = 'FOOBAR';
	$result = env('UNKNOWN_VALUE', function() use ($expected) {
		return strtolower($expected);
	});
	expect($result)->toBe('foobar');
});

test('use $_ENV before getenv()', function () {
	expect(env('DOTENV_KEY'))->toBe('DOTENV_VALUE');
});
