<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

if (!extension_loaded('curl') || !function_exists('curl_init')) {
    die(<<<EOT
The cURL extension must be installed and enabled
EOT
    );
}

if (!($loader = include __DIR__ . '/../vendor/autoload.php')) {
    die(<<<EOT
You need to install the project dependencies using Composer:
wget http://getcomposer.org/composer.phar
OR
curl -s https://getcomposer.org/installer | php

php composer.phar install --dev
phpunit
EOT
    );
}

$loader->add('Realex\Tests', __DIR__);
