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
    public function denyBase64EncodeString()
    {
        $stringToScan = 'base64_encode';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect "md5" string
     */
    public function denyMD5String()
    {
        $stringToScan = 'md5';
        $expectedResult = false;

        $this->assertEquals(
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

        $this->assertEquals(
            $expectedResult,
            CodeExecutionUtility::scanString($stringToScan)
        );
    }
 }
