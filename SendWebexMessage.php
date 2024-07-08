<?php
/**
 * Creating a class, which object can send messages to a specified target 
 * 
 * @category Ka
 * @package  Ka
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     Ka
 */


include "./history.php";

/**
 * Allows to build and send messages over the Webex api to a specified user.
 * 
 * @category Ka
 * @package  Ka
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     Ka
 */
class SendWebexMessage
{
    /**
     * URL to Webex api
     */
    const URL = "https://webexapis.com/v1/messages";
    /**
     * Valid token, to send the message with.
     */
    const TOKEN = "M2IxNmVmM2UtOGIwZi00OGVkLWE5NmMtYmRiMjY0NTU1NjJhMmFmYjk2NTgtZTRh_PF84_2dab1fc3-8a75-41c0-8f60-f3f0f8b4c5ff";
    private $_message = "";
    private $_email = "";

    /**
     * Gets the currently set mail-address.
     *
     * @return string   $_email    current mail-address
     */
    public function getMail():string
    {
        return $this->_email;
    }
        
        
    /**
     * Sets a new mail and validates, if there is a @ inbetween of charactares
     *
     * @param string $newMail a new mail-address
     * 
     * @return void
     */
    public function setMail(string $newMail):void
    {
        $regexPattern = '/^[\.\w-]+@([\w-]+\.)+[\w-]{2,4}$/';
        if (preg_match($regexPattern, $newMail)) {
            $this->_email = $newMail;
        } else{
            throw new Exception("\nInvalid e-mail!");
        }
    }

        
    /**
     * Gets the currently set message.
     *
     * @return string   $_message    current message
     */
    public function getMessage(): string
    {
        return $this->_message;
    }
        
        
    /**
     * Sets a new message and validates, if it is max 255 charactares long
     *
     * @param string $newMessage a new message
     *
     * @return void
     */
    public function setMessage(string $newMessage):void
    {
        if (strlen($newMessage) <= 255) {
            $this->_message = $newMessage;
        } else {
            throw new Exception("Message can only be 255 charactares long!");
        };
    }
        
        
    /**
     * Sends out the message to the set mail.
     * If successful prints "Success!", if not errormessage.
     * 
     * @return void
     */
    public function send():void
    {
        $ch = curl_init();
            
        $data = [
            "text" => $this->getMessage(),
            "toPersonEmail" => $this->getMail()
        ];
            
        $jsonData = json_encode($data);
            
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ". self::TOKEN
        ];

        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        try{
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode >= 400) {
                $responseJson = json_decode($response, true);
                $_message = isset($responseJson["message"]) ? $responseJson["message"] : "unkown error" ;
                    
                throw new Exception("httpCode: $httpCode\nerror message: $_message\n");
            }
            
            try {
                $history = new MsgHistory();
    
                $history->storeMessage($this->getMail(), $this->getMessage());
                print_r($history->printMessages());          
                
            } catch (Exception $e) {
                echo $e->getMessage()."\n";
            }
        }
        finally{
            curl_close($ch);
        }
    }
}
?>
