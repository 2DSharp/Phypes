# Phypes
A Value Objects library with type validation for PHP.

## Usage
Multiple rules at once.
```php
use GreenTea\Phypes\Validator\Validator
use GreenTea\Phypes\Type\Email;
use GreenTea\Phypes\Type\Numeric;

$validator = new Validator([
    new Email('test@test.com'),
    new Numeric(3.14)
]);
if ($validator->validate()) {
    echo "Validated!";
} else {
    // validation failed.
    print_r($validator->errors());
}
```

Single rule validation.
```php
use GreenTea\Phypes\Validator\Validator
use GreenTea\Phypes\Type\Email;

$validator = new Validator(new Email('test@test.com'));
if ($validator->validate()) {
    echo "Validated!";
} else {
    // validation failed.
    print_r($validator->errors());
}
```

## Invalid output format
When validation fails the `$validator->errors()` result will be an array in the following format, one entry for each failure:
```php
array(1) {
  [0] =>
  array(3) {
    'type' =>
    string(5) "email"
    'error' =>
    string(53) "The provided email address (test@test) was not valid."
    'value' =>
    string(9) "test@test"
  }
}
```