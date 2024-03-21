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

class SqlInjectionUtility
{
    // This need to be unique words related directly to SQL queries
    // which are almost guaranteed to be not used in normal text
    const SQL_WORDS = ['database()', 'table_schema', 'group_concat'];

    /**
     * Detect SQL injection on a string
     * @param string $stringToScan
     * @return bool
     */
    public static function scanString(string $stringToScan): bool
    {
        $stringToScan = \strtolower(\trim($stringToScan));

        // block union select
        if (\preg_match('/union select/', $stringToScan)) {
            return false;
        }

        // block something like OR 1=1
        if (\preg_match('/or\s[a-z0-9]{1,1}=[a-z0-9]{1,1}/', $stringToScan)) {
            return false;
        }

        foreach(self::SQL_WORDS as $word) {
            if(\strpos($stringToScan, $word) !== false) {
                return false;
            }
        }

        return true;
    }
}
