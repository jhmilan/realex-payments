<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Request;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class VoidRequest extends AbstractRequest implements RequestInterface
{
    /**
     * @var string
     */
    protected $order_id = null;

    /**
     * @var string
     */
    protected $authcode = null;

    /**
     * @var string
     */
    protected $pasref = null;

    /**
     * {@inheritDoc}
     */
    public function getXml()
    {
        $this->setHash();

        $hash = "<{$this->hash_algorithm}hash>{$this->getHash()}</{$this->hash_algorithm}hash>";

        $xml = <<<XML
<request type='{$this->getName()}' timestamp='{$this->getTimestamp()}'>
    <merchantid>{$this->getMerchantId()}</merchantid>
    <account>{$this->getAccount()}</account>
    <orderid>{$this->getOrderId()}</orderid>
    <pasref>{$this->getPasRef()}</pasref>
    <authcode>{$this->getAuthCode()}</authcode>
    {$hash}
</request>
XML;

        return $xml;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return "void";
    }

        /**
     * {@inheritDoc}
     */
    protected function getHashFields()
    {
        return implode(
            ".",
            array(
                $this->getTimestamp(),
                $this->getMerchantId(),
                $this->getOrderId(),
                "",
                "",
                ""
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function validate()
    {
        // @todo: Validation logic
        return true;
    }

    /**
     * Returns the order ID
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Sets the order ID to be used.
     *
     * @param string $order_id
     *
     * @return VoidRequest
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Sets the Auth Code
     *
     * @param string $authcode
     *
     * @return VoidRequest
     */
    public function setAuthCode($authcode)
    {
        $this->authcode = $authcode;

        return $this;
    }

    /**
     * Returns the Auth Code
     *
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authcode;
    }

    /**
     * Returns the PasRef
     *
     * @return string
     */
    public function getPasRef()
    {
        return $this->pasref;
    }

    /**
     * Sets the PasRef to be used.
     *
     * @param string $pasref
     *
     * @return VoidRequest
     */
    public function setPasRef($pasref)
    {
        $this->pasref = $pasref;

        return $this;
    }
}
