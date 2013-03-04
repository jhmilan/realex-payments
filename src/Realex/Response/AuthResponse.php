<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Response;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class AuthResponse extends AbstractResponse implements ResponseInterface
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
    public function getName()
    {
        return "auth";
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
                $this->getResult(),
                $this->getMessage(),
                $this->getPasRef(),
                $this->getAuthCode()
            )
        );
    }

    /**
     * Sets the order ID that was used.
     *
     * @param string $order_id
     *
     * @return AuthResponse
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
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
     * Sets the PasRef
     *
     * @param string $pasref
     *
     * @return AuthResponse
     */
    public function setPasRef($pasref)
    {
        $this->pasref = $pasref;

        return $this;
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
     * Sets the Auth Code
     *
     * @param string $authcode
     *
     * @return AuthResponse
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
     * {@inheritDoc}
     */
    protected function parseResult($xml)
    {
        parent::parseResult($xml);

        $this
            ->setOrderId((string) $this->response->orderid)
            ->setAuthCode((string) $this->response->authcode)
            ->setPasRef((string) $this->response->pasref);
    }

}
