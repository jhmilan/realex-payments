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

use Realex\Realex;

use Buzz\Browser;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class BuzzHttpAdapter implements HttpAdapterInterface
{

    /**
     * @var Browser
     */
    protected $browser;

    /**
     * @param Browser $browser Browser object
     */
    public function __construct(Browser $browser = null)
    {
        $this->browser = null === $browser ? new Browser() : $browser;
    }

    /**
     * {@inheritDoc}
     */
    public function postRequest($content)
    {
        $result = $this->browser->post(Realex::getEndpoint(), array("User-Agent" => Realex::getUserAgent()), $content);
        $response  = $result->getContent();

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'buzz';
    }
}
