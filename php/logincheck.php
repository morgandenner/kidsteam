<?php
require_once 'config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';
    //login status defaults to logged out
    $status = "out";
    // Check if all session variables are set 
    if (isset($_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 		
        if ($stmt = $mysql->prepare("SELECT pwd_encrypt 
                                    FROM login_check 
                                    WHERE user_username = ?")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('s', $username);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! Shows the menu plus "logout" and "my profile"
                    $_POST['status'] = "in";
                    echo "in";
                    
                    
                } else {
                    // Not logged in shows only "login" and "join"
                    $_POST['status'] = "out";
                    echo "out";
                    
                }
            } else {
                // Not logged in 
                $_POST['status'] = "out";
                echo "out";
            }
        } else {
            // Not logged in 
            echo "out";
        }
    } else {
        // Not logged in 
        echo "out";
    }

?>
