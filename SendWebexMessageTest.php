<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class SendWebexMessageTest extends TestCase
{
    public function testSetMessage(): void{
        $SendMsg = new SendWebexMessage();
        $SendMsg->setMessage("Test");
        $this->assertSame("Test", $SendMsg->getMessage());
    }
    
    
}
class ExceptionTest extends TestCase{
    public static function ExceptionTest(): void{
        $str = str_repeat("a",256);
        $SendMsg->setMessage($str);
        $this->expectException();
    }
    public function expectException(): void{
        // If no String is handed over as parameter, but any other type
        $this->expectException(InvalidArgumentException::class);
    }
    
}