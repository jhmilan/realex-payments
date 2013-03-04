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
class RebateRequest extends AbstractRequest implements RequestInterface
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
     * @var double
     */
    protected $amount = null;

    /**
     * @var string
     */
    protected $currency = null;

    /**
     * @var bool
     */
    protected $auto_settle = true;

    /**
     * @var string
     */
    protected $refund_password = null;

    /**
     * {@inheritDoc}
     */
    public function getXml()
    {
        $this->setHash();

        $hash = "<{$this->hash_algorithm}hash>{$this->getHash()}</{$this->hash_algorithm}hash>";
        $refundhash = sha1($this->getRefundPassword());

        $xml = <<<XML
<request type='{$this->getName()}' timestamp='{$this->getTimestamp()}'>
    <merchantid>{$this->getMerchantId()}</merchantid>
    <account>{$this->getAccount()}</account>
    <orderid>{$this->getOrderId()}</orderid>
    <pasref>{$this->getPasRef()}</pasref>
    <authcode>{$this->getAuthCode()}</authcode>
    <amount currency='{$this->getCurrency()}'>{$this->getAmount(true)}</amount>
    <refundhash>{$refundhash}</refundhash>
    <autosettle flag='{$this->getAutoSettle()}'/>
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
        return "rebate";
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
                $this->getAmount(true),
                $this->getCurrency(),
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
     * @return RebateRequest
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
     * @return RebateRequest
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
     * @return RebateRequest
     */
    public function setPasRef($pasref)
    {
        $this->pasref = $pasref;

        return $this;
    }

    /**
     * Returns the currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency to be used.
     *
     * @param string $currency
     *
     * @return RebateRequest
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Returns the amount
     *
     * @param bool $smallest_units
     *
     * @return string
     */
    public function getAmount($smallest_units = false)
    {
        if ($smallest_units) {
            return (int) ($this->amount * 100);
        }

        return $this->amount;
    }

    /**
     * Sets the amount to be charged.
     *
     * @param float $amount
     *
     * @return RebateRequest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Returns the auto settle flag
     *
     * @return bool
     */
    public function getAutoSettle()
    {
        return intval($this->auto_settle);
    }

    /**
     * Sets if the auth should be settled automatically
     *
     * @param bool $auto_settle
     *
     * @return RebateRequest
     */
    public function setAutoSettle($auto_settle)
    {
        $this->auto_settle = $auto_settle;

        return $this;
    }

    /**
     * Returns the refund password
     *
     * @return string
     */
    public function getRefundPassword()
    {
        return $this->refund_password;
    }

    /**
     * Sets the refund password to be used.
     *
     * @param string $password
     *
     * @return RebateRequest
     */
    public function setRefundPassword($password)
    {
        $this->refund_password = $password;

        return $this;
    }
}
