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
interface ResponseInterface
{
    /**
     * Returns the raw XML body of the request
     *
     * @return string
     */
    public function getXml();

    /**
     * Returns the Request's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the Request's result code.
     *
     * @return string
     */
    public function getResult();

    /**
     * Returns the Request's result message.
     *
     * @return string
     */
    public function getMessage();
}
