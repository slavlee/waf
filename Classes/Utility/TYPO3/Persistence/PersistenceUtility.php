<?php

declare(strict_types=1);

namespace Slavlee\Waf\Utility\TYPO3\Persistence;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class PersistenceUtility
{
    /**
     * Persit all transactions
     */
    public static function persistAll(): void
    {
        $persistenceManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
    }
}
