<?php 

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);
 
// json response array
$response = array("error" => FALSE);

// get posted data via raw file
$data = json_decode(file_get_contents("php://input"));

if( !is_null($data) ){ 
    // input via raw file

    if(
        !empty($data->email) &&
        !empty($data->password)
    ){
 
        // menerima parameter POST ( email dan password )
        $email = $data->email;
        $password = $data->password;
     
        // get the user by email and password
        // get user berdasarkan email dan password
        $user = $user->getUserByEmailAndPassword($email, $password);
     
        if ($user != false) {
            // user ditemukan
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["nama"] = $user["nama"];
            $response["user"]["email"] = $user["email"];
            echo json_encode($response);
        } else {
            // user tidak ditemukan password/email salah
            $response["error"] = TRUE;
            $response["error_msg"] = "Login gagal. Password/Email salah";
            echo json_encode($response);
        }
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Parameter (email atau password) ada yang kurang";
        echo json_encode($response);
    }
}
else{
    // input via form data

    if (isset($_POST['email']) && isset($_POST['password'])) {
 
        // menerima parameter POST ( email dan password )
        $email = $_POST['email'];
        $password = $_POST['password'];
     
        // get the user by email and password
        // get user berdasarkan email dan password
        $user = $user->getUserByEmailAndPassword($email, $password);
     
        if ($user != false) {
            // user ditemukan
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["nama"] = $user["nama"];
            $response["user"]["email"] = $user["email"];
            echo json_encode($response);
        } else {
            // user tidak ditemukan password/email salah
            $response["error"] = TRUE;
            $response["error_msg"] = "Login gagal. Password/Email salah";
            echo json_encode($response);
        }
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Parameter (email atau password) ada yang kurang";
        echo json_encode($response);
    }
}
?>