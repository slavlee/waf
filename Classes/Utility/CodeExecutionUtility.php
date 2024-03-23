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

class CodeExecutionUtility
{
    // This need to be unique words related directly to SQL queries
    // which are almost guaranteed to be not used in normal text
    const PHP_COMMANDS = ['base64_encode', 'md5'];

    /**
     * Detect SQL injection on a string
     * @param string $stringToScan
     * @return bool
     */
    public static function scanString(string $stringToScan): bool
    {
        $stringToScan = \strtolower(\trim($stringToScan));

        // find php commands which we dont allow
        foreach(self::PHP_COMMANDS as $command) {
            if(\preg_match('/' . $command . '\s?\(/', $stringToScan)) {
                return false;
            }
        }

        // we also block if someone send a php filename
        if (preg_match('/^[a-z0-9]*\.php$/', $stringToScan)) {
            return false;
        }

        return true;
    }
}
