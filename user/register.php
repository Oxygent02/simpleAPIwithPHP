<?php 

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
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
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Parameter (nama, email, atau password) ada yang kurang";
    echo json_encode($response);
}
?>