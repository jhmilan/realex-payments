Square1 Realex
======

This is a fork from [https://github.com/shaneog/realex-payments](https://github.com/shaneog/realex-payments)

======

**Realex** is a library to use [Realex Payments][1] payment service via their API.
Developer documentation for the Realex API can be found [here][2].

[![Build Status](https://travis-ci.org/shaneog/realex-payments.png?branch=master)](https://travis-ci.org/shaneog/realex-payments)


### Installation

The recommended way to install Realex is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "shaneog/realex": "*"
    }
}
```

And run these two commands to install it:

``` bash
wget http://getcomposer.org/composer.phar
php composer.phar install
```

[1]: http://www.realexpayments.com
[2]: https://resourcecentre.realexpayments.com


### TODO

- Use the Symfony CardSchemeValidator to validate that the card is valid for the credit cards accepted
- Remove the need to manually specify the card type.
- Add validators for the AUTH fields
- ~~Add further HttpAdapters (e.g. Buzz)~~
- Add support for AUTH comments
- Add support for TSSinfo fields
- ~~Add VOID request~~
- Add VOID response
- ~~Add REBATE request~~
- Add REBATE response
- Add proper response parsing, for each request type
