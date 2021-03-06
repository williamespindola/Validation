# Between

- `Between(mixed $minimum, mixed $maximum)`
- `Between(mixed $minimum, mixed $maximum, bool $inclusive)`

Validates whether the input is between two other values.

```php
v::intVal()->between(10, 20)->validate(15); // true
```

The type as the first validator in a chain is a good practice,
since between accepts many types:

```php
v::stringType()->between('a', 'f')->validate('c'); // true
```

Also very powerful with dates:

```php
v::dateTime()->between('2009-01-01', '2013-01-01')->validate('2010-01-01'); // true
```

Date ranges accept strtotime values:

```php
v::dateTime()->between('yesterday', 'tomorrow')->validate('now'); // true
```

A third parameter may be passed to validate the passed values inclusive:

```php
v::dateTime()->between(10, 20, true)->validate(20); // true
```

Message template for this validator includes `{{minValue}}` and `{{maxValue}}`.

## Changelog

Version | Description
--------|-------------
  1.0.0 | Became inclusive by default
  0.3.9 | Created

***
See also:

- [Length](Length.md)
- [Min](Min.md)
- [Max](Max.md)
