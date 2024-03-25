<?php

declare(strict_types=1);

namespace Slavlee\Waf\Utility\TYPO3\Persistence;

use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class RepositoryUtility
{
    /**
     * Disable respect storage page of given repostiroy
     * @param Repository $repository
     * @return void
     */
    public static function disableRespectStoragePage(Repository &$repository): void
    {
        $querySettings = $repository->createQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
        $repository->setDefaultQuerySettings($querySettings);
    }
}
