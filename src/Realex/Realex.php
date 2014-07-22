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
    private static $instance = null;

    private static $endpoint;

    private static $userAgent;

    private static $settled = false;

    public static function getInstance()
    {
        if (!self::isInstantiated()) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getEndpoint()
    {
        if (!self::isSettled()) {
            throw new \ErrorException('Realex engine not settled');
        }
        return self::$endpoint;
    }

    public static function getuserAgent()
    {
        if (!self::isSettled()) {
            throw new \ErrorException('Realex engine not settled');
        }
        return self::$userAgent;
    }

    public static function setProperty($property, $value)
    {
        if (!self::isInstantiated()) {
            throw new \ErrorException('Realex engine not instantiated');
        }
        self::${$property} = $value;
    }

    public static function load($params = array())
    {
        self::getInstance();

        if (!is_array($params)) {
            throw new \ErrorException('Bad params when loading Realex');
        }
        $params = array_filter($params);
        $params = array_intersect_key($params, array_flip(array('endpoint', 'userAgent')));

        if (!array_key_exists('endpoint', $params)) {
            $params['endpoint'] = "https://epage.payandshop.com/epage-remote.cgi";
        }

        if (!array_key_exists('userAgent', $params)) {
            $params['userAgent'] = "Realex PHP Library";
        }

        self::$settled = true;

        foreach ($params as $param => $value) {
            self::setProperty($param, $value);
        }
    }

    public static function isInstantiated()
    {
        return (!is_null(self::$instance));
    }

    public static function isSettled()
    {
        return (self::isInstantiated() && self::$settled);
    }
}
