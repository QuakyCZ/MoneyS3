<?php

namespace eProduct\MoneyS3\Test\Utility;

use DOMDocument;
use DOMXPath;
use Exception;

/**
 * XML Testing Utility class providing comprehensive XML comparison and diff functionality
 */
class XmlTestUtility
{
    /**
     * Compare two XML strings and return detailed comparison results
     */
    public static function compareXml(string $xml1, string $xml2, array $options = []): array
    {
        $result = [
            'identical' => false,
            'normalized_identical' => false,
            'structural_identical' => false,
            'differences' => [],
            'statistics' => []
        ];

        // Basic string comparison
        if ($xml1 === $xml2) {
            $result['identical'] = true;
            return $result;
        }

        try {
            // Parse both XML documents
            $dom1 = self::parseXml($xml1);
            $dom2 = self::parseXml($xml2);

            // Normalize and compare
            self::normalizeXml($dom1);
            self::normalizeXml($dom2);

            $normalized1 = $dom1->saveXML();
            $normalized2 = $dom2->saveXML();

            if ($normalized1 === $normalized2) {
                $result['normalized_identical'] = true;
                return $result;
            }

            // Structural comparison
            $result['structural_identical'] = self::compareStructure($dom1, $dom2);
            
            // Find differences
            $result['differences'] = self::findDifferences($dom1, $dom2);
            
            // Generate statistics
            $result['statistics'] = self::generateStatistics($dom1, $dom2);

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Use system xmldiff tool for detailed XML comparison
     */
    public static function xmlDiffSystem(string $xml1, string $xml2, array $options = []): array
    {
        $tempDir = sys_get_temp_dir();
        $file1 = tempnam($tempDir, 'xml1_');
        $file2 = tempnam($tempDir, 'xml2_');
        
        try {
            file_put_contents($file1, $xml1);
            file_put_contents($file2, $xml2);

            $formatter = $options['formatter'] ?? 'diff';
            $cmd = sprintf('xmldiff --formatter %s %s %s 2>&1', 
                escapeshellarg($formatter),
                escapeshellarg($file1), 
                escapeshellarg($file2)
            );

            $output = shell_exec($cmd);
            $exitCode = 0;
            exec($cmd, $outputArray, $exitCode);

            return [
                'exit_code' => $exitCode,
                'output' => $output,
                'has_differences' => $exitCode !== 0,
                'formatter' => $formatter
            ];

        } finally {
            if (file_exists($file1)) unlink($file1);
            if (file_exists($file2)) unlink($file2);
        }
    }

    /**
     * Assert XML strings are equivalent with detailed error reporting
     */
    public static function assertXmlEquals(string $expected, string $actual, string $message = ''): void
    {
        $comparison = self::compareXml($expected, $actual);
        
        if ($comparison['identical'] || $comparison['normalized_identical']) {
            return; // Test passes
        }

        $errorMessage = $message ?: 'XML documents are not equivalent';
        
        if (!empty($comparison['differences'])) {
            $errorMessage .= "\nDifferences found:\n" . implode("\n", $comparison['differences']);
        }

        if (!empty($comparison['error'])) {
            $errorMessage .= "\nError: " . $comparison['error'];
        }

        // Try system xmldiff for better diff output
        $systemDiff = self::xmlDiffSystem($expected, $actual);
        if (!empty($systemDiff['output'])) {
            $errorMessage .= "\nSystem xmldiff output:\n" . $systemDiff['output'];
        }

        throw new \PHPUnit\Framework\AssertionFailedError($errorMessage);
    }

    /**
     * Assert XML structure is identical regardless of content
     */
    public static function assertXmlStructureEquals(string $expected, string $actual, string $message = ''): void
    {
        $comparison = self::compareXml($expected, $actual);
        
        if ($comparison['structural_identical']) {
            return; // Test passes
        }

        $errorMessage = $message ?: 'XML structures are not identical';
        throw new \PHPUnit\Framework\AssertionFailedError($errorMessage);
    }

    /**
     * Assert XML contains specific elements/attributes
     */
    public static function assertXmlContains(string $xml, array $expectedElements, string $message = ''): void
    {
        try {
            $dom = self::parseXml($xml);
            $xpath = new DOMXPath($dom);
            
            $missing = [];
            foreach ($expectedElements as $element => $value) {
                if (is_numeric($element)) {
                    // Simple element name check
                    $nodes = $xpath->query("//*[local-name()='$value']");
                    if ($nodes->length === 0) {
                        $missing[] = "Element '$value' not found";
                    }
                } else {
                    // Element with specific value check
                    $nodes = $xpath->query("//*[local-name()='$element' and text()='$value']");
                    if ($nodes->length === 0) {
                        $missing[] = "Element '$element' with value '$value' not found";
                    }
                }
            }
            
            if (!empty($missing)) {
                $errorMessage = $message ?: 'XML does not contain expected elements';
                $errorMessage .= "\nMissing:\n" . implode("\n", $missing);
                throw new \PHPUnit\Framework\AssertionFailedError($errorMessage);
            }
            
        } catch (Exception $e) {
            throw new \PHPUnit\Framework\AssertionFailedError("XML parsing error: " . $e->getMessage());
        }
    }

    /**
     * Parse XML string into DOMDocument
     */
    private static function parseXml(string $xml): DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        
        $oldUseErrors = libxml_use_internal_errors(true);
        $loaded = $dom->loadXML($xml);
        
        if (!$loaded) {
            $errors = libxml_get_errors();
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = trim($error->message);
            }
            libxml_clear_errors();
            libxml_use_internal_errors($oldUseErrors);
            
            throw new Exception('XML parsing failed: ' . implode(', ', $errorMessages));
        }
        
        libxml_use_internal_errors($oldUseErrors);
        return $dom;
    }

