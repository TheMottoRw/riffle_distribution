<?php
include_once "Database.php";
include_once "Validator.php";
class Requests
{
    public $conn;
    private $validate;
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
        $this->validate = new Validator();
    }

    // insert
    function insert($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Requensts registered sucessful</div>"];
        $police = $arr['police'];
        $message = $arr['message'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Message'=>$message]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation

            $insert = $this->conn->prepare("INSERT INTO requests set message=:message,police=:police");

            $insert->execute(array('message' => $message, 'police' => $police));
            if ($insert->rowCount() == 0) {
//  		echo "you added requests ".$this->conn->lastInsertId();
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register request ".json_encode($insert->errorInfo())."</div>"];

            }
        return $feed;
    }



    // fetch or retrieve 
    function getById($id)
    {
        $getall = $this->conn->prepare("SELECT * from requests where id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByPolice($arr)
    {
        $police = $arr['police'];
        $getall = $this->conn->prepare("SELECT r.*,p.name from requests r INNER JOIN police p ON p.id=r.police where police=:police");
        $getall->execute(['police'=>$police]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function get()
    {
        $getall = $this->conn->prepare("SELECT r.*,p.name from requests r inner join police p on p.id=r.police ORDER BY r.id DESC");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}

?>