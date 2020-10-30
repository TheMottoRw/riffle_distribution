<?php
include_once "Database.php";
include_once "Validator.php";
class Posts
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
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Post registered sucessful</div>"];
        $name = $arr['name'];
        $sessid = $arr['sess_id'];
        $district = $arr['district'];
        $status = $arr['status'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Post name'=>$name]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation

        $chk = $this->conn->prepare("SELECT * FROM posts WHERE name=:name and district=:district");
        $chk->execute(array('name' => $name,'district'=>$district));
        if($chk->rowCount()==0) {
            $insert = $this->conn->prepare("INSERT INTO posts set name=:name,district=:district,status=:status");

            $insert->execute(array('name' => $name, 'district' => $district, 'status' => $status));
            if ($insert->rowCount() == 0) {
//  		echo "you added posts ".$this->conn->lastInsertId();
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to register post  ".json_encode($insert->errorInfo())."</div>"];

            }
        } else
            $feed = ['status' => 'exist', 'message' => "<div class='alert alert-danger'>Post with the same information already exist</div>"];
        return $feed;
    }

    // edit
    function update($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Post updated sucessful</div>"];
        $name = $arr['name'];
        $sessid = $arr['sess_id'];
        $district = $arr['district'];
        $id = $arr['id'];
        //validating
        $validationStatus = $this->validate->isEmpty(['Post name'=>$name]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        //end validation


        $upd = $this->conn->prepare("UPDATE posts set name=:name,district=:district,updated_at=CURRENT_TIMESTAMP where id=:i");
        $upd->execute(array( 'name' => $name, 'district' => $district, 'i' => $id));

        if ($upd->rowCount() == 0) {
//  	echo "database updated";
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-success'>Failed to update post</div>"];
        }
        return $feed;
    }

    // delete
    function delete($id)
    {
        $del = $this->conn->prepare("UPDATE FROM posts SET status=:stat  where id=:i ");
        $del->execute(array('stat' => "deleted", 'i' => $id));
        return ['status'=>'ok'];
    }


    // fetch or retrieve 
    function getById($id)
    {
        $getall = $this->conn->prepare("SELECT * from posts where  status!='deleted' and id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByDistrict($arr)
    {
        $district = $arr['district'];
        $getall = $this->conn->prepare("SELECT * from posts where status!='deleted'");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function get()
    {
        $getall = $this->conn->prepare("SELECT * from posts");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}

?>