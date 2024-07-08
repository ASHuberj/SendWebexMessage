<?php
/**
 * Manages a mysql database for storing all messages sent and prints them to the console in table format
 *
 * @category Project
 * @package  Ka
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     Ka
 */

    /**
     * Sending a message will be recorded in a sql-database
     * 
     * @category Project
     * @package  Ka
     * @author   Joseph Huber <joseph.huber@aspiria.com>
     * @license  https://pseudolicense.com pseudolicense
     * @link     Ka
     */
class MsgHistory
{
    const SQLSERVERIP = "127.0.0.1";
    const USER = "historian";
    const PASSWORD = "temp.aspiria123";
    const DATABASE = "msgHistory";
    private $_dbLink;
        
    /**
     * Stores reciever and message in database
     * 
     * @param string $reciever the reciever of the message
     * @param string $text     the text sent
     * 
     * @return void
     */
    public function storeMessage(string $reciever, string $text): void
    {
        $_dbLink = mysqli_connect(self::SQLSERVERIP, self::USER, self::PASSWORD, self::DATABASE) or throw new Exception("DB connection error: ".$_dbLink::$error($_dbLink));
        $result = mysqli_query($_dbLink, "INSERT INTO messages(`user`, `message`) VALUES ('$reciever','$text');");
        if (!$result) {
            throw new Exception("Insert msg in DB error: ".mysqli_error($_dbLink));
        }
        mysqli_close($_dbLink);
    }

    /**
     * Prints id, reciever and message from database to console in table format
     * 
     * @return void
     */
    public function printMessages(): void
    {
        $_dbLink = mysqli_connect(self::SQLSERVERIP, self::USER, self::PASSWORD, self::DATABASE) or throw new Exception("DB connection error: ".$_dbLink::$error($_dbLink));
        $result = mysqli_query($_dbLink, "SELECT * FROM messages;");
        $tbl = new Console_Table();
        while ($row = mysqli_fetch_assoc($result)) {
            $tbl->setHeaders(array('id', 'mail','message'));
            $tbl->addRow($row);
        }
        echo $tbl->getTable();

        if (!$result) {
            throw new Exception("Print contents error: ".mysqli_error($_dbLink));
        }
            
        mysqli_close($_dbLink);
    }
}

?>
