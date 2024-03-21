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
    public function testUnionSelectAtBeginningString()
    {
        $stringToScan = 'union select';
        $expectedResult = false;

        $this->assertEquals(
            $expectedResult,
            SqlInjectionUtility::scanString($stringToScan)
        );
    }
 }
