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

use Slavlee\Waf\Utility\XssUtility;

class XssScanner extends RequestScanner
{
    /**
     * Scan array for sql injections
     * @param array $gp
     * @param int $loop
     */
    protected function scanGP(array $gp, int $loop = 100): bool
    {
        if ($loop <= 0) {
            return true;
        }

        foreach($gp as $parameter) {
            if (\is_array($parameter)) {
                $this->scanGP($parameter, $loop-1);
            }elseif(!XssUtility::scanString((string)$parameter)) {
                return false;
            }
        }

        return true;
    }
}
