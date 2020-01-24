<?php


require_once 'DatabaseConnect.php';

$username = $password = $email = "";
$data = json_decode(file_get_contents("php://input"), true);
$response = array();
$_POST['username'] = $data["username"];
$_POST['password'] = $data["password"];
$_POST['email'] = $data["email"];


if($_SERVER["REQUEST_METHOD"]=="POST"){

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];


        $db = new DatabaseConnect();
        $con = $db->connect();

        if($result = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'")){
            if(mysqli_num_rows($result) > 0){
                //username already exists
                $response["success"] = 0;
                $response["message"] = "username already in use";
            } else {
                //username not in use
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$param_password', '$email')";
                if($res = mysqli_query($con, $sql)){
                    $response["success"] = 1;
                    $response["message"] = "registration successful";
                } else {
                    $response["success"] = 0;
                    $response["message"] = "something went wrong";
                }
            }
    } else {
        $response["success"] = 0;
        $response["message"] = "missing field";
    }
}

}
echo json_encode($response);
?>
