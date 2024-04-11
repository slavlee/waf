<?php

declare(strict_types=1);

namespace Slavlee\Waf\Scanner;

use Slavlee\Waf\Utility\SqlInjectionUtility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class SqlInjectionScanner extends RequestScanner
{
    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     * @return bool
     */
    protected function scanGP(array $gp, int $loop = 100): bool
    {
        if ($loop <= 0) {
            return true;
        }

        foreach ($gp as $parameter) {
            if (\is_array($parameter)) {
                $this->scanGP($parameter, $loop - 1);
            } elseif (!SqlInjectionUtility::scanString((string)$parameter)) {

                $this->resultObject->addBlockReason([
                    'func' => 'scanGP',
                    'reason' => 'parameter: ' . (string)$parameter .' not allowed',
                ]);
                return false;
            }
        }

        return true;
    }
}
