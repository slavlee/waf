<?php

declare(strict_types=1);

namespace Slavlee\Waf\Domain\DomainObject;

use TYPO3\CMS\Extbase\DomainObject\AbstractValueObject;

/*
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class RequestScannerResultObject extends AbstractValueObject
{
    /**
     * Stack of keywords, why last request was blocked
     * @var array
     */
    protected array $blockReasons = [];

    /**
     * Get stack of keywords, why last request was blocked
     *
     * @return  array
     */
    public function getBlockReasons(): array
    {
        return $this->blockReasons;
    }

    /**
     * Set stack of keywords, why last request was blocked
     *
     * @param  array  $blockReasons  Stack of keywords, why last request was blocked
     *
     * @return  self
     */
    public function setBlockReasons(array $blockReasons): RequestScannerResultObject
    {
        $this->blockReasons = $blockReasons;

        return $this;
    }

    /**
     * Return true if object is empty
     * @return bool
     */
    public function isEmpty(): bool
    {
        $vars = \get_object_vars($this);

        foreach($vars as $var) {
            if (!empty($this->$var)) {
                return false;
            }
        }

        return true;
    }
}
