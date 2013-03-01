<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Tests\Request;

use Realex\Tests\TestCase;
use Realex\Tests\Request\MockRequest;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class AbstractRequestTest extends TestCase
{
    public function testSetGetAdapter()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $adapter2 = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertSame($adapter, $request->getAdapter());

        $request->setAdapter($adapter2);
        $this->assertSame($adapter2, $request->getAdapter());
    }

    public function testSetGetMerchantId()
    {
        if (!isset($_SERVER['MERCHANT_ID'])) {
            $this->markTestSkipped('You need to configure the MERCHANT_ID value in phpunit.xml');
        }

        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertNull($request->getMerchantId());

        $request->setMerchantId($_SERVER['MERCHANT_ID']);
        $this->assertEquals($_SERVER['MERCHANT_ID'], $request->getMerchantId());

    }

    public function testSetGetSecret()
    {
        if (!isset($_SERVER['SECRET'])) {
            $this->markTestSkipped('You need to configure the SECRET value in phpunit.xml');
        }

        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertNull($request->getSecret());

        $request->setSecret($_SERVER['SECRET']);
        $this->assertEquals($_SERVER['SECRET'], $request->getSecret());

    }

    public function testSetGetAccount()
    {
        if (!isset($_SERVER['ACCOUNT'])) {
            $this->markTestSkipped('You need to configure the ACCOUNT value in phpunit.xml');
        }

        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertNull($request->getAccount());

        $request->setAccount($_SERVER['ACCOUNT']);
        $this->assertEquals($_SERVER['ACCOUNT'], $request->getAccount());

    }

    public function testGetTimestamp()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $timestamp = strftime("%Y%m%d%H%M%S");

        $this->assertNotNull($request->getTimestamp());
        $this->assertEquals($timestamp, $request->getTimestamp());

    }

    public function testGetTimeTaken()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertNotNull($request->getTimeTaken());
        $this->assertGreaterThanOrEqual(0, $request->getTimeTaken());

    }

    public function testSetGetHashAlgorithm()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        // Defaults to md5
        $this->assertEquals("md5", $request->getHashAlgorithm());

        $request->setHashAlgorithm("sha1");
        $this->assertEquals("sha1", $request->getHashAlgorithm());

    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetHashAlgorithm()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $request->setHashAlgorithm("MD6");

    }
}
