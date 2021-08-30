<?php                        
    function setSession($id, $username, $roles){                        
        session_start();                
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["roles"] = $roles;        
    }

    function endSession(){    
        session_start();          
        session_destroy();
    }
    
