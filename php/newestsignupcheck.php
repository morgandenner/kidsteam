<?php

require_once 'config.php';
$mysql = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';
session_start();


$username = $_GET["email"];
$confirm = $_GET["confirm"];
$pass = $_GET["password"];
$fname = $_GET["fname"];
$lname = $_GET["lname"];


//set default timezone of the server
date_default_timezone_set('America/New_York');
//set the default character set in order to use //mysqli::real_escape_string


if (empty($username) || empty($pass) || empty($confirm) || empty($fname) || empty($lname)){
    //if something in the form is missing, send a message indicating the user needs to look back at their form to re-enter
    echo "Whoops! Looks like you forgot some info below.</br>";
    //send a response based on what the user missed
    if (empty($username)){
        echo "Please enter username.</br>";
    }else if (empty($pass)){
        echo "Please enter password.</br>";
    }else if (empty($confirm)){
        echo "Please enter confirm.</br>";
    }else if (empty($fname)){
        echo "Please enter first name.</br>";
    }else if (empty($lname)){
        echo "Please enter last name.</br>";
    }
}else{
    //everything was put into the form
    //sanitize all input
    echo $pass."</br>";
	echo $confirm."</br>";
    //prepare the statement to match any usernames in the database
     $prep_stmt = "SELECT user_username FROM user_info WHERE user_username = ?";
    $stmt = $mysql->prepare($prep_stmt);
    if ($stmt){

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1){
            //another user exists with the same username
            echo "The username ".$username." is taken. Please choose another username for your account.</br>";
        }else {
            //no current user has the same username
            if ($pass !== $confirm){
                //passwords do not match
                echo "Passwords do not match.</br>";
            }else{
                //passwords match
				echo "passwords match</br>";
                if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $fname)){
                    //names have special characters or numbers in them
                    echo "names can only have letters in them!</br>";
                }else{
                    //names have only letters
                    if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $lname)){
                        //last name has special characters in it    
                        echo "last name has special characters in it!</br>";              
                    }else{
                        //last name does not have special characters in it
                        if (preg_match('/^[[:alnum:]]+$/', $username))
                        {    
                        //username has no special characters in it
                            //assign a random 6 digit string used in conjunction with the hashed password called a salt
                            $text = md5(uniqid(rand(), true));
                            $dbsalt = substr($text, 0, 6);
							echo "db salt ".$dbsalt."</br>";
                            //contactenate the salt and hashed password
                            $dbhash = hash('sha512', $dbsalt.$pass);
							echo "hash ".$dbhash."</br>";
							echo "passwords match</br>";
                            //preparing the insert query into USER_INFO
                            $user_prep = "INSERT INTO user_info                  
                            (user_username, 
                            user_first_name, 
                            user_last_name,
                            user_creation_date, 
                            user_salt) 
                            VALUES 
                            (?, ?, ?, now(), ?)";
                            //preparing the insert query into USER_PWD
                            $insert_user = $mysql->prepare($user_prep);
                            if (!$insert_user){
                            //statement was not prepared
                                echo "Prepare failed: (" . $mysql->errno . ") " . $mysql->error;
                            }else {
                            //statement was prepared

                                if (!$insert_user->bind_param('ssss', $username, $fname, $lname, $dbsalt)){
                                //statement not bound
                                    echo "Binding parameters failed: (" . $insert_user->errno . ") " . $insert_user->error;
                                }else{
                                //statement bound

                                    if (!$insert_user->execute()){
                                    //statement not executed
                                        echo "Execute failed: (" . $insert_user->errno . ") " . $insert_user->error;
                                    }else{
                                    //statement executed

                                        //pulls the last inserted user sequence from the db
                                        $seq = mysqli_insert_id($mysql);
                                        //prepares the query to input into the USER_PWD table
                                        $pass_prep = "INSERT INTO user_pwd
                                        (
                                        pwd_user_info_seq,
                                        pwd_encrypt
                                        )
                                        VALUES
                                        (?, ?)";
                                        $insert_pwd=$mysql->prepare($pass_prep);
                                        if (!$insert_pwd){
                                        //not prepared
                                            echo "Prepare failed: (" . $mysql->errno . ") " . $mysql->error;
                                        }else{
                                        //prepared
                                            if (!$insert_pwd->bind_param("is", $seq, $dbhash)) {
                                                //not bound
                                                echo "Binding parameters failed: (" . $insert_pwd->errno . ") " . $insert_pwd->error;
                                            }else{
                                                //bound
                                    
                                                if (!$insert_pwd->execute()) {
                                                    //password query not executed
                                                    echo "Execute failed: (" . $insert_pwd->errno . ") " . $insert_pwd->error;
                                                }else{
                                                    //executed password
                                                    $insert_pwd->close();
                                                    //now the password table and user tables are populated with the 
                                                    //new user, and we must update login_information
                                                    //for the correct 
                                                    //prepares the insert query into the LOGIN_INFORMATION table
                                                    $prep_login="INSERT INTO login_information
                                                    (
                                                    login_user_id,
                                                    login_last_login,
                                                    user_is_online
                                                    )
                                                    VALUES
                                                    (?, now(), TRUE)";
                                                    $insert_login=$mysql->prepare($prep_login);
                                                    if (!$insert_login){
                                                    //not prepared
                                                        echo "Prepare failed: (" . $mysql->errno . ") " . $mysql->error;
                                                        $insert_login->close();
                                                    }else{
                                                    //prepared
                                                   
                                                        if (!$insert_login->bind_param("i", $seq)){
                                                        //not bound
                                                            echo "Binding parameters failed: (" . $insert_login->errno . ") " . $insert_login->error;
                                                            $insert_login->close();
                                                        }else{
                                                        //bound
                                                        
                                                            if (!$insert_login->execute()){
                                                            //not executed
                                                                echo "Execute failed: (" . $insert_login->errno . ") " . $insert_login->error;
                                                                $insert_login->close();
                                                            }else{
                                                            //executed
                                                            $insert_login->close();
                                                            }
                                                        }
                                                    }
                                                
                                                    
                                                }
                                            }
                                        }
                                        $insert_user->close();
                                    }
                                }
                            }
                        }else {
                            //username has special characters
                            echo "Your username shouldn't contain any special characters!";
                        }
                    }
                }
            }
        }
    }else {
    //error preparing statement
    echo "Could not prepare statement". $mysql->error;
    }
}

function clean($string) {
    return preg_replace('/[^a-z0-9 -]+/', '', $string); 
    // Removes special chars.
}

?>
