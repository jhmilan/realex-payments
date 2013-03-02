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

use Realex\HttpAdapter\BuzzHttpAdapter;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class BuzzHttpAdapterTest extends TestCase
{
    protected function setUp()
    {
        if (!class_exists('Buzz\Browser')) {
            $this->markTestSkipped('Buzz library has to be installed');
        }
    }

    public function testGetName()
    {
        $adapter = new BuzzHttpAdapter();
        $this->assertEquals("buzz", $adapter->getName());
    }
}
