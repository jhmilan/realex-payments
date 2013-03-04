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

        $adapter = $this->getMockAdapter($this->never());
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

        $adapter = $this->getMockAdapter($this->never());
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

        $adapter = $this->getMockAdapter($this->never());
        $request  = new MockRequest($adapter);

        $this->assertNull($request->getAccount());

        $request->setAccount($_SERVER['ACCOUNT']);
        $this->assertEquals($_SERVER['ACCOUNT'], $request->getAccount());

    }

    public function testSetGetOrderId()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getOrderId());

        $request->setOrderId("ORD-12345");
        $this->assertEquals("ORD-12345", $request->getOrderId());

    }

    public function testSetGetCurrency()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getCurrency());

        $request->setCurrency("EUR");
        $this->assertEquals("EUR", $request->getCurrency());

    }

    public function testSetGetAmount()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getAmount());

        $request->setAmount(29.87);
        $this->assertEquals(29.87, $request->getAmount());
        $this->assertEquals(2987, $request->getAmount(true));
    }

    public function testSetGetCardNumber()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getCardNumber());

        $request->setCardNumber("4716276512821169");
        $this->assertEquals("4716276512821169", $request->getCardNumber());

    }

    public function testSetGetCvn()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getCvn());

        $request->setCvn("123");
        $this->assertEquals("123", $request->getCvn());

    }

    public function testSetGetExpiryDate()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getExpiryDate());

        $request->setExpiryDate("0714");
        $this->assertEquals("0714", $request->getExpiryDate());

    }

    public function testSetGetCardType()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getCardType());

        $request->setCardType("VISA");
        $this->assertEquals("VISA", $request->getCardType());

    }

    public function testSetGetCardHolder()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $this->assertNull($request->getCardHolder());

        $request->setCardHolder("John Doe");
        $this->assertEquals("John Doe", $request->getCardHolder());

    }

    public function testSetGetAutoSettle()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        // Default TRUE
        $this->assertTrue((bool) $request->getAutoSettle());

        $request->setAutoSettle(FALSE);
        $this->assertFalse((bool) $request->getAutoSettle());

        $this->assertEquals(0, $request->getAutoSettle());

        $request->setAutoSettle(TRUE);
        $this->assertTrue((bool) $request->getAutoSettle());
        $this->assertEquals(1, $request->getAutoSettle());

    }

    public function testGetSetMd5Hash()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $request
            ->setMerchantId("samplemerchant")
            ->setSecret("secret")
            ->setOrderId("ORDER-1")
            ->setAmount(100.76)
            ->setCurrency("EUR")
            ->setCardNumber("4716276512821169");

        // Override the timestamp property so we can validate hashing is correct
        $property = new \ReflectionProperty(
          'Realex\Request\AuthRequest', 'timestamp'
        );
        $property->setAccessible(TRUE);
        $property->setValue($request, "20130304161404");

        // Call the setMd5Hash protected method
        $set_method = new \ReflectionMethod(
          'Realex\Request\AuthRequest', 'setMd5Hash'
        );
        $set_method->setAccessible(TRUE);
        $set_method->invoke($request);

        $get_method = new \ReflectionMethod(
          'Realex\Request\AuthRequest', 'getMd5Hash'
        );
        $get_method->setAccessible(TRUE);

        $this->assertEquals("be53bba574e919e93f2488a89c143239", $get_method->invoke($request));

    }

    public function testGetSetSha1Hash()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $request
            ->setMerchantId("samplemerchant")
            ->setSecret("secret")
            ->setOrderId("ORDER-1")
            ->setAmount(100.76)
            ->setCurrency("EUR")
            ->setCardNumber("4716276512821169");

        // Override the timestamp property so we can validate hashing is correct
        $property = new \ReflectionProperty(
          'Realex\Request\AuthRequest', 'timestamp'
        );
        $property->setAccessible(TRUE);
        $property->setValue($request, "20130304161404");

        // Call the setHash protected method
        $set_method = new \ReflectionMethod(
          'Realex\Request\AuthRequest', 'setSha1Hash'
        );
        $set_method->setAccessible(TRUE);
        $set_method->invoke($request);

        $get_method = new \ReflectionMethod(
          'Realex\Request\AuthRequest', 'getSha1Hash'
        );
        $get_method->setAccessible(TRUE);


        $this->assertEquals("7b4f87f2b6cd1e96ba455ca86703e664b4ebdf45", $get_method->invoke($request));

    }

    public function testGetSetHash()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new AuthRequest($adapter);

        $request
            ->setMerchantId("samplemerchant")
            ->setSecret("secret")
            ->setOrderId("ORDER-1")
            ->setAmount(100.76)
            ->setCurrency("EUR")
            ->setCardNumber("4716276512821169");

        // Override the timestamp property so we can validate hashing is correct
        $property = new \ReflectionProperty(
          'Realex\Request\AuthRequest', 'timestamp'
        );
        $property->setAccessible(TRUE);
        $property->setValue($request, "20130304161404");

        // Call the setHash protected method
        $method = new \ReflectionMethod(
          'Realex\Request\AuthRequest', 'setHash'
        );
        $method->setAccessible(TRUE);

        // MD5
        $request->setHashAlgorithm("MD5");
        $method->invoke($request);
        $this->assertEquals("be53bba574e919e93f2488a89c143239", $request->getHash());

        // SHA1
        $request->setHashAlgorithm("SHA1");
        $method->invoke($request);
        $this->assertEquals("7b4f87f2b6cd1e96ba455ca86703e664b4ebdf45", $request->getHash());

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
