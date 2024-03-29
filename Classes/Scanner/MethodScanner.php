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
class MethodScanner extends RequestScanner
{
    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     */
    protected function scanGP(array $gp, int $loop = 100): bool
    {
        return $this->scanMethod();
    }

    /**
     * Check if HTTP method is allowed
     * @return bool
     */
    private function scanMethod(): bool
    {
        $validRequest = in_array($this->request->getMethod(), GeneralUtility::trimExplode(',', $this->extConf['firewall']['frontend']['allowedMethods'], true));

        if (!$validRequest) {
            $this->resultObject->addBlockReason([
                'func' => 'scanMethod',
                'reason' => 'method not allowed',
            ]);
        }

        return $validRequest;
    }
}
