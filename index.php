<?php

    try{
        require("./SendWebexMessage.php");
        
        echo "Email: ";
        $email = trim(fgets(STDIN));
        echo "Message: ";
        $message = trim(fgets(STDIN));
        
        $SendMsg = new SendWebexMessage($email ,$message);
        $SendMsg->send();
    
    }
    catch(Exception $e){
        echo $e->getMessage()."\n";
    }
    finally{
        
    }
?>