<?php
    /**
     * Sending a message will be recorded in a sql-database
     * 
     * 
     */
    class MsgHistory{
        const SQLSERVERIP = "127.0.0.1";
        const USER = "historian";
        const PASSWORD = "temp.aspiria123";
        const DATABASE = "msgHistory";
        private $dbLink;
        
        public function __construct(){
            // $this->dbLink = mysqli_connect(self::SQLSERVERIP, self::USER, self::PASSWORD, self::DATABASE) or throw new Exception("DB connection error: ".$this->dbLink::$error($this->dbLink));
        }
        
        public function storeMessage(string $reciever, string $text): void{
            $dbLink = mysqli_connect(self::SQLSERVERIP, self::USER, self::PASSWORD, self::DATABASE) or throw new Exception("DB connection error: ".$dbLink::$error($dbLink));
            $result = mysqli_query($dbLink, "INSERT INTO messages(`user`, `message`) VALUES ('$reciever','$text');");
            if(!$result){
                throw new Exception("Insert msg in DB error: ".mysqli_error($dbLink));
            }
            mysqli_close($dbLink);
        }
        public function printMessages(): void{
            $dbLink = mysqli_connect(self::SQLSERVERIP, self::USER, self::PASSWORD, self::DATABASE) or throw new Exception("DB connection error: ".$dbLink::$error($dbLink));
            $result = mysqli_query($dbLink, "SELECT * FROM messages;");
            $tbl = new Console_Table();
            while($row = mysqli_fetch_assoc($result)){
                // print_r($row);


                $tbl->setHeaders(array('id', 'mail','message'));

                $tbl->addRow($row);

            }
            echo $tbl->getTable();

            if(!$result){
                throw new Exception("Print contents error: ".mysqli_error($dbLink));
            }
            
            mysqli_close($dbLink);
        }
    }

?>