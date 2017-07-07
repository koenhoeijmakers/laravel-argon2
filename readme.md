# Argon2 Laravel
A drop-in Argon2(i) implementation for Laravel. (which will be usable from `php 7.2`)

As the [RFC](https://wiki.php.net/rfc/argon2_password_hash) states, the Argon2d variant will not be implemented into php, and therefore we can call our package Argon2 as an alias to Argon2i.

## Disclaimer
Please be careful while exchanging the hashing service providers, if your application is already up and running it is probably a bad idea, as this replaces the standard `bcrypt` functionality from your laravel installation (as it replaces it with Argon2)


## Installation

Require the package.
```php
composer require koenhoeijmakers/argon2-laravel
```

Search inside the `config/app.php` for the `Illuminate\Hashing\HashServiceProvider::class` and replace it with the `KoenHoeijmakers\Argon2Laravel\HashServiceProvider::class`.

```php
'providers' => [
    //...
    
    //Illuminate\Hashing\HashServiceProvider::class,
    KoenHoeijmakers\Argon2Laravel\HashServiceProvider::class,
    
    //...
],
```

## Usage

If you have replaced your HashServiceProvider with the provider delivered by this package, you may now use the laravel hash functionality the same way as you used to.

### Credits
* [Argon2](https://github.com/P-H-C/phc-winner-argon2)
* [PHC](https://password-hashing.net/)
* [@koenvdheuvel](https://github.com/koenvdheuvel)
