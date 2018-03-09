
<?php 
include "ClassDatabase.php";

class USER{
	
	private $first_name;
    private $last_name;
    public $job_title;
    private $email;
    private $address_1;
    private $address_2;
    private $city;
    private $postal_code;
    private $province;
    private $country;
    private $phone;
    private $password;
	private $salt;
    private $date_of_birth;
    private $reset_password;
    private $disable;
	private $role_id;
    private $ts_inserted;
    private $user_inserted;
    private $dt_modified;
    private $user_modified;
    private $user_id;
    
	private static $database;
	
	function __construct($first_name , $last_name, $job_title, $email, 
                         $address_1, $address_2,$city, $postal_code, 
                         $province, $country, $phone, $password, $salt, 
                         $date_of_birth,  $disable = 0, $reset_password = 0,
                         $role_id = null, $ts_inserted = null, $user_inserted = null, 
                         $dt_modified = null, $user_modified = null, $user_id = null)
    {
        
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->job_title = $job_title;
        $this->email = $email;
        $this->address_1 = $address_1;
        $this->address_2 = $address_2;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->province = $province;
        $this->country = $country;
        $this->phone = $phone;
        $this->password = $password;
	    $this->salt = $salt;
        $this->date_of_birth = $date_of_birth;
        $this->reset_password = $reset_password;
        $this->disable = $disable;
	    $this->role_id = $role_id;
        $this->ts_inserted = $ts_inserted;
        $this->user_inserted = $user_inserted;
        $this->dt_modified = $dt_modified;
        $this->user_modified = $user_modified;
        $this->user_id = $user_id;
	}
	public static function Init_Database(){
		if(! isset(self::$database)){
			self::$database = new Database();
		}
	}
	
	
	
	public function Create(){
		$query = "INSERT INTO USERS(user_id, user_inserted , 
                         user_modified, first_name , last_name, 
						 job_title, email, address_1, address_2,city, postal_code, 
                         province, country, phone, password, salt, 
                         date_of_birth, disable, reset_password, 
                         role_id ) ";
		$query .= "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		self::Init_Database();
		
		try{
			$sql = self::$database->Connection->prepare($query);
            $sql->bindParam(1, $this->user_id);
            $sql->bindParam(2, $this->user_inserted);
            $sql->bindParam(3, $this->user_modified);               
            $sql->bindParam(4, $this->first_name);
            $sql->bindParam(5, $this->last_name);
            $sql->bindParam(6, $this->job_title);
            $sql->bindParam(7, $this->email);
            $sql->bindParam(8, $this->address_1);
            $sql->bindParam(9, $this->address_2);
            $sql->bindParam(10, $this->city);
            $sql->bindParam(11, $this->postal_code);
            $sql->bindParam(12, $this->province);
            $sql->bindParam(13, $this->country);
            $sql->bindParam(14, $this->phone);
            $sql->bindParam(15, $this->password);
	        $sql->bindParam(16, $this->salt);
            $sql->bindParam(17, $this->date_of_birth);
            $sql->bindParam(18, $this->disable);
            $sql->bindParam(19, $this->reset_password);
            $sql->bindParam(20, $this->role_id);
           
			
			$sql->execute();
			$last_id = self::$database->Connection->LastInsertId();
			
			return $last_id;
			
		}catch(PDOException $e){
			echo "Query INSERT Failed ".$e->getMessage();
		}
	}
	
	public static function Login($user_id, $password){
        $encrypted_password = self::Encrypt($password);
		$query  = "SELECT user_id FROM USERS ";
        $query .= "WHERE user_id = '$user_id' AND password = '$encrypted_password'";
		self::Init_Database();
		try{
			$sql = self::$database->Connection->prepare($query);
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_OBJ);
			
			return !empty($result->user_id);
			
		}catch(PDOException $e){
			echo "Query SELECT Failed ".$e->getMessage();
		}
	}
	public static function Email_Exists($email){
		$query = "SELECT user_id FROM USERS WHERE email = '$email' ";
		self::Init_Database();
		try{
			$sql = self::$database->Connection->prepare($query);
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_OBJ);
			
			return !empty($result->user_id);
		}catch(PDOException $e){
			echo "Query SELECT Failed ".$e->getMessage();
		}
	}
	
	public static function Get_User($user_id){
        $encrypted_password = self::Encrypt($password);
        $query  = "SELECT * FROM USERS ";
        $query .= "WHERE user_id = $user_id";
        
		self::Init_Database();
		try{
			$sql = self::$database->Connection->prepare($query);
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_OBJ);
			
			return $result;
			
		}catch(PDOException $e){
			echo "Query SELECT Failed ".$e->getMessage();
		}
	}
    public static function CreateSalt($password){
         
         $random = md5($password);
         $salt = substr($random, 0, 22); 
        
         return  $salt;
    }
    public static function Encrypt($password){
        //Using Crypt function with salt (High Security)
        //step1: Define a variable salt 
		//with some random text of length 22 characters 
        $salt =  self::CreateSalt($password);
	   
        //step2: Define a hash format (MD5, BLOWFISH, SHA256 , SHA512)
        $hashformat = "$2y$10$";//Generate hash code 10 times
        $hashformat_and_salt = $hashformat . $salt ;
        $encryptedPassword = crypt($password, $hashformat_and_salt);
        return $encryptedPassword;
    }
	public static function Update_Password($user_id , $new_password){
		
		$reset_password = 1;
        $encrypted_password = self::Encrypt($new_password);
        $query  = "UPDATE USERS SET password = '$encrypted_password' , ";
		$query .= "reset_password = $reset_password  ";
        $query .= "WHERE user_id = $user_id";
		self::Init_Database();
		try{
			self::$database->Connection->exec($query);
			return true;
		}catch(PDOException $e){
			echo "Query UPDATE Failed ".$e->getMessage();
			return false;
		}
	}
	public static function Delete($user_id){
		
		
        $query  = "DELETE FROM USERS  ";
		$query .= "WHERE user_id = $user_id";
		self::Init_Database();
		try{
			self::$database->Connection->exec($query);
			return true;
		}catch(PDOException $e){
			echo "Query UPDATE Failed ".$e->getMessage();
			return false;
		}
	}
}
?>