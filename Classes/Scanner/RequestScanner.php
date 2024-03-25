<?php

declare(strict_types=1);

namespace Slavlee\Waf\Scanner;

use Slavlee\Waf\Domain\DomainObject\RequestScannerResultObject;

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
     * Save information about the scan result of the last scan
     * @var RequestScannerResultObject
     */
    protected ?RequestScannerResultObject $resultObject = null;

    /**
     * Init the scanner with the extension configuration
     * @param array $extConf
     */
    public function init(array $extConf): void
    {
        $this->depth = (int)$extConf['depth'];
    }

    /**
     * Scan current request for sql injections
     * @return bool
     */
    public function scanRequest(): bool
    {
        $this->resultObject = new RequestScannerResultObject();
        $this->gp = \array_merge_recursive($_GET, $_POST);

        return $this->scanGP($this->gp, $this->depth);
    }

    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     * @return bool
     */
    abstract protected function scanGP(array $gp, int $loop = 100): bool;

    /**
     * Get save information about the scan result of the last scan
     *
     * @return RequestScannerResultObject
     */
    public function getResultObject()
    {
        return $this->resultObject;
    }
}
