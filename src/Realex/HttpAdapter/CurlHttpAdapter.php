<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\HttpAdapter;

use Realex\Realex;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class CurlHttpAdapter implements HttpAdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function postRequest($content)
    {
        if (!function_exists('curl_init')) {
            throw new Exception('cURL has to be enabled.');
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, Realex::getEndpoint());
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_USERAGENT, Realex::getUserAgent());
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $content);

        $response = curl_exec($c);
        curl_close($c);

        if (false === $response) {
            $response = null;
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'curl';
    }
}
