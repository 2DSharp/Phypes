# Phypes
[![Build Status](https://scrutinizer-ci.com/g/2DSharp/Phypes/badges/build.png?b=master)](https://scrutinizer-ci.com/g/2DSharp/Phypes/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/2DSharp/Phypes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/2DSharp/Phypes/?branch=master)

A Value Objects library with type validation for PHP.

## Introduction
Phypes is a fully extensible value objects library with commonly used types that allows for
user input validation and data storage.

Phypes has 3 components:
- **Types**
- **Validators**
- **Rules**

A type is an immutable object created from user input and passed on to the services in the 
business layer to store/manipulate/use the data.

A validator checks the input of each type and throws an `InvalidArgumentException` upon
validation failure along with the error message and code describing the error.

A validator is further assisted using "Rules". Rules are helper classes which do validation
at an atomic level. Raw data with very simple specifications are processed and validated, for 
example: You might want to check if the length of a supplied string is more than your limit.
A combination of rules define a validator.

A standard set of data types with validators have been provided in the library. For custom 
validation, user-defined validators can easily be supplied as an argument to the Type.

## Installation
The recommended way to install Phypes is through [composer](https://getcomposer.org/):
```
composer require twodee/phypes
```
To get the latest version from github:

```
git clone git://github.com/2DSharp/phypes.git
```


## Usage

Create entity classes requiring the types as dependencies:

**User.php**
```php
class User
{
  private $email;
  private $password;
  
  public function __construct(Email $email, Password $password) {
    $this->email = $email;
    $this->password = $password;
  }
  
  public function getEmail() {
    return $this->email;
  }
  
  public function getPassword() {
    //hash at this point maybe?
    return $this->password;
  }
}
```
Retrieve the data from the browser and store it in their correct types:

**SignUpController.php**
```php
try {
  // Get the user data
  $email = new Email($_POST['email']);
  $pass = new Password($_POST['password']);
  
  // Create a new user account based on the data
  $user = new User($email, $password);
  
  // Update the user database
  $userMapper = new UserMapper();
  $userMapper->register($user);

} catch(\InvalidArgumentException $e) {
  $this->displayError($e->getMessage());
}
```

If you do not like our validator implementations, you don't have to use them!
You can plug in your own validators with custom rules, and Phypes will do the rest
for you.

There are two ways to specify a validator.

Either by implementing the `Validator` interface and putting in the custom validation rules:

**CustomPasswordValidator.php**
```php
<?php
declare(strict_types=1);

namespace Sample\Foo;

use Phypes\Validator\Validator;
use Phypes\Validator\Error;

class CustomPasswordValidator implements Validator
{
    private $error;
    private $errorCode;
    
    private function isLongEnough(string $password) : bool
    {
        return (new MinimumLength($minSize))->validate($password)->isValid();
    }
    public function validate($password, $options = []): Result
    {
        $this->validated = true;

        if (!$this->isLongEnough($password)) {
            $error = new TypeError(TypeErrorCode::PASSWORD_TOO_SMALL,
                'The password is not at least 8 characters long');

            return new Result(false, $error);
        }
    }
  }
  ```

Or by extending the `AbstractValidator`, which allows you to use the `failure()` and `success()` methods:

**CustomPasswordValidator.php**
```php
<?php
declare(strict_types=1);

namespace Sample\Foo;


use Phypes\Validator\AbstractValidator;
use Phypes\Validator\Error;

class CustomPasswordValidator extends AbstractValidator
{
    private function isLongEnough(string $password) : bool
    {
        return (new MinimumLength($minSize))->validate($password)->isValid();
    }
    public function validate($password, $options = []): Result
    {
        $error = new TypeError(TypeErrorCode::PASSWORD_TOO_SMALL,
                'The password is not at least 8 characters long');
        return $this->failure($error);
    }
  }
  ```

A validator and a rule always return a **Result** after validation.
You can find out if it has been successful or not using `Result::isValid()`.

If the validation failed, you can grab the errors using `Result::getErrors()`
or `Result::getFirstError()`.

And then simply switch in the custom validator in the type.
  ```php
  $pass = new Password($_POST['password'], new CustomPasswordValidator());
  ```
  That's it. The password will be verified based on your validation rules.
  
  Any new types can be created by simply implementing the `Type` interface and adding a validator. A set of
  standard validators have already been provided with the library which will suffice for a lot of use cases.
  
  
A list of error standard codes can be found in the `TypeErrorCode` and `RuleErrorCode` abstract classes. They can be used to determine the
kind of errors returned during the validation and the application can spit out custom validation errors without
having to rely on the generic error messages defined in the library.
