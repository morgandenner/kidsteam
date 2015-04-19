<?php

require_once 'config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';

/*This function will be called on every page to 
start a secure session for users.  This prevents 
session hijacking and other attacks.  Code on this page
can be found at 
http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
*/
//login process
sec_session_start();

//post variables from AJAX
$email = $_GET["email"];
$pass= $_GET["password"];

//hash the input password for database validation

/*prepared statement that binds the PHP variables to
    generic values*/
    if ($stmt = $mysqli->prepare("SELECT user_info_seq, user_username, user_salt, pwd_encrypt
    FROM login_check 
    WHERE user_username = ?
    LIMIT 1;")) {
       if (!$stmt->bind_param('s', $email)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}  // Bind "$email" to parameter.
        if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($db_user_id, $db_username, $db_salt, $db_password);
        //fetch result
        $stmt->fetch();
       
        
        // hash the password with the unique salt.
        $proposed_password = hash('sha512', $db_salt . $pass);
        
        //if the user exists, check to make sure the proposed_password and the db_password match
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $proposed_password) {
                    
                    // Password is correct!
                    //prepare a query to update the table login_information with user_is_online and login_last_login
                    $prep_login = "INSERT INTO login_information
                        (login_user_id,
                        login_last_login,
                        user_is_online)
                        VALUES (?, now(), TRUE)";
                    $insert= $mysqli->prepare($prep_login);
                    if (!$insert){
                                                    //not prepared
                                                        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                        $insert->close();
                                                    }else{
                                                    //prepared
                                                   
                                                        if (!$insert->bind_param("i", $seq)){
                                                        //not bound
                                                            echo "Binding parameters failed: (" . $insert->errno . ") " . $insert->error;
                                                            $insert->close();
                                                        }else{
                                                        //bound
                                                        
                                                            if (!$insert->execute()){
                                                            //not executed
                                                                echo "Execute failed: (" . $insert->errno . ") " . $insert->error;
                                                                $insert->close();
                                                            }else{
                                                            //executed
                                                            $insert->close();
                                                            }
                                                        }
                                                    }
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    //clears any special characters from the string
                    $db_user_id = preg_replace("/[^0-9]+/", "", $db_user_id);
                    $_SESSION['user_id'] = $db_user_id;
                    // XSS protection as we might print this value
                    //clears any special characters from the string
                    $db_username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $db_username);
                    
                    //assigns sessions for username and contactenated login string for session use
                    $_SESSION['username'] = $db_username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $proposed_password . $user_browser);
                	echo "login successful";
                    // Login successful.
                    $url= 'http://127.0.0.1/landingkt.html';
                    //redirect to the landing page
                    header('Location:/landingkt.html');
                    $stmt->close();
                } else {
                    // Password is not correct
                    // We record this attempt in the database
					echo "salt ".$db_salt;
					echo "user password: ".$db_password."</br>";
					echo "db password: ".$proposed_password."</br>";
					
                                        echo "Username or password did not match.  Please try again!";
                    
                    //header('Location: ../protected_page.php');
                }
            
        } else {
            // No user exists.
        echo "Our records show no username exists for that";
        }
    }

//
//
//
//
//
//
//
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();// Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}
//
//
//
//
//
//

?>
