<?php

require_once 'config.php';
$mysql = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';

if ($mysql->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysql->connect_errno . ") " . $mysq->connect_error;
}

$query = "SELECT user_username, login_last_login from show_online WHERE user_is_online = 1";
if ($result = mysqli_query($mysql, $query)){
    //mysql successfully 
    while ($row = mysqli_fetch_assoc($result)){
        $name = $row{'user_username'};
        $date = $row{'login_last_login'};
        $data[] = array('name' => $name, 'date' => $date);
    }
    echo json_encode($data);
}else{
    //error retrieving
    echo "Whoops!  There was an error error retrieving who's online!". $mysq->connect_error;
}
?>
