<?php
/**
 * Tests SendWebexMessage for bad code. (?) Currently only the setMessage() function.
 * 
 * @category Project
 * @package  Ka
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     Ka
 */
    use PHPUnit\Framework\TestCase;

    require "SendWebexMessage.php";

/**
 * Test class
 * 
 * @category Project
 * @package  Ka
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     Ka
 */
final class SendWebexMessageTest extends TestCase
{
    /**
     * Tests setMessage for its core function
     * 
     * @return void
     */
    public function testSetMessage(): void
    {
        $SendMsg = new SendWebexMessage();
        
        $SendMsg->setMessage("Test");

        $this->assertSame("Test", $SendMsg->getMessage());
    }

    /**
     * Tests setMessage for the max sign limit for one message
     * 
     * @return void
     */
    public function testMessageLength(): void
    {
        $SendMsg = new SendWebexMessage();
        
        $str = str_repeat("a", 256);
        $this->expectException(Exception::class);
        $SendMsg->setMessage($str);
    }
}
?>
