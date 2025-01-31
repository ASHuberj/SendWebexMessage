<?php
/**
 * Sends message to webex user.
 *
 * @category Project
 * @package  Webexnachricht
 * @author   Joseph Huber <joseph.huber@aspiria.com>
 * @license  https://pseudolicense.com pseudolicense
 * @link     None
 */
try{
    include("./SendWebexMessage.php");
    require ('./vendor/autoload.php');
    echo "Email: ";
    $email = trim(fgets(STDIN));
    echo "Message: ";
    $message = trim(fgets(STDIN));
    $SendMsg = new SendWebexMessage();
    $SendMsg->setMail($email);
    $SendMsg->setMessage($message);
    $SendMsg->send();
}
catch(Exception $e){
    echo $e->getMessage()."\n";
}
finally{
        
}
?>
