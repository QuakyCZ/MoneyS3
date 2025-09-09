<?php

namespace eProduct\MoneyS3\Test\Utility;

use eProduct\MoneyS3\Test\Utility\XmlTestUtility;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;

class XmlTestUtilityTest extends TestCase
{
    public function testCompareIdenticalXml(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        
        $result = XmlTestUtility::compareXml($xml, $xml);
        
        $this->assertTrue($result['identical']);
        $this->assertEmpty($result['differences']);
    }

    public function testCompareNormalizedIdenticalXml(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root>  <child>value</child>  </root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertFalse($result['identical']);
        $this->assertTrue($result['normalized_identical']);
    }

    public function testCompareStructurallyIdenticalXml(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value1</child><other attr="1"/></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value2</child><other attr="2"/></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertFalse($result['identical']);
        $this->assertFalse($result['normalized_identical']);
        $this->assertTrue($result['structural_identical']);
    }

    public function testCompareDifferentXml(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child1>value</child1></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child2>value</child2></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertFalse($result['identical']);
        $this->assertFalse($result['normalized_identical']);
        $this->assertFalse($result['structural_identical']);
        $this->assertNotEmpty($result['differences']);
    }

    public function testXmlDiffSystem(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value1</child></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value2</child></root>';
        
        $result = XmlTestUtility::xmlDiffSystem($xml1, $xml2);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('exit_code', $result);
        $this->assertArrayHasKey('output', $result);
        $this->assertArrayHasKey('has_differences', $result);
        $this->assertTrue($result['has_differences']);
    }

    public function testXmlDiffSystemIdentical(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        
        $result = XmlTestUtility::xmlDiffSystem($xml, $xml);
        
        $this->assertFalse($result['has_differences']);
        $this->assertEquals(0, $result['exit_code']);
    }

    public function testAssertXmlEquals(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root>  <child>value</child>  </root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        
        // Should not throw exception
        XmlTestUtility::assertXmlEquals($xml1, $xml2);
        $this->assertTrue(true); // Test passes if no exception thrown
    }

    public function testAssertXmlEqualsFailure(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value1</child></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>value2</child></root>';
        
        $this->expectException(AssertionFailedError::class);
        XmlTestUtility::assertXmlEquals($xml1, $xml2);
    }

    public function testAssertXmlStructureEquals(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child attr="1">value1</child></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child attr="2">value2</child></root>';
        
        // Should not throw exception (same structure)
        XmlTestUtility::assertXmlStructureEquals($xml1, $xml2);
        $this->assertTrue(true);
    }

    public function testAssertXmlStructureEqualsFailure(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child1>value</child1></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child2>value</child2></root>';
        
        $this->expectException(AssertionFailedError::class);
        XmlTestUtility::assertXmlStructureEquals($xml1, $xml2);
    }

    public function testAssertXmlContains(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child><other attr="test"/></root>';
        
        // Should not throw exception
        XmlTestUtility::assertXmlContains($xml, [
            'root',
            'child',
            'other',
            'child' => 'value'
        ]);
        $this->assertTrue(true);
    }

    public function testAssertXmlContainsFailure(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        
        $this->expectException(AssertionFailedError::class);
        XmlTestUtility::assertXmlContains($xml, ['missing_element']);
    }

    public function testCompareXmlWithAttributes(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child attr1="value1" attr2="value2">text</child></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child attr1="value1" attr2="different">text</child></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertFalse($result['normalized_identical']);
        $differencesText = implode(' ', $result['differences']);
        $this->assertStringContainsString("Attribute 'attr2' differs", $differencesText);
    }

    public function testCompareXmlWithMissingElements(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child1/><child2/></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child1/></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertNotEmpty($result['differences']);
        $differencesText = implode(' ', $result['differences']);
        $this->assertStringContainsString("Missing element", $differencesText);
    }

    public function testGenerateStatistics(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?><root><child attr="value">text</child><other/></root>';
        $xml2 = '<?xml version="1.0" encoding="UTF-8"?><root><child>text</child></root>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertArrayHasKey('statistics', $result);
        $this->assertArrayHasKey('elements_count_1', $result['statistics']);
        $this->assertArrayHasKey('elements_count_2', $result['statistics']);
        $this->assertGreaterThan($result['statistics']['elements_count_2'], $result['statistics']['elements_count_1']);
    }

    public function testCompareInvalidXml(): void
    {
        $validXml = '<?xml version="1.0" encoding="UTF-8"?><root><child>value</child></root>';
        $invalidXml = '<root><child>unclosed';
        
        $result = XmlTestUtility::compareXml($validXml, $invalidXml);
        
        $this->assertArrayHasKey('error', $result);
        $this->assertStringContainsString('XML parsing failed', $result['error']);
    }

    public function testComplexXmlComparison(): void
    {
        $xml1 = '<?xml version="1.0" encoding="UTF-8"?>
            <MoneyData ICAgendy="12345678" JazykVerze="CZ">
                <SeznamFaktVyd>
                    <FaktVyd>
                        <Doklad>2023001</Doklad>
                        <Popis>Test Invoice</Popis>
                    </FaktVyd>
                </SeznamFaktVyd>
            </MoneyData>';

        $xml2 = '<?xml version="1.0" encoding="UTF-8"?>
            <MoneyData ICAgendy="12345678" JazykVerze="CZ">
                <SeznamFaktVyd>
                    <FaktVyd>
                        <Doklad>2023001</Doklad>
                        <Popis>Test Invoice</Popis>
                    </FaktVyd>
                </SeznamFaktVyd>
            </MoneyData>';
        
        $result = XmlTestUtility::compareXml($xml1, $xml2);
        
        $this->assertTrue($result['normalized_identical']);
        $this->assertEmpty($result['differences']);
    }
}
