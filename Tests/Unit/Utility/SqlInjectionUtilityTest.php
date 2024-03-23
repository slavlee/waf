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

use Slavlee\Waf\Utility\SqlInjectionUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class SqlInjectionUtilityTest extends UnitTestCase
{
    /**
     * @test
     * Test if Utility can detect "union select" string
     */
    public function denyUnionSelectAtBeginningString()
    {
        $stringToScan = 'union select';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect "union select" string
     */
    public function denyUnionSelectAtMiddleString()
    {
        $stringToScan = \urldecode('-1+union+select+1,2,3,4,5,6,7,8,9,10');
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect "OR 1=1" SQL queries
     */
    public function denyOrZeroEqualsZeroString()
    {
        $stringToScan = '105 OR 1=1';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect 'OR "x"="x"' SQL queries
     */
    public function denyOrXEqualsXString()
    {
        $stringToScan = '105 OR "x"="x"';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect "OR 'x'='x'" SQL queries
     */
    public function denyOrXEqualsXV2String()
    {
        $stringToScan = '105 OR \'x\'=\'x\'';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect "OR 1=1" SQL queries
     */
    public function denyAndZeroEqualsZeroString()
    {
        $stringToScan = '105 AND 1=1';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test 2 if Utility can detect 'OR "x"="x"' SQL queries
     */
    public function denyAndXEqualsXString()
    {
        $stringToScan = '105 AND "x"="x"';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect 'database()' SQL queries
     */
    public function denyDatabaseFuncString()
    {
        $stringToScan = 'database()';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }

    /**
     * @test
     * Test if Utility can detect 'INFORMATION_SCHEMA' SQL queries
     */
    public function denyInformationSchemaString()
    {
        $stringToScan = 'INFORMATION_SCHEMA.TABLES';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }
}
