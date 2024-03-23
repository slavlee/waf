<?php

declare(strict_types=1);

namespace Slavlee\Waf\Scanner;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */

abstract class RequestScanner
{
    /**
     * @var int
     */
    protected int $depth = 100;

    /**
     * Array of all get and post parameter
     * @var array
     */
    protected array $gp = [];

    /**
     * Init the scanner with the extension configuration
     * @param array $extConf
     * @return void
     */
    public function init(array $extConf): void
    {
        $this->depth = (int) $extConf['depth'];
    }

    /**
     * Scan current request for sql injections
     * @retur bool
     */
    public function scanRequest(): bool
    {
        $this->gp = \array_merge_recursive($_GET, $_POST);

        return $this->scanGP($this->gp, $this->depth);
    }

    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     */
    abstract protected function scanGP(array $gp, int $loop = 100): bool;
}
