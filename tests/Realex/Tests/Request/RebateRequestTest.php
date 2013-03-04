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

use Realex\Request\RebateRequest;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class RebateRequestTest extends TestCase
{
    public function testGetName()
    {
        $request  = new RebateRequest($this->getMockAdapter($this->never()));

        $this->assertEquals("rebate", $request->getName());

    }

    public function testValidate()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        // Call the setHash protected method
        $method = new \ReflectionMethod(
            'Realex\Request\RebateRequest',
            'validate'
        );
        $method->setAccessible(true);
        $method->invoke($request);

        $this->assertTrue($method->invoke($request));

    }

    public function testGetHashFields()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        // Call the setHash protected method
        $method = new \ReflectionMethod(
            'Realex\Request\RebateRequest',
            'getHashFields'
        );
        $method->setAccessible(true);
        $method->invoke($request);

        $this->assertNotNull($method->invoke($request));

        $request
            ->setMerchantId("samplemerchant")
            ->setAccount("internet")
            ->setOrderId("ORD-12345")
            ->setPasRef("13624136446768")
            ->setAuthCode("123456")
            ->setAmount("12.50")
            ->setCurrency("EUR");

        $this->assertStringEndsWith(".samplemerchant.ORD-12345.1250.EUR.", $method->invoke($request));

    }

    public function testGetXml()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $timestamp = strftime("%Y%m%d%H%M%S");

        // Call the setHash protected method
        $method = new \ReflectionMethod(
            'Realex\Request\RebateRequest',
            'getXml'
        );
        $method->setAccessible(true);
        $method->invoke($request);

        $this->assertNotNull($method->invoke($request));

        $request
            ->setMerchantId("samplemerchant")
            ->setAccount("internet")
            ->setOrderId("ORD-12345")
            ->setPasRef("13624136446768")
            ->setAuthCode("123456")
            ->setAmount("12.50")
            ->setCurrency("EUR")
            ->setAutoSettle(true)
            ->setRefundPassword("testpass");

        // Override the timestamp property so we can validate hashing is correct
        $property = new \ReflectionProperty(
            'Realex\Request\RebateRequest',
            'timestamp'
        );
        $property->setAccessible(true);
        $property->setValue($request, "20130304161404");

        $xml = <<<XML
<request type='rebate' timestamp='20130304161404'>
    <merchantid>samplemerchant</merchantid>
    <account>internet</account>
    <orderid>ORD-12345</orderid>
    <pasref>13624136446768</pasref>
    <authcode>123456</authcode>
    <amount currency='EUR'>1250</amount>
    <refundhash>206c80413b9a96c1312cc346b7d2517b84463edd</refundhash>
    <autosettle flag='1'/>
    <md5hash>3ed6955803d83c4c4ab159b3575a79b9</md5hash>
</request>
XML;
        $this->assertEquals($xml, $method->invoke($request));

    }

    public function testGetSetAuthCode()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getAuthCode());
        $request->setAuthCode("123456");
        $this->assertEquals("123456", $request->getAuthCode());

    }

    public function testGetSetOrderId()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getOrderId());
        $request->setOrderId("ORD123456");
        $this->assertEquals("ORD123456", $request->getOrderId());

    }

    public function testGetSetPasRef()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getPasRef());
        $request->setPasRef("13624136446768");
        $this->assertEquals("13624136446768", $request->getPasRef());
    }

    public function testGetSetCurrency()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getCurrency());
        $request->setCurrency("EUR");
        $this->assertEquals("EUR", $request->getCurrency());
    }

    public function testGetSetAmount()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getAmount());
        $request->setAmount(12.50);
        $this->assertEquals(12.50, $request->getAmount());
        $this->assertEquals("1250", $request->getAmount(true));
    }

    public function testGetSetRefundPassword()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        $this->assertNull($request->getRefundPassword());
        $request->setRefundPassword("testpass");
        $this->assertEquals("testpass", $request->getRefundPassword());
    }

    public function testSetGetAutoSettle()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new RebateRequest($adapter);

        // Default true
        $this->assertTrue((bool) $request->getAutoSettle());

        $request->setAutoSettle(false);
        $this->assertFalse((bool) $request->getAutoSettle());

        $this->assertEquals(0, $request->getAutoSettle());

        $request->setAutoSettle(true);
        $this->assertTrue((bool) $request->getAutoSettle());
        $this->assertEquals(1, $request->getAutoSettle());

    }
}
