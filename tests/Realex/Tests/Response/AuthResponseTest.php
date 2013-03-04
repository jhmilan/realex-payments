<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Tests\Response;

use Realex\Tests\TestCase;

use Realex\Response\AuthResponse;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class AuthResponseTest extends TestCase
{
    protected $response;

    private $xml = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<response timestamp="20130304161404">
<merchantid>samplemerchant</merchantid>
<account>internet</account>
<orderid>20130304161548</orderid>
<authcode>161404</authcode>
<result>00</result>
<message>[ test system ] AUTH CODE 161404</message>
<pasref>13624136446768</pasref>
<timetaken>1</timetaken>
<authtimetaken>0</authtimetaken>
<md5hash>67d2831499516df470f03071d97b8dbf</md5hash>
</response>
XML;

    protected function setUp()
    {
        $this->response = new AuthResponse("secret", $this->xml);
    }

    public function testGetName()
    {
        $this->assertEquals("auth", $this->response->getName());
    }

    public function testGetMerchantId()
    {
        $this->assertEquals("samplemerchant", $this->response->getMerchantId());
    }

    public function testGetAccount()
    {
        $this->assertEquals("internet", $this->response->getAccount());
    }

    public function testGetMessage()
    {
        $this->assertEquals("[ test system ] AUTH CODE 161404", $this->response->getMessage());
    }

    public function testGetResult()
    {
        $this->assertEquals("00", $this->response->getResult());
    }

    public function testGetHash()
    {
        $this->assertEquals("67d2831499516df470f03071d97b8dbf", $this->response->getHash());
    }

    public function testGetAuthCode()
    {
        $this->assertEquals("161404", $this->response->getAuthCode());
    }

    public function testGetPasRef()
    {
        $this->assertEquals("13624136446768", $this->response->getPasRef());
    }

    public function testGetOrderId()
    {
        $this->assertEquals("20130304161548", $this->response->getOrderId());
    }

    public function testValidate()
    {
        $method = new \ReflectionMethod(
          'Realex\Response\AuthResponse', 'validate'
        );

        $method->setAccessible(TRUE);

        $this->assertTrue($method->invoke($this->response));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testParseResult()
    {
        $method = new \ReflectionMethod(
          'Realex\Response\AuthResponse', 'parseResult'
        );

        $method->setAccessible(TRUE);

        $method->invoke($this->response, null);
    }

}
