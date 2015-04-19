<?php

require_once 'config.php';
$mysql = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';


if ($mysql->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
}

$seqquery = "select max(chat_seq) as seq from chat_log;";
$result = mysqli_query($mysql, $seqquery);
	//puts the resulting columns in an array
	$row = mysqli_fetch_array($result);
	//grabs from the array fields into variables
	$chatseq = $row['seq'];
$updatequery = "SELECT user_username, chat_date, chat_message 
FROM user_info join chat_log on user_info.user_info_seq = chat_log.chat_user_seq
where chat_seq = '$chatseq'
limit 1";
if ($result = mysqli_query($mysql, $updatequery)){
while ($row = mysqli_fetch_assoc($result)){
        $name = $row{'user_username'};
        $date = $row{'chat_date'};
		$message = $row{'chat_message'};
        $log[] = array('name' => $name, 'date' => $date, 'message' => $message);
echo json_encode($log);

}
}
	/*get the last updated chat log row's date to use in the next query
		$firstquery = "select max(chat_seq) as seq from chat_log;";
	$result = mysqli_query($mysql, $firstquery);
	//puts the resulting columns in an array
	$row = mysqli_fetch_array($result);
	//grabs from the array fields into variables
	$chatseq = $row['seq'];
	
	echo $chatseq."</br>";
	$datequery = "SELECT chat_date
FROM chat_log
where chat_seq = '$chatseq'";
	$result = mysqli_query($mysql, $datequery);
	//puts the resulting columns in an array
	$row = mysqli_fetch_array($result);
	//grabs from the array fields into variables
	$date = $row['chat_date'];
	echo $date;
	$query = "SELECT user_username, chat_date, chat_message 
FROM chat_update
where chat_date = '$date'";
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
    echo "Whoops!  There was an error error running this query". $mysq->connect_error;
} */
?>
