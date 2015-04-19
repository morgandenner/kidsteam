<?php

require_once 'config.php';
$mysql = new mysqli(HOST, USER, PASSWORD, DATABASE);
require_once 'connect.php';
require_once 'logincheck.php';


if ($mysql->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysql->connect_errno . ") " . $mysql->connect_error;
}

//initialize a session variable to track the changes made in the chat_log database table 
$message = $_GET['message'];
$user = $_SESSION['username'];
echo "hello</br>";
if (!isset($_SESSION['username'])){
	//if there is no username session variable set in logincheck.php, the user is not signed in for some strange reason, so the system logs the chat under "guest"
	$user = 'guest';
	echo $user;
	$userquery = "SELECT user_info_seq FROM user_info WHERE user_username = 'guest'";
	$result = mysqli_query($mysql, $userquery);
	//puts the resulting columns in an array
	$row = mysqli_fetch_array($result);
	//grabs from the array fields into variables
	$seq = $row['user_info_seq'];
	
	$messagequery="INSERT INTO chat_log
	(
	chat_user_seq,
	chat_date,
	chat_message
	)
	VALUES
	(?, now(), ?)";
	$insert_message=$mysql->prepare($messagequery);
	if (!$insert_message){
	//not prepared
		echo "Prepare failed: (" . $mysql->errno . ") " . $mysql->error;
		$insert_message->close();
	}else{
	//prepared
		if (!$insert_message->bind_param("is", $seq, $message)){
		//not bound
			echo "Binding parameters failed: (" . $insert_message->errno . ") " . $insert_message->error;
			$insert_message->close();
		}else{
		//bound
			if (!$insert_message->execute()){
			//not executed
				echo "Execute failed: (" . $insert_message->errno . ") " . $insert_message->error;
				$insert_message->close();
			}else{
			//executed
			echo "executed";
			$insert_message->close();
			//message sent into the database

}
}
				/*
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
*/
			}
		}else{
	//user is not signed in for some strange reason, so the system logs the chat under "guest"
	$userquery = "SELECT user_info_seq FROM user_info WHERE user_username = '$user'";
	if ($result = mysqli_query($mysql, $userquery)) {
	
	//puts the resulting columns in an array
	$row = mysqli_fetch_array($result);
	//grabs from the array fields into variables
	$seq = $row['user_info_seq'];
	echo $seq."</br>";
	}
	
	$messagequery="INSERT INTO chat_log
	(
	chat_user_seq,
	chat_date,
	uchat_message
	)
	VALUES
	(?, now(), ?)";
	$insert_message=$mysql->prepare($query);
	if (!$$insert_message){
	//not prepared
		echo "Prepare failed: (" . $mysql->errno . ") " . $mysql->error;
		$$insert_message->close();
	}else{
	//prepared

		if (!$$insert_message->bind_param("is", $seq, $message)){
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

?>
