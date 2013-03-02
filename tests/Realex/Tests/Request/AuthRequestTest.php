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
use Realex\Tests\CsvFileIterator;

use Realex\Request\AuthRequest;
use Realex\HttpAdapter\CurlHttpAdapter;
use Realex\HttpAdapter\BuzzHttpAdapter;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class AuthRequestTest extends TestCase
{
    public function testGetName()
    {
        $request  = new AuthRequest($this->getMockAdapter($this->never()));

        $this->assertEquals("auth", $request->getName());

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

    public function testSetGetOrderId()
    {
        $adapter  = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getOrderId());

        $request->setOrderId("ORD-12345");
        $this->assertEquals("ORD-12345", $request->getOrderId());

    }

    /**
     * @depends testSetGetMerchantId
     * @depends testSetGetAccount
     * @depends testSetGetSecret
     * @dataProvider provider
     *
     * @group Online
     */
    public function testAuth($number, $code, $message, $currency, $type)
    {
        $adapters = array(
            new CurlHttpAdapter(),
            new BuzzHttpAdapter(),
        );

        foreach ($adapters as $adapter) {
            $request = new AuthRequest($adapter);

            $result = $request
                ->setMerchantId($_SERVER['MERCHANT_ID'])
                ->setAccount($_SERVER['ACCOUNT'])
                ->setSecret($_SERVER['SECRET'])
                ->setOrderId($request->getTimeStamp() . "-" . mt_rand(1, 999))
                ->setAmount(rand(1, 1000 * pow(10, 2))/ pow(10, 2))
                ->setCurrency($currency)
                ->setCardNumber($number)
                ->setExpiryDate(strftime("%m%y"))
                ->setCvn(str_pad(rand(0, pow(10, 3)-1), 3, '0', STR_PAD_LEFT))
                ->setCardType($type)
                ->setAutoSettle(true)
                ->setCardHolder(substr(md5(rand()), 0, 20))
                ->execute();


            $this->assertNotNull($request->getHash());

            $result = simplexml_load_string($result);

            $this->assertEquals($code, $result->result);
        }
    }

    public function provider()
    {
        if (!isset($_SERVER['AUTH_DATA']) || empty($_SERVER['AUTH_DATA'])) {
            return new \EmptyIterator();
        }

        return new CsvFileIterator($_SERVER['AUTH_DATA']);
    }
}
