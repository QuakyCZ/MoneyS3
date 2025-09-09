<?php

namespace eProduct\MoneyS3\Test;

use eProduct\MoneyS3\Element;
use eProduct\MoneyS3\Exception\MoneyS3Exception;
use eProduct\MoneyS3\ISerializable;
use PHPUnit\Framework\TestCase;
use XMLWriter;

class ElementTest extends TestCase
{
    private XMLWriter $writer;

    protected function setUp(): void
    {
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->startDocument('1.0', 'UTF-8');
    }

    public function testConstructorSetsNameAndRequired(): void
    {
        $element = new Element('testElement', true);
        
        $this->assertInstanceOf(Element::class, $element);
    }

    public function testSetValueAndGetValue(): void
    {
        $element = new Element('testElement');
        $testValue = 'test value';
        
        $element->setValue($testValue);
        
        $this->assertEquals($testValue, $element->getValue());
    }

    public function testSerializeWithScalarValue(): void
    {
        $element = new Element('testElement');
        $element->setValue('test value');
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<testElement>test value</testElement>', $xml);
    }

    public function testSerializeWithNullValueNotRequired(): void
    {
        $element = new Element('testElement', false);
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringNotContainsString('<testElement>', $xml);
    }

    public function testSerializeWithNullValueRequiredThrowsException(): void
    {
        $element = new Element('testElement', true);
        
        $this->expectException(MoneyS3Exception::class);
        $this->expectExceptionMessage('Element testElement is required but not set.');
        
        $element->serialize($this->writer);
    }

    public function testSerializeWithSerializableObject(): void
    {
        $serializableObject = new class implements ISerializable {
            public function serialize(XMLWriter $writer): void
            {
                $writer->writeElement('nested', 'value');
            }
        };
        
        $element = new Element('testElement');
        $element->setValue($serializableObject);
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<testElement><nested>value</nested></testElement>', $xml);
    }

    public function testSetValueWithDifferentTypes(): void
    {
        $element = new Element('testElement');
        
        // Test string
        $element->setValue('string value');
        $this->assertEquals('string value', $element->getValue());
        
        // Test integer
        $element->setValue(123);
        $this->assertEquals(123, $element->getValue());
        
        // Test null
        $element->setValue(null);
        $this->assertNull($element->getValue());
        
        // Test object
        $object = new \stdClass();
        $element->setValue($object);
        $this->assertSame($object, $element->getValue());
    }

    public function testSerializeWithNumericValue(): void
    {
        $element = new Element('amount');
        $element->setValue(1234.56);
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<amount>1234.56</amount>', $xml);
    }

    public function testSerializeWithBooleanValue(): void
    {
        $element = new Element('isActive');
        $element->setValue(true);
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString('<isActive>1</isActive>', $xml);
    }

    public function testElementNameIsUsedInXml(): void
    {
        $elementName = 'customElementName';
        $element = new Element($elementName);
        $element->setValue('test');
        
        $element->serialize($this->writer);
        $xml = $this->writer->outputMemory();
        
        $this->assertStringContainsString("<$elementName>test</$elementName>", $xml);
    }
}
