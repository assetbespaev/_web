<?php require ("./login/includes/config.php"); ?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div id="register-body">
            <?php
            if (isset($_GET['action'])) {
                switch (strtolower($_GET['action'])) {
                    case 'register':
                        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['username'])) {
                            if (createAccount($_POST['username'], $_POST['phone'], $_POST['email'], $_POST['password'])) {
                                ?>
                                <h1>Account Created</h1><br />Your account has been created. You can now login <a href="login.php">here</a>.
                                <?
                            } else {
                                unset($_GET['action']);
                            }
                        } else {
                            $_SESSION['error'] = "Username and or Password was not supplied.";
                            unset($_GET['action']);
                        }

                        break;
                }
            }

            if (loggedIn()) {
                ?>
                <h2>Already Registered</h2> 
                You have already registered and are currently logged in as: ' . $_SESSION['username'] . '. 
                <h4>Would you like to <a href="login.php?action=logout">logout</a>?</h4> 
                <h4>Would you like to go to <a href="index.php">site index</a>?</h4>
                <?
            } elseif (!isset($_GET['action'])) {
                $sEmail = "";
                if (isset($_POST['email'])) {
                    $sEmail = $_POST['email'];
                }
                $sUsername = "";
                if (isset($_POST['username'])) {
                    $sUsername = $_POST['username'];
                }
                ?>
                <h2>Register for this site</h2> 
                <span id="error"> <? echo $_SESSION['error']; ?></span><br />
                <form name="register" method="post" action="<? $_SERVER['PHP_SELF'] ?>?action=register">
                    Username: <input type="text" name="username" value="<? $sUsername?>" /><br /> 
                    E-mail: <input type="email" name="email" value="<? $sEmail?>" /><br /> 
                    Phone: <input type="tel" name="phone" value=""/><br/>
                    Password: <input type="password" name="password" value="" /><br /><br /> 
                    <input type="submit" name="submit" value="Register!" /> 
                </form> 
                <br /> 
                <h4>Would you like to <a href="login.php">login</a>?</h4>
                <?
            }
            ?>

        </div>
    </body>
</html>