    /**
     * Normalize XML document for comparison
     */
    private static function normalizeXml(DOMDocument $dom): void
    {
        // Remove whitespace-only text nodes
        $xpath = new DOMXPath($dom);
        $whitespaceNodes = $xpath->query('//text()[normalize-space(.) = ""]');
        
        foreach ($whitespaceNodes as $node) {
            $node->parentNode->removeChild($node);
        }
        
        // Normalize format
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->normalizeDocument();
    }

    /**
     * Compare XML structure (element hierarchy) ignoring content
     */
    private static function compareStructure(DOMDocument $dom1, DOMDocument $dom2): bool
    {
        $structure1 = self::extractStructure($dom1->documentElement);
        $structure2 = self::extractStructure($dom2->documentElement);
        
        return $structure1 === $structure2;
    }

    /**
     * Extract XML structure as array
     */
    private static function extractStructure($element): array
    {
        if (!$element) return [];
        
        $structure = [
            'name' => $element->localName,
            'attributes' => []
        ];
        
        // Extract attribute names (not values)
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $attr) {
                $structure['attributes'][] = $attr->localName;
            }
            sort($structure['attributes']);
        }
        
        // Extract child elements
        $children = [];
        foreach ($element->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                $children[] = self::extractStructure($child);
            }
        }
        
        if (!empty($children)) {
            $structure['children'] = $children;
        }
        
        return $structure;
    }

    /**
     * Find specific differences between two XML documents
     */
    private static function findDifferences(DOMDocument $dom1, DOMDocument $dom2): array
    {
        $differences = [];
        
        // Compare root elements
        if ($dom1->documentElement->localName !== $dom2->documentElement->localName) {
            $differences[] = sprintf(
                "Root element differs: '%s' vs '%s'",
                $dom1->documentElement->localName,
                $dom2->documentElement->localName
            );
        }
        
        // Compare attributes
        self::compareElementAttributes($dom1->documentElement, $dom2->documentElement, '', $differences);
        
        // Compare child elements
        self::compareChildElements($dom1->documentElement, $dom2->documentElement, '', $differences);
        
        return $differences;
    }

    /**
     * Compare attributes between two elements
     */
    private static function compareElementAttributes($element1, $element2, string $path, array &$differences): void
    {
        $attrs1 = [];
        $attrs2 = [];
        
        if ($element1 && $element1->hasAttributes()) {
            foreach ($element1->attributes as $attr) {
                $attrs1[$attr->localName] = $attr->value;
            }
        }
        
        if ($element2 && $element2->hasAttributes()) {
            foreach ($element2->attributes as $attr) {
                $attrs2[$attr->localName] = $attr->value;
            }
        }
        
        // Find missing attributes
        foreach (array_diff_key($attrs1, $attrs2) as $name => $value) {
            $differences[] = "Attribute '$name' missing in second document at $path";
        }
        
        foreach (array_diff_key($attrs2, $attrs1) as $name => $value) {
            $differences[] = "Extra attribute '$name' in second document at $path";
        }
        
        // Find different values
        foreach (array_intersect_key($attrs1, $attrs2) as $name => $value) {
            if ($attrs1[$name] !== $attrs2[$name]) {
                $differences[] = sprintf(
                    "Attribute '%s' differs at %s: '%s' vs '%s'",
                    $name, $path, $attrs1[$name], $attrs2[$name]
                );
            }
        }
    }

    /**
     * Compare child elements recursively
     */
    private static function compareChildElements($element1, $element2, string $path, array &$differences): void
    {
        $children1 = self::getElementChildren($element1);
        $children2 = self::getElementChildren($element2);
        
        $maxCount = max(count($children1), count($children2));
        
        for ($i = 0; $i < $maxCount; $i++) {
            $currentPath = $path . '/' . ($element1 ? $element1->localName : 'unknown') . "[$i]";
            
            if (!isset($children1[$i])) {
                $differences[] = "Extra element '{$children2[$i]->localName}' in second document at $currentPath";
                continue;
            }
            
            if (!isset($children2[$i])) {
                $differences[] = "Missing element '{$children1[$i]->localName}' in second document at $currentPath";
                continue;
            }
            
            $child1 = $children1[$i];
            $child2 = $children2[$i];
            
            if ($child1->localName !== $child2->localName) {
                $differences[] = sprintf(
                    "Element name differs at %s: '%s' vs '%s'",
                    $currentPath, $child1->localName, $child2->localName
                );
            }
            
            // Compare text content
            $text1 = trim($child1->textContent);
            $text2 = trim($child2->textContent);
            
            if ($text1 !== $text2 && !$child1->hasChildNodes() && !$child2->hasChildNodes()) {
                $differences[] = sprintf(
                    "Text content differs at %s: '%s' vs '%s'",
                    $currentPath, $text1, $text2
                );
            }
            
            // Recursively compare
            self::compareElementAttributes($child1, $child2, $currentPath, $differences);
            self::compareChildElements($child1, $child2, $currentPath, $differences);
        }
    }

    /**
     * Get element children (excluding text nodes)
     */
    private static function getElementChildren($element): array
    {
        $children = [];
        if ($element) {
            foreach ($element->childNodes as $child) {
                if ($child->nodeType === XML_ELEMENT_NODE) {
                    $children[] = $child;
                }
            }
        }
        return $children;
    }

    /**
     * Generate comparison statistics
     */
    private static function generateStatistics(DOMDocument $dom1, DOMDocument $dom2): array
    {
        return [
            'elements_count_1' => self::countElements($dom1),
            'elements_count_2' => self::countElements($dom2),
            'attributes_count_1' => self::countAttributes($dom1),
            'attributes_count_2' => self::countAttributes($dom2),
            'text_nodes_count_1' => self::countTextNodes($dom1),
            'text_nodes_count_2' => self::countTextNodes($dom2),
        ];
    }

    /**
     * Count elements in DOM document
     */
    private static function countElements(DOMDocument $dom): int
    {
        $xpath = new DOMXPath($dom);
        return $xpath->query('//*')->length;
    }

    /**
     * Count attributes in DOM document
     */
    private static function countAttributes(DOMDocument $dom): int
    {
        $xpath = new DOMXPath($dom);
        return $xpath->query('//@*')->length;
    }

    /**
     * Count text nodes in DOM document
     */
    private static function countTextNodes(DOMDocument $dom): int
    {
        $xpath = new DOMXPath($dom);
        return $xpath->query('//text()[normalize-space(.) != ""]')->length;
    }
}
