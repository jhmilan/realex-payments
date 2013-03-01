<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Tests\HttpAdapter;

use Realex\Tests\TestCase;

use Realex\HttpAdapter\CurlHttpAdapter;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class CurlHttpAdapterTest extends TestCase
{
    protected function setUp()
    {
        if (!function_exists('curl_init')) {
            $this->markTestSkipped('cURL has to be enabled.');
        }
    }

    public function testGetName()
    {
        $curl = new CurlHttpAdapter();
        $this->assertEquals("curl", $curl->getName());
    }
}
