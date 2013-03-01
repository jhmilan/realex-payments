Realex
======

**Realex** is a library to use [Realex Payments][1] payment service via their API.
Developer documentation for the Realex API can be found [here][2].

[![Build Status](https://secure.travis-ci.org/shaneog/Realex.png)](http://travis-ci.org/shaneog/Realex)


### Installation

The recommended way to install Realex is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "sog/realex": "*"
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
- Add valiators for the AUTH fields
- Add further HttpAdapters (e.g. Buzz)
- Add support for AUTH comments
- Add support for TSSinfo fields
- Add VOID request
- Add REBATE request
- Add REFUND request
- Add proper Response parsing, for each request type
