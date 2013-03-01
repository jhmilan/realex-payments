<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\HttpAdapter;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
interface HttpAdapterInterface
{
    /**
     * Posts the provided content to Realex and returns the response
     *
     * @param string $content
     *
     * @return string
     */
    public function postRequest($content);

    /**
     * Returns the name of the HTTP Adapter.
     *
     * @return string
     */
    public function getName();
}
