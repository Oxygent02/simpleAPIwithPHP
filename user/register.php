<?php 

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
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

if( !is_null($data) ){ //input via raw file
    
    if(
        !empty($data->nama) &&
        !empty($data->email) &&
        !empty($data->password)
    ){
     
        // menerima parameter POST ( nama, email, password )
        $nama = $data->nama;
        $email = $data->email;
        $password =$data->password;
     
        // Cek jika user ada dengan email yang sama
        if ($user->isUserExisted($email)) {
            // user telah ada
            $response["error"] = TRUE;
            $response["error_msg"] = "User telah ada dengan email " . $email;
            echo json_encode($response);
        } else {
            // buat user baru
            $user = $user->simpanUser($nama, $email, $password);
            if ($user) {
                // simpan user berhasil
                $response["error"] = FALSE;
                $response["uid"] = $user["unique_id"];
                $response["user"]["nama"] = $user["nama"];
                $response["user"]["email"] = $user["email"];
                echo json_encode($response);
            } else {
                // gagal menyimpan user
                $response["error"] = TRUE;
                $response["error_msg"] = "Terjadi kesalahan saat melakukan registrasi";
                echo json_encode($response);
            }
        }
    } 
    else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Parameter (nama, email, atau password) ada yang kurang";
        echo json_encode($response);
    }

}
else{ //input via form data

    if (isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['password'])) {
     
        // menerima parameter POST ( nama, email, password )
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = $_POST['password'];
     
        // Cek jika user ada dengan email yang sama
        if ($user->isUserExisted($email)) {
            // user telah ada
            $response["error"] = TRUE;
            $response["error_msg"] = "User telah ada dengan email " . $email;
            echo json_encode($response);
        } else {
            // buat user baru
            $user = $user->simpanUser($nama, $email, $password);
            if ($user) {
                // simpan user berhasil
                $response["error"] = FALSE;
                $response["uid"] = $user["unique_id"];
                $response["user"]["nama"] = $user["nama"];
                $response["user"]["email"] = $user["email"];
                echo json_encode($response);
            } else {
                // gagal menyimpan user
                $response["error"] = TRUE;
                $response["error_msg"] = "Terjadi kesalahan saat melakukan registrasi";
                echo json_encode($response);
            }
        }
    } 
    else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Parameter (nama, email, atau password) ada yang kurang";
        echo json_encode($response);
    }
}
?>