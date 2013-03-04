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

use Realex\HttpAdapter\HttpAdapterInterface;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
abstract class AbstractRequest
{
    /**
     * @var HttpAdapterInterface
     */
    protected $adapter = null;

    /**
     * @var string
     */
    protected $timestamp = null;

    /**
     * @var string
     */
    protected $merchant_id = null;

        /**
     * @var string
     */
    protected $secret = null;

    /**
     * @var string
     */
    protected $account = null;

    /**
     * @var string
     */
    protected $md5hash = null;

    /**
     * @var string
     */
    protected $sha1hash = null;

    /**
     * @var double
     */
    protected $time_taken = 0;

    /**
     * @var string
     */
    protected $hash_algorithm = "md5";

    /**
     * @param HttpAdapterInterface $adapter An HTTP adapter.
     */
    public function __construct(HttpAdapterInterface $adapter)
    {
        $this->setAdapter($adapter);
        $this->setTimestamp();
    }

    /**
     * Returns the HTTP adapter.
     *
     * @return HttpAdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Sets the HTTP adapter to be used.
     *
     * @param HttpAdapterInterface $adapter
     *
     * @return AbstractRequest
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Returns the timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets the timestamp to be used.
     *
     *
     * @return AbstractRequest
     */
    protected function setTimestamp()
    {
        $this->timestamp = strftime("%Y%m%d%H%M%S");

        return $this;
    }

    /**
     * Returns the Merchant ID
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * Sets the Merchant ID to be used.
     *
     * @param string $merchant_id
     *
     * @return AbstractRequest
     */
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;

        return $this;
    }

    /**
     * Returns the shared secret
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Sets the shared secret to be used.
     *
     * @param string $secret
     *
     * @return AbstractRequest
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Returns the account name
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Sets the account to be used.
     *
     * @param string $account
     *
     * @return AbstractRequest
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Returns the MD5 hash
     *
     * @return string
     */
    protected function getMd5Hash()
    {
        return $this->md5hash;
    }

    /**
     * Sets the MD5 hash to be used.
     *
     * @return AbstractRequest
     */
    abstract protected function setMd5Hash();

    /**
     * Returns the SHA1 hash
     *
     * @return string
     */
    protected function getSha1Hash()
    {
        return $this->sha1hash;
    }

    /**
     * Sets the SHA1 hash to be used.
     *
     * @return AbstractRequest
     */
    abstract protected function setSha1Hash();

    /**
     * Returns the hash
     *
     * @return string
     */
    public function getHash()
    {
        if ($this->hash_algorithm == "md5") {
            return $this->getMd5Hash();
        } else {
            return $this->getSha1Hash();
        }
    }

    /**
     * Sets the SHA1 hash to be used.
     *
     * @return AbstractRequest
     */
    protected function setHash()
    {
        if ($this->hash_algorithm == "md5") {
            return $this->setMd5Hash();
        } else {
            return $this->setSha1Hash();
        }
    }

    /**
     * Validate the request XML
     *
     * @return AbstractRequest
     */
    abstract protected function validate();

    /**
     * Return the specific fields for the hash function
     *
     * @return string
     */
    abstract protected function getHashFields();

    /**
     * Executes the request
     *
     * @return string
     */
    public function execute()
    {
        if ($this->validate()) {

            $time_start = microtime(true);

            $result = $this->getAdapter()->postRequest($this->getXml());

            $this->time_taken = microtime(true) - $time_start;

            return $result;
        }
    }

    /**
     * Returns the exact time taken to perform the request, in seconds
     *
     * @return double
     */
    public function getTimeTaken()
    {
        return $this->time_taken;
    }

    /**
     * Returns the hash algorithm used
     *
     * @return string
     */
    public function getHashAlgorithm()
    {
        return $this->hash_algorithm;
    }

    /**
     * Sets the hash algorithm to use (MD5 or SHA1)
     *
     * @param  string $algorithm MD5|SHA1
     * @return double
     */
    public function setHashAlgorithm($algorithm)
    {
        if ((strtoupper($algorithm) != "MD5") && (strtoupper($algorithm) != "SHA1")) {
            throw new \InvalidArgumentException("Unkown or unsupported hash algorithm. Only MD5 or SHA1 supported.");
        }

        $this->hash_algorithm = strtolower($algorithm);

        return $this;
    }
}
