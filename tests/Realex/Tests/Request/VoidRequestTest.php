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

use Realex\Request\VoidRequest;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class VoidRequestTest extends TestCase
{
    public function testGetName()
    {
        $request  = new VoidRequest($this->getMockAdapter($this->never()));

        $this->assertEquals("void", $request->getName());

    }

    public function testValidate()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        // Call the setHash protected method
        $method = new \ReflectionMethod(
          'Realex\Request\VoidRequest', 'validate'
        );
        $method->setAccessible(TRUE);
        $method->invoke($request);

        $this->assertTrue($method->invoke($request));

    }

    public function testGetHashFields()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        // Call the setHash protected method
        $method = new \ReflectionMethod(
          'Realex\Request\VoidRequest', 'getHashFields'
        );
        $method->setAccessible(TRUE);
        $method->invoke($request);

        $this->assertNotNull($method->invoke($request));

        $request
            ->setMerchantId("samplemerchant")
            ->setAccount("internet")
            ->setOrderId("ORD-12345")
            ->setPasRef("13624136446768")
            ->setAuthCode("123456");

        $this->assertStringEndsWith(".samplemerchant.ORD-12345...", $method->invoke($request));

    }

    public function testGetXml()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        $timestamp = strftime("%Y%m%d%H%M%S");

        // Call the setHash protected method
        $method = new \ReflectionMethod(
          'Realex\Request\VoidRequest', 'getXml'
        );
        $method->setAccessible(TRUE);
        $method->invoke($request);

        $this->assertNotNull($method->invoke($request));

        $request
            ->setMerchantId("samplemerchant")
            ->setAccount("internet")
            ->setOrderId("ORD-12345")
            ->setPasRef("13624136446768")
            ->setAuthCode("123456");

        // Override the timestamp property so we can validate hashing is correct
        $property = new \ReflectionProperty(
          'Realex\Request\VoidRequest', 'timestamp'
        );
        $property->setAccessible(TRUE);
        $property->setValue($request, "20130304161404");

        $xml = <<<XML
<request type='void' timestamp='20130304161404'>
    <merchantid>samplemerchant</merchantid>
    <account>internet</account>
    <orderid>ORD-12345</orderid>
    <pasref>13624136446768</pasref>
    <authcode>123456</authcode>
    <md5hash>73c5489728f864fa4f5e0c7ea957c403</md5hash>
</request>
XML;
        $this->assertEquals($xml, $method->invoke($request));

    }

    public function testGetSetAuthCode()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        $this->assertNull($request->getAuthCode());
        $request->setAuthCode("123456");
        $this->assertEquals("123456", $request->getAuthCode());

    }

    public function testGetSetOrderId()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        $this->assertNull($request->getOrderId());
        $request->setOrderId("ORD123456");
        $this->assertEquals("ORD123456", $request->getOrderId());

    }

    public function testGetSetPasRef()
    {
        $adapter = $this->getMockAdapter($this->never());
        $request = new VoidRequest($adapter);

        $this->assertNull($request->getPasRef());
        $request->setPasRef("13624136446768");
        $this->assertEquals("13624136446768", $request->getPasRef());

    }

}
