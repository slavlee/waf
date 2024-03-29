<?php

declare(strict_types=1);

namespace Slavlee\Waf\Scanner;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class UrlSegmentsScanner extends RequestScanner
{
    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     */
    protected function scanGP(array $gp, int $loop = 100): bool
    {
        return $this->scanUrlSegments();
    }

    /**
     * Check if url path is allowed
     * @return bool
     */
    private function scanUrlSegments(): bool
    {
        $path = $this->request->getUri()->getPath();
        $invalidSegments = GeneralUtility::trimExplode(',', $this->extConf['firewall']['frontend']['disallowedFirstUrlSegments']);

        foreach ($invalidSegments as $invalidSegment) {
            if (\preg_match('/^\/' . $invalidSegment . '(\/.*)?$/', $path)) {
                $this->resultObject->addBlockReason([
                    'func' => 'scanUrlSegments',
                    'reason' => $path,
                ]);
                return false;
            }
        }

        return true;
    }
}
