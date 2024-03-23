<?php

namespace Slavlee\Waf\Tests\Unit\Utility;

use Slavlee\Waf\Utility\XssUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */
class XssUtilityTest extends UnitTestCase
{
    /**
     * @test
     * Test if Utility can detect "base64_encode" string
     */
    public function denyScriptTagWithoutAttributeString()
    {
        $stringToScan = '<script>alert("TEST");</script>';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            XssUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "base64_encode" string
     */
    public function denyScriptTagWithAttributeString()
    {
        $stringToScan = '<script type="text/javascript">alert("TEST");</script>';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            XssUtility::scanString($stringToScan)
        );
    }
}
