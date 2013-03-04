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
class AuthRequest extends AbstractRequest implements RequestInterface
{
    /**
     * @var string
     */
    protected $order_id = null;

    /**
     * @var string
     */
    protected $currency = null;

    /**
     * @var float
     */
    protected $amount = null;

    /**
     * @var string
     */
    protected $card_number = null;

    /**
     * @var string
     */
    protected $expiry = null;

    /**
     * @var string
     */
    protected $cvn = null;

    /**
     * @var string
     */
    protected $card_type = null;

    /**
     * @var string
     */
    protected $card_holder = null;

    /**
     * @var bool
     */
    protected $auto_settle = true;

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
    <amount currency='{$this->getCurrency()}'>{$this->getAmount(true)}</amount>
    <card>
        <number>{$this->getCardNumber()}</number>
        <expdate>{$this->getExpiryDate()}</expdate>
        <type>{$this->getCardType()}</type>
        <chname>{$this->getCardHolder()}</chname>
    </card>
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
        return "auth";
    }

    /**
     * {@inheritDoc}
     */
    protected function setMd5Hash()
    {
        $fields = md5($this->getHashFields());

        $this->md5hash = md5("$fields.{$this->getSecret()}");

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function setSha1Hash()
    {
        $fields = sha1($this->getHashFields());

        $this->sha1hash = sha1("$fields.{$this->getSecret()}");

        return $this;
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
     * @return AuthRequest
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

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
     * @return AuthRequest
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
     * @return AuthRequest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Returns the card number
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * Sets the card number to be used.
     *
     * @param string $card_number
     *
     * @return AuthRequest
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;

        return $this;
    }

    /**
     * Returns the expiry date
     *
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiry;
    }

    /**
     * Sets the expiry date to be used.
     *
     * @param string $expiry
     *
     * @return AuthRequest
     */
    public function setExpiryDate($expiry)
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * Returns the CVN
     *
     * @return string
     */
    public function getCvn()
    {
        return $this->order_id;
    }

    /**
     * Sets the CVN to be used.
     *
     * @param string $cvn
     *
     * @return AuthRequest
     */
    public function setCvn($cvn)
    {
        $this->cvn = $cvn;

        return $this;
    }

    /**
     * Returns the card type
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * Sets the card type to be used.
     *
     * @param string $card_type
     *
     * @return AuthRequest
     */
    public function setCardType($card_type)
    {
        $this->card_type = $card_type;

        return $this;
    }

    /**
     * Returns the card holder name
     *
     * @return string
     */
    public function getCardHolder()
    {
        return $this->card_holder;
    }

    /**
     * Sets the card holder name to be used.
     *
     * @param string $card_holder
     *
     * @return AuthRequest
     */
    public function setCardHolder($card_holder)
    {
        $this->card_holder = $card_holder;

        return $this;
    }

    /**
     * Returns the auto settle flag
     *
     * @return bool
     */
    public function getAutoSettle()
    {
        return $this->auto_settle;
    }

    /**
     * Sets if the auth should be settled automatically
     *
     * @param bool $auto_settle
     *
     * @return AuthRequest
     */
    public function setAutoSettle($auto_settle)
    {
        $this->auto_settle = $auto_settle;

        return $this;
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
                $this->getOrderID(),
                $this->getAmount(true),
                $this->getCurrency(),
                $this->getCardNumber()
            )
        );
    }
}
