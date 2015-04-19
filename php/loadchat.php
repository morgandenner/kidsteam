<?php

require_once 'config.php';
$mysql = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';


if ($mysql->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
}

//initialize a session variable to track the changes made in the chat_log database table 

	
$query = "SELECT user_username, chat_date, chat_message 
FROM chat_update
where chat_date >= curdate() order by chat_date asc";

if ($result = mysqli_query($mysql, $query)){
    //mysql successfully 
    while ($row = mysqli_fetch_assoc($result)){
        $name = $row{'user_username'};
        $date = $row{'chat_date'};
		$message = $row{'chat_message'};
        $data[] = array('name' => $name, 'date' => $date, 'message' => $message);
    }
    echo json_encode($data);
}else{
    //error retrieving
    echo "Whoops!  There was an error error retrieving who's online!". $mysq->connect_error;
}



?>
