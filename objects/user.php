<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties

    public function __construct($db){
        $this->conn = $db;
    }
 
    public function simpanUser($nama, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        
        $query = "INSERT INTO " . $this->table_name . " 
                    (unique_id, nama, email, encrypted_password, salt) 
                        VALUES(:uuid, :nama, :email, :pass, :salt)";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":uuid", $uuid);
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pass", $encrypted_password);
        $stmt->bindParam(":salt", $salt);

        $result = $stmt->execute();
 
        // cek jika sudah sukses
        if ($result) {

            $query = "SELECT * FROM " . $this->table_name . "  WHERE email = :email";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
            return $user;
        } else {
            return false;
        }
    }
 
    /**
     * Get user berdasarkan email dan password
     */
    public function getUserByEmailAndPassword($email, $password) {
        
        $query = "SELECT * FROM " . $this->table_name . "  WHERE email = :email";
 
        $stmt = $this->conn->prepare($query);
 
        $stmt->bindParam(":email", $email);
 
        if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);;
 
            // verifikasi password user
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // cek password jika sesuai
            if ($encrypted_password == $hash) {
                // autentikasi user berhasil
                return $user;
            }
        } else {
            return NULL;
        }
    }
 
    /**
     * Cek User ada atau tidak
     */
    public function isUserExisted($email) {
        $this->$email = $email;

        $query = "SELECT email from " . $this->table_name . " WHERE email = :email";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":email", $this->$email);
        $stmt->execute();
 
        if ($stmt->rowCount() > 0) {
            // user telah ada 
            return true;
        } else {
            // user belum ada 
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
    
}
?>