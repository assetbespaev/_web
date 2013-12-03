<?php
    function createAccount($pUsername, $pPhone,$pEmail, $pPassword) {
        if(!empty($pUsername) && !empty($pPassword)&& !empty($pPhone)&& !empty($pEmail)){
            
            $uLen = strlen($pUsername);
            $pLen = strlen($pPassword);
            
            $eLen = strlen($pEmail);
            $phLen = strlen($pPhone);
            
            $eEmail = mysql_real_escape_string($pEmail);
            $eUsername = mysql_real_escape_string($pUsername);
            $ePhone = mysql_real_escape_string($pPhone);
            
            $sql = "SELECT email FROM users WHERE email = '" . $eEmail . "' LIMIT 1";
            
            $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error()); 
            
            if($uLen <= 4 || $uLen >= 11){
                $_SESSION['error'] = "Username must be between 4 and 11 characters."; 
            }  elseif ($pLen < 6) {
                $_SESSION['error'] = "Password must be longer then 6 characters.";
            }  elseif (mysql_num_rows($query) == 1) {
                $_SESSION['error'] = "Username already exists."; 
            }elseif($phLen !=10){
                $_SESSION['error'] = "Phone number must be equal to  10 digit."; 
            }else{
                $pHash =  hashPassword($pPassword, SALT1, SALT2);
                $sql = "INSERT INTO users (username, password,email,phone_numb) VALUES ('" . $eUsername . "', '" . $pHash  ."', '".$eEmail ."', '".$ePhone."');"; 
                $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error()); 
                
                if($query){
                    return true;
                }
            }
        }
        
        return false;
    }
    
    function hashPassword($pPassword1,$pSalt1='2345#$%@3e', $pSalt2='taesa%#@2%^#') {
        $psha1 = sha1(md5($pSalt2 . $pPassword1 . $pSalt1));
        return $psha1; 
    } 
    
    
    function loggedIn() {
        if(isset($_SESSION['loggedin']) && isset($_SESSION['username'])&& isset($_SESSION['email'])){
            return true;
        }
        return false;
    }
    
    function logoutUser() {
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['loggedin']);
        
        return true;
    }
    
    function validateUser($pEmail,$pPassword) {
        $eEm = mysql_real_escape_string($pEmail);
        
        $hP = hashPassword($pPassword, SALT1,   SALT2);
       
        
        $sql = "SELECT username,email FROM users  WHERE email = '" . $eEm . "' AND password = '" . $hP . "' LIMIT 1"; 
        
        $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
        
        if (mysql_num_rows($query) == 1) { 
            $row = mysql_fetch_assoc($query); 
            $_SESSION['username'] = $row['username']; 
            $_SESSION['email'] = $row['email']; 
            $_SESSION['loggedin'] = true; 
       
            return true;
            
        } 
   
        return false; 
    }
?>
