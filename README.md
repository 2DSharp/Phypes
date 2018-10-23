# Phypes
[![Build Status](https://scrutinizer-ci.com/g/2DSharp/Phypes/badges/build.png?b=master)](https://scrutinizer-ci.com/g/2DSharp/Phypes/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/2DSharp/Phypes/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/2DSharp/Phypes/?branch=master)

A Value Objects library with type validation for PHP.

## Introduction
Phypes is a fully extensible value objects library with commonly used types that allows for
user input validation and data storage.

Phypes has 2 main components:
- **Types**
- **Validators**

A type is an immutable object created from user input and passed on to the services in the 
business layer to store/manipulate/use the data.
A validator checks the input of each type and throws an `InvalidArgumentException` upon
validation failure along with the error message and code describing the error.

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

Or maybe inject your own validator.
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
        return strlen($password) >= 10 ;
    }
    public function isValid($password, $options = []): bool
    {
        $this->validated = true;

        if (!$this->isLongEnough($password)) {
            $this->errorCode = Error::PASSWORD_TOO_SMALL;
            $this->error = 'The password is not at least 8 characters long';
            return false;
        }
    }
    
    public function getErrorMessage() : ?string
    {
      return $this->error;
    }
    
    public function getErrorCode() : ?int
    {
      return $this->errorCode;
    }
  }
  ```

Or by extending the `AbstractValidator`, which requires the `validated` protected 
variable to be set on calling is valid to disallow calling `getMessage()` without validating first:

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
        return strlen($password) >= 10 ;
    }
    public function isValid($password, $options = []): bool
    {
        $this->validated = true;

        if (!$this->isLongEnough($password)) {
            $this->errorCode = Error::PASSWORD_TOO_SMALL;
            $this->error = 'The password is not at least 8 characters long';
            return false;
        }

        $this->error = $this->errorCode = null;
        return true;
    }
  }
  ```
  which doesn't require an implementation of `getErrorMessage()` which is already done in the parent class.
  
  And then simply switch in the custom validator in the type.
  ```php
  $pass = new Password($_POST['password'], new CustomPasswordValidator());
  ```
  That's it. The password will be verified based on your validation rules.
  
  Any new types can be created by simply implementing the `Type` interface and adding a validator. A set of
  standard validators have already been provided with the library which will suffice for a lot of use cases.
  
  
A list of error standard codes can be found in the `Error` abstract class. They can be used to determine the
kind of errors returned during the validation and the application can spit out custom validation errors without
having to rely on the generic error messages defined in the library.
