<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Tests;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return HttpAdapterInterface
     */
    protected function getMockAdapter($expects = null)
    {
        if (null === $expects) {
            $expects = $this->once();
        }

        $mock = $this->getMock('\Realex\HttpAdapter\HttpAdapterInterface');
        $mock
            ->expects($expects)
            ->method('postRequest')
            ->will($this->returnArgument(0));

        return $mock;
    }
}
