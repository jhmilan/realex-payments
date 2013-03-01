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
interface RequestInterface
{
    /**
     * Returns the XML body of the request
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
}
