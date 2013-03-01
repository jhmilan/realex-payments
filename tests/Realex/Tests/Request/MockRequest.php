<?php

/**
 * This file is part of the Realex package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Realex\Tests\Request;

use Realex\Request\AbstractRequest;

/**
 * @author Shane O'Grady <shane.ogrady@gmail.com>
 */
class MockRequest extends AbstractRequest
{
    public function getAdapter()
    {
        return parent::getAdapter();
    }

    protected function setMd5Hash()
    {
        return $this;
    }

    protected function setSha1Hash()
    {
        return $this;
    }

    protected function validate()
    {
        return true;
    }

    public function execute()
    {
    }
}
