<?php
class Database{
	public $conn="";
	public function connection(){
try{
	$this->conn=new PDO("mysql:host=localhost;dbname=armory","super","");
//		echo "Database connected";
}catch(PDOException $ex){
	echo" Could not connect to Database ".$ex->getMessage();
}

        return $this->conn;
	}
	public function  getInstance(){
	    return $this->connection();
    }
}
$conn = new Database();
$conn->getInstance();
?>