<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class Realex
{
    private static $instance;

    private $endpoint;

    private $userAgent;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getRemoteEndpoint()
    {
        return $this->remoteEndpoint;
    }

    public function getuserAgent()
    {
        return $this->userAgent;
    }

    public function setProperty($property, $value)
    {
        $this->$property = $value;
    }

    public function load($params = array())
    {
        if (!is_array($params)) {
            throw new \ErrorException('Bad params when loading Realex');
        }

        $params = array_filter($params);
        $params = array_intersect_key($params, array('remoteEndpoint', 'userAgent'));

        if (!array_key_exists('remoteEndpoint', $params)) {
            $params['remoteEndpoint'] = "https://epage.payandshop.com/epage-remote.cgi";
        }

        if (!array_key_exists('userAgent', $params)) {
            $params['userAgent'] = "Realex PHP Library";
        }

        foreach ($params as $param => $value) {
            self::getInstance()->setProperty($param, $value);            
        }
    }
}
