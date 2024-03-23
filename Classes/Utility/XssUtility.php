<?php
declare(strict_types=1);

namespace Slavlee\Waf\Utility;


/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */

class XssUtility
{
    /**
     * Detect XSS in a string
     * @param string $stringToScan
     * @return bool
     */
    public static function scanString(string $stringToScan): bool
    {
        // we also block if someone send a php filename
        if (preg_match('/<script[\sA-z="\/]*>/', $stringToScan)) {
            return false;
        }

        return true;
    }
}
