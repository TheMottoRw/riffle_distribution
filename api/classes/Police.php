<?php
include_once "Database.php";
include_once "Validator.php";
class Police
{
    private $conn;
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
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Police account created sucessful</div>"];
        $name = $arr['name'];
        $policeId = $arr['police_id'];
        $phone= $arr['phone'];
        $rank= $arr['rank'];
        $deployment = $arr['district'];
        $password = base64_encode($arr['password']);

        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Phone'=>$phone,'Police Id'=>$policeId,'Rank'=>$rank]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if($this->validate->phone('rwandan',$phone) == 0) return $feed = ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        //end validation

        $chk = $this->conn->prepare("SELECT * FROM police WHERE phone=:ph OR police_id=:policeId");
        $chk->execute(array('ph' => $phone,'policeId'=>$policeId));
        if($chk->rowCount()==0) {
            $insert = $this->conn->prepare("INSERT INTO police set name=:n,police_id=:policeId,ranks=:r,phone=:ph,deployment=:district,password=:pass");
            $insert->execute(array('n' => $name, 'policeId' => $policeId, 'r' => $rank, 'ph' => $phone, 'district' => $deployment, 'pass' => $password));
            if ($insert->rowCount() == 0) {
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to create police account</div>"];
//  		echo "you added police ".$this->conn->lastInsertId();
            }
        } else
            $feed = ['status' => 'exist', 'message' => "<div class='alert alert-danger'>Police exist with the same police id or phone number</div>"];
        return $feed;
    }

    // edit
    function update($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Police account created sucessful</div>"];
        $name = $arr['name'];
        $policeId = $arr['police_id'];
        $phone= $arr['phone'];
        $rank= $arr['rank'];
        $deployment = $arr['district'];
        $id = $arr['id'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Phone'=>$phone,'Police Id'=>$policeId,'Deployment'=>$deployment,'Rank'=>$rank]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if($this->validate->phone('rwandan',$phone) == 0) return $feed = ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        //end validation

        $upd = $this->conn->prepare("UPDATE police set name=:n,police_id=:policeId,ranks=:r,phone=:ph,deployment=:district where id=:i ");
        $upd->execute(array('n' => $name,'policeId' => $policeId, 'r' => $rank, 'ph' => $phone, 'district' => $deployment, 'i' => $id));

        if ($upd->rowCount() == 0) $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update police account</div>"];
        return $feed;
    }

    // edit
    function deploy($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Police deployment done sucessful</div>"];
        $deployment = $arr['district'];
        $id = $arr['id'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Deployment'=>$deployment]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation

        $upd = $this->conn->prepare("UPDATE police set deployment=:district where id=:i ");
        $upd->execute(array( 'district' => $deployment, 'i' => $id));

        if ($upd->rowCount() == 0) $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to deploy police account</div>"];
        return $feed;
    }

    // delete
    function delete($arr)
    {
        $id = $arr['id'];
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Police account created sucessful</div>"];
        $del = $this->conn->prepare("DELETE FROM police where id=:i ");
        $del->execute(array('stat' => "deleted", 'i' => $id));
        if (!$del)
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete police account</div>"];
        return $feed;
    }
    // fetch or retrieve 
    function getById($arr)
    {
        $id = $arr['id'];
        $getall = $this->conn->prepare("SELECT * from police where id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // fetch or retrieve 
    function getByPoliceId($id)
    {
        $getall = $this->conn->prepare("SELECT * from police where police_id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByDeployment($arr)
    {
        $deployment = $arr['deployment'];
        $getall = $this->conn->prepare("SELECT * from police WHERE deployment=:cate");
        $getall->execute(['cate'=>$deployment]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByReadyForDeployment($arr)
    {
        $deployment = $arr['deployment'];
        $getall = $this->conn->prepare("SELECT * from police WHERE deployment=:status");
        $getall->execute(['status'=>'Ready']);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function get()
    {
        $getall = $this->conn->prepare("SELECT * from police");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


}

?>