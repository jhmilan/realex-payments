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
abstract class AbstractResponse
{

    /**
     * @var string
     */
    protected $timestamp = null;

    /**
     * @var string
     */
    protected $result = null;

    /**
     * @var string
     */
    protected $message = null;

    /**
     * @var string
     */
    protected $merchant_id = null;

    /**
     * @var string
     */
    protected $account = null;

    /**
     * @var string
     */
    protected $secret = null;

    /**
     * @var string
     */
    protected $md5hash = null;

    /**
     * @var string
     */
    protected $sha1hash = null;

    /**
     * @var string
     */
    protected $xml = null;

    /**
     * @var \SimpleXMLElement
     */
    protected $response = null;


    /**
     * @param string $secret Realex shared secret
     * @param string $xml    The XML response to parse
     */
    public function __construct($secret, $xml)
    {
        $this->setSecret($secret);
        $this->xml = $xml;
        $this->parseResult($xml);
    }

    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param string $account
     *
     * @return AbstractResponse
     */
    protected function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param string $secret
     *
     * @return AbstractResponse
     */
    protected function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $md5hash
     *
     * @return AbstractResponse
     */
    protected function setMd5Hash($md5hash)
    {
        $this->md5hash = $md5hash;

        return $this;
    }

    /**
     * @return string
     */
    protected function getMd5Hash()
    {
        return $this->md5hash;
    }

    /**
     * @param string $merchant_id
     *
     * @return AbstractResponse
     */
    protected function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param string $message
     *
     * @return AbstractResponse
     */
    protected function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $result
     *
     * @return AbstractResponse
     */
    protected function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $sha1hash
     *
     * @return AbstractResponse
     */
    protected function setSha1Hash($sha1hash)
    {
        $this->sha1hash = $sha1hash;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSha1Hash()
    {
        return $this->sha1hash;
    }

    /**
     * @param string $timestamp
     *
     * @return AbstractResponse
     */
    protected function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns the hash
     *
     * @return string
     */
    public function getHash()
    {
        if (!empty($this->md5hash)) {
            return $this->getMd5Hash();
        } else {
            return $this->getSha1Hash();
        }
    }

    /**
     * @param string $xml The result XML to parse
     */
    protected function parseResult($xml)
    {
        if (!$this->response = simplexml_load_string($xml)) {
            throw new \InvalidArgumentException("Invalid or missing XML");
        }

        $this
            ->setTimestamp((string) $this->response['timestamp'])
            ->setMerchantId((string) $this->response->merchantid)
            ->setAccount((string) $this->response->account)
            ->setResult((string) $this->response->result)
            ->setMessage((string) $this->response->message)
            ->setMd5Hash((string) $this->response->md5hash)
            ->setSha1Hash((string) $this->response->sha1hash);
    }

    /**
     * Ensures the response is valid
     */
    protected function validate()
    {
        if ($this->getMd5Hash()) {
            $fields = md5($this->getHashFields());
            $hash = md5("$fields.{$this->getSecret()}");
        } else {
            $fields = sha1($this->getHashFields());
            $hash = sha1("$fields.{$this->getSecret()}");
        }

        return ($hash === $this->getHash());
    }

    /**
     * Return the specific fields for the hash function
     *
     * @return string
     */
    abstract protected function getHashFields();
}
