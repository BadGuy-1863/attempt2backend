<?php


require_once 'DatabaseConnect.php';

$username = $password = "";
$data = json_decode(file_get_contents("php://input"), true);
$response = array();
$_POST['username'] = $data["username"];
$_POST['password'] = $data["password"];


if($_SERVER["REQUEST_METHOD"]=="POST"){

	if (isset($_POST['username']) && isset($_POST['password'])){
		$username =	$data['username'];
		$password = $data['password'];


		$db = new DatabaseConnect();
		$con = $db->connect();

		if($result = mysqli_query($con, "SELECT id, username, password FROM users WHERE username = '$username'")){

    	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$hashed_pass = $row["password"];
			if(password_verify($password, $hashed_pass)){
				$response["success"] = 1;
				$response["message"] = "login successful";
			} else {
				$response["success"] = 0;
				$response["message"] = "incorrect password";
			}
		} else {
			$response["success"] = 0;
			$response["message"] = "username not found";
		}

		echo json_encode($response);

	} else {
		$response["success"] = 0;
		$response["message"] = "missing field";
		echo json_encode($response);
	}
}

?>
