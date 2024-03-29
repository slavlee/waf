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
class ScannerQueue implements \Iterator
{
    /**
     * @var int
     */
    private int $currentIndex = 0;

    /**
     * List of scanners that will be used during a request scan
     * @var array
     */
    protected array $scanners = [];

    /**
     * Get list of scanners that will be used during a request scan
     *
     * @return  array
     */
    public function getScanners(): array
    {
        return $this->scanners;
    }

    /**
     * Set list of scanners that will be used during a request scan
     *
     * @param  array  $scanners  List of scanners that will be used during a request scan
     *
     * @return  self
     */
    public function setScanners(array $scanners): ScannerQueue
    {
        $this->scanners = $scanners;

        return $this;
    }

    /**
     * Add a scanner into the queue
     * @param RequestScanner $scanner
     */
    public function addScanner(RequestScanner $scanner): void
    {
        if (!\in_array($scanner, $this->scanners)) {
            $this->scanners[] = $scanner;
        }
    }

    /**
     * Return the current element
     * @return RequestScanner
     */
    public function current(): mixed
    {
        return \array_key_exists($this->currentIndex, $this->scanners[$this->currentIndex]);
    }

    /**
     * Return the key of the current element
     * @return int
     */
    public function key(): mixed
    {
        return $this->currentIndex;
    }

    /**
     * Move forward to next element
     */
    public function next(): void
    {
        $this->currentIndex++;
    }

    /**
     * Rewind the iterator to the first element
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
    }

    /**
     * Check if the current position is valid
     */
    public function valid(): bool
    {
        return $this->currentIndex > 0 && $this->currentIndex < count($this->scanners);
    }
}
