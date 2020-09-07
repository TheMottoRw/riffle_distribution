<?php
include_once "Database.php";
include_once "Validator.php";
class Weapons
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
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Weapon registered sucessful</div>"];
        $name = $arr['name'];
        $serial = $arr['serial'];
        $type = $arr['type'];
        $sessid = $arr['sess_id'];
        $status = 'available';
        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Type'=>$type,'Serial number'=>$serial]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation


        $chk = $this->conn->prepare("SELECT * FROM weapons WHERE serial_number=:serial");
        $chk->execute(array('serial'=>$serial));
        if($chk->rowCount()==0) {
            $insert = $this->conn->prepare("INSERT INTO weapons set name=:name,serial_number=:serial,type=:type,status=:status");
            $insert->execute(array('name' => $name, 'serial' => $serial, 'type' => $type, 'status' => $status));
            if ($insert->rowCount() == 0) {
//  		echo "you added day work ".$this->conn->lastInsertId();
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register weapon</div>"];
            }
        }else
            $feed = ['status' => 'exist', 'message' => "<div class='alert alert-danger'>Weapon with the same serial number already exist</div>"];
        return $feed;
    }

    // edit
    function update($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Weapon updated sucessful</div>"];
        $name = $arr['name'];
        $serial = $arr['serial'];
        $type = $arr['type'];
        $sessid = $arr['sess_id'];
        $id = $arr['id'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Type'=>$type,'Serial number'=>$serial]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation

        $upd = $this->conn->prepare("UPDATE weapons set name=:name,serial_number=:serial,type=:type where id=:i ");

        $upd->execute(array('name' => $name, 'serial' => $serial, 'type' => $type, 'i' => $id));

        if ($upd->rowCount() == 0) {
//            echo "database updated";
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update weapon</div>"];
        }
        return $feed;
    }

    // delete
    function delete($id)
    {
        $del = $this->conn->prepare("DELETE FROM weapons where id=:i ");
        $del->execute(array('stat' => "deleted", 'i' => $id));
        if ($del) {
            echo "weapon deleted succeffully";
        } else {
            echo "failed to delete weapon " . json_encode($del->errorInfo());
        }
    }


    function getById($id)
    {
        $getall = $this->conn->prepare("SELECT * from weapons where id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getBySerial($serial){
        $getall = $this->conn->prepare("SELECT * from weapons where serial_number=:serial");
        $getall->execute(array("serial"=>$serial));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getByType($arr){
        $type = $arr['type'];
        $getall = $this->conn->prepare("SELECT * from weapons where type=:type");
        $getall->execute(array("type"=>$type));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function get($arr)
    {
        $getall = $this->conn->prepare("SELECT * from weapons");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


}

?>