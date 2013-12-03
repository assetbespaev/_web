<?php
    require('./login/includes/config.php') ;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
         <?php
        if (isset($_GET['action'])) {
            switch (strtolower($_GET['action'])) {
                case 'login':
                    if (isset($_POST['email']) && isset($_POST['password'])) {

                        if (!validateUser($_POST['email'], $_POST['password'])) {
                            $_SESSION['error'] = "Bad email or password supplied.";
                            unset($_GET['action']);
                        }
                    } else {
                        $_SESSION['error'] = "Email and Password are required to login.";
                        unset($_GET['action']);
                    }
                    break;

                case 'logout':
                    if (loggedIn()) {
                        logoutUser();
                        ?>
                        <h1>Logged out!</h1>
                        <br/>You have   been logged out successfully.
                        <br/><h4>Would you like to go to <a href="index.php">site index</a></h4>
                        <?
                    } else {
                        unset($_GET['action']);
                    }
                    break;
            }
        }
        ?>
        <div id="index-body">
            <?
            if (loggedIn()) {
                ?>
                <h1>Logged In!</h1><br/><br/>
                hello <? echo $_SESSION['username'] . " " . $_SESSION['email']; ?> how are you today<br/><br/>
                <h4>Would you like to <a href="login.php?action=logout">logout</a> ?</h4>
                <h4>Would you like to <a href="index.php?action=logout">site index</a> ?</h4>
                <?
            } elseif (!isset($_GET['action'])) {
                $sEmail = "";
                if (isset($_POST['email'])) {
                    $sEmail = $_POST['email'];
                }
                ?>
                <h2>Login to our site</h2>
                <div id ="login-form">
                    <? if (isset($_SESSION['error'])) { ?>
                        <span id="error"> <? $_SESSION['error'] ?> </span><br />
                    <? } ?>
                    <form name="login" method="post" action="login.php?action=login">
                        Email:<input type="text" name="email" value="<? $sEmail ?>"/><br/>
                        Password: <input type="password" name="password" value="" /><br/><br/> 
                        <input type="submit" name="submit" value="Login!"/>
                    </form>

                </div>
                <h4>Would you like to <a href="login.php">login</a>?</h4> 
                <h4>Create a new <a href="register.php">account</a>?</h4>
        </div>
            <?
        }
        ?>
    </body>
</html>
