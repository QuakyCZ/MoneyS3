<?php

namespace eProduct\MoneyS3\Test\Exception;

use eProduct\MoneyS3\Exception\MoneyS3Exception;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MoneyS3ExceptionTest extends TestCase
{
    public function testExceptionInheritance(): void
    {
        $exception = new MoneyS3Exception('Test message');
        
        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertInstanceOf(MoneyS3Exception::class, $exception);
    }

    public function testExceptionMessage(): void
    {
        $message = 'Test exception message';
        $exception = new MoneyS3Exception($message);
        
        $this->assertEquals($message, $exception->getMessage());
    }

    public function testExceptionCode(): void
    {
        $code = 123;
        $exception = new MoneyS3Exception('Test message', $code);
        
        $this->assertEquals($code, $exception->getCode());
    }

    public function testExceptionPreviousException(): void
    {
        $previous = new \Exception('Previous exception');
        $exception = new MoneyS3Exception('Test message', 0, $previous);
        
        $this->assertSame($previous, $exception->getPrevious());
    }

    public function testExceptionCanBeThrown(): void
    {
        $this->expectException(MoneyS3Exception::class);
        $this->expectExceptionMessage('Test exception');
        
        throw new MoneyS3Exception('Test exception');
    }

    public function testExceptionCanBeCaught(): void
    {
        try {
            throw new MoneyS3Exception('Test exception');
        } catch (MoneyS3Exception $e) {
            $this->assertEquals('Test exception', $e->getMessage());
            return;
        }
        
        $this->fail('Exception should have been caught');
    }
}
