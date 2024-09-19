<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://banners.beyondco.de/Laravel%20Extended.png?theme=dark&packageManager=composer+require&packageName=onursimsek%2Flaravel-extended&pattern=topography&style=style_1&description=Extend+your+Laravel+project+with+mixins+and+mores&md=1&showWatermark=0&fontSize=100px&images=arrows-expand">
  <source media="(prefers-color-scheme: light)" srcset="https://banners.beyondco.de/Laravel%20Extended.png?theme=light&packageManager=composer+require&packageName=onursimsek%2Flaravel-extended&pattern=topography&style=style_1&description=Extend+your+Laravel+project+with+mixins+and+mores&md=1&showWatermark=0&fontSize=100px&images=arrows-expand">
  <img alt="Package Image" src="https://banners.beyondco.de/Precondition.png?theme=dark&packageManager=composer+require&packageName=onursimsek%2Fprecondition&pattern=topography&style=style_2&description=HTTP+Precondition+for+Laravel&md=1&showWatermark=1&fontSize=125px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg">
</picture>

# Extend your Laravel project with mixins and mores

[![Latest Version on Packagist](https://img.shields.io/packagist/v/onursimsek/laravel-extended.svg?style=flat-square)](https://packagist.org/packages/onursimsek/laravel-extended)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/onursimsek/laravel-extended/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/onursimsek/laravel-extended/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Tests](https://github.com/onursimsek/laravel-extended/actions/workflows/run-tests.yml/badge.svg)](https://github.com/onursimsek/laravel-extended/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/onursimsek/laravel-extended.svg?style=flat-square)](https://packagist.org/packages/onursimsek/)

## Installation

You can install the package via composer:

```bash
composer require onursimsek/laravel-extended
```

## Contents

- [Illuminate\Database\Query\Builder](#extended-illuminatedatabasequerybuilder)
- [Illuminate\Support\Str](#extended-illuminatesupportstr)
- [Illuminate\Support\Stringable](#extended-illuminatesupportstringable)
- [Useful Traits](#useful-traits)
  - [InteractsWithDatabase](#interactswithdatabase)
    - [beginTransaction](#begintransactionstring-connections-void)
    - [commit](#commitstring-connections-void)
    - [commitAll](#commitall-void)
    - [rollBack](#rollbackstring-connections-void)
    - [rollBack](#rollbackall-void)
    - [Example](#interactswithdatabase-example)
  - [HasName](#hasname)
    - [names](#names)
  - [HasValue](#hasvalue)
    - [value](#values-and-names)

## Usage

### Extended Illuminate\Database\Query\Builder

```php
Product::whereGreaterThan('price', 500)->get();
// select * from products where price > 500
Product::whereGreaterThanOrEqual('price', 500)->get();
// select * from products where price >= 500

Product::whereLessThan('price', 500)->get();
// select * from products where price < 500
Product::whereLessThanOrEqual('price', 500)->get();
// select * from products where price <= 500

Product::whereColumnGreaterThan('price', 'amount')->get();
// select * from products where price > amount
Product::whereColumnGreaterThanOrEqual('price', 'amount')->get();
// select * from products where price >= amount

Product::whereColumnLessThan('price', 'amount')->get();
// select * from products where price < amount
Product::whereColumnLessThanOrEqual('price', 'amount')->get();
// select * from products where price <= amount

Product::whenWhere(false, 'is_active')->get();
// select * from products
Product::whenWhere(true, 'is_active')->get();
// select * from products where is_active = 1
```

### Extended Illuminate\Support\Str

```php
use Illuminate\Support\Str;

Str::squishBetween("I\twill kiss\t\nyou!", 'kiss', 'you');
// I       will kiss you!
Str::replaceBetween('I will kiss you!', 'will', 'you', 'miss');
// I will miss you!
Str::replaceBetweenMatch('I will kiss you!', 'will', 'you', '/k(.*)s/', 'hug');
// I will hug you!
```

### Extended Illuminate\Support\Stringable

```php
use Illuminate\Support\Str;

Str::of("I\twill kiss\t\nyou!")->squishBetween('kiss', 'you');
// I       will kiss you!
Str::of('I will kiss you!')->replaceBetween('will', 'you', 'miss');
// I will miss you!
Str::of('I will kiss you!')->replaceBetweenMatch('will', 'you', '/k(.*)s/', 'hug');
// I will hug you!
```

## Useful Traits

### InteractsWithDatabase

This trait provides an easy way to manage database transactions across multiple connections. It allows you to **begin**,
**commit**, and **roll back** transactions.

#### beginTransaction(string ...$connections): void

This method starts a transaction on the specified database connections. If no connections are provided, the default
database connection specified in your Laravel configuration will be used.

```php
$this->beginTransaction(); // Starts transaction on default connection
$this->beginTransaction('mysql', 'sqlite'); // Starts transactions on the 'mysql' and 'sqlite' connections
```

#### commit(string ...$connections): void

This method commits a transaction on the specified connections. If no connections are specified, nothing will happen.

```php
$this->commit(); // No action taken (no specific connection provided)
$this->commit('mysql', 'sqlite'); // Commits the transactions on the 'mysql' and 'sqlite' connections
```

#### commitAll(): void
This method commits transactions on all connections that have begun a transaction during the lifetime of the object.

```php
$this->commitAll(); // Commits all active transactions
```

#### rollBack(string ...$connections): void
This method rolls back a transaction on the specified connections.

```php
$this->rollBack(); // Rolls back on the default connection
$this->rollBack('mysql', 'sqlite'); // Rolls back on the 'mysql' and 'sqlite' connections
```

#### rollBackAll(): void
This method rolls back transactions on all connections that have begun a transaction during the lifetime of the object.

```php
$this->rollBackAll(); // Rolls back all active transactions
```

#### InteractsWithDatabase Example

```php
namespace App\Http\Controllers\Controller;

use OnurSimsek\LaravelExtended\Support\InteractsWithDatabase;

class Controller
{
    use InteractsWithDatabase;
    
    public function store()
    {
        $this->beginTransaction('mysql', 'pgsql');

        try {
            // Your data processing logic

            $this->commitAll(); // Commit the transactions if everything goes well
        } catch (\Exception $e) {
            $this->rollBackAll(); // Roll back if an error occurs
            throw $e;
        }
    }
}
```

### HasName

This trait converts the **names** of _UnitEnum_ into an array.

#### names()

```php
enum Status 
{
    use HasName;

    case Active;
    case Inactive;
}

Status::names(); // ['Active', 'Inactive']
```

### HasValue

#### values() and names()

This trait converts the **names** and **values** of _BackedEnum_ into an array

```php
enum Status: string
{
    use HasValue;

    case Active = 'active';
    case Inactive = 'inactive';
}

Status::names();  // ['Active', 'Inactive']
Status::values(); // ['active', 'inactive']
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Onur Şimşek](https://github.com/onursimsek)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
