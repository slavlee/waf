<?php

namespace Slavlee\Waf\Tests\Unit\Utility;

/**
 * This file is part of the "waf" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Kevin Chileong Lee <support@slavlee.de>, Slavlee
 */

use Slavlee\Waf\Utility\CodeExecutionUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CodeExecutionUtilityTest extends UnitTestCase
{
    /**
     * @test
     * Test if Utility can detect "base64_encode" string
     */
    public function denyBase64EncodeStaticArgumentString()
    {
        $stringToScan = 'base64_encode("test")';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "base64_encode" string
     */
    public function denyBase64EncodeVariableArgumentString()
    {
        $stringToScan = 'base64_encode($test)';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "md5" string
     */
    public function denyMD5WithStaticArgumentString()
    {
        $stringToScan = 'md5("test")';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "md5" string
     */
    public function denyMD5WithVariableArgumentString()
    {
        $stringToScan = 'md5($test)';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "xxx.php" string
     */
    public function denyPHPFilenamesString()
    {
        $stringToScan = 'index.php';
        $expectedResult = false;

        self::assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }
}
