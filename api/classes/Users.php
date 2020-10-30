<?php
include_once "Database.php";
include_once "Validator.php";
class Users
{
    private $conn;
    private $validate;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
        $this->validate = new Validator();
    }

    function superAdminExistance(){
        $name = 'Manzi';
        $policeId = 'RNP09121';
        $phone= '0726183049';
        $rank= 'Private';
        $dep = 'Karongi';
        $level = 'District';
        $category = 'Superadmin';
        $password = base64_encode(12345);

        $chk = $this->conn->prepare("SELECT * FROM users WHERE phone=:ph");
        $chk->execute(array('ph' => $phone));
        if($chk->rowCount()==0){
            $insert = $this->conn->prepare("INSERT INTO users set name=:n,police_id=:policeId,ranks=:r,phone=:ph,district=:district,level=:level,category=:category,password=:pass");
            $insert->execute(array('n' => $name, 'policeId'=>$policeId,'r' => $rank, 'ph' => $phone, 'district' => $dep, 'level' => $level,'category' => $category, 'pass' => $password));
        }
    }
    // insert
    function insertUser($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>User account created sucessful</div>"];
        $name = $arr['name'];
        $policeId = $arr['police_id'];
        $phone= $arr['phone'];
        $rank= $arr['rank'];
        $dep = $arr['district'];
        $level = $arr['level'];
        $category = $arr['category'];
        $password = base64_encode($arr['password']);
        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Phone'=>$phone,'Police Id'=>$policeId,'District'=>$dep,'Rank'=>$rank,'Password'=>$password]);
        $isLevelAllowed = $this->validate->allowed($level,['District']);
        $isCategoryAllowed = $this->validate->allowed($category,['Superadmin','Deployer','Riffle_distributor']);
        $isPoliceIdValid = $this->validate->policeId($policeId);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>$validationStatus['message']];
        if(!$isPoliceIdValid['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if($this->validate->phone('rwandan',$phone) == 0) return $feed = ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$isLevelAllowed['status']) return $feed = ['status'=>'fail','message'=>$isLevelAllowed['message']];
        if(!$isCategoryAllowed['status']) return $feed = ['status'=>'fail','message'=>$isCategoryAllowed['message']];
        //end validation

        $chk = $this->conn->prepare("SELECT * FROM users WHERE phone=:ph OR police_id=:policeId");
        $chk->execute(array('ph' => $phone,'policeId'=>$policeId));
        if($chk->rowCount()==0) {
            $insert = $this->conn->prepare("INSERT INTO users set name=:n,police_id=:policeId,ranks=:r,phone=:ph,district=:district,level=:level,category=:category,password=:pass");
            $insert->execute(array('n' => $name, 'policeId' => $policeId, 'r' => $rank, 'ph' => $phone, 'district' => $dep, 'level' => $level, 'category' => $category, 'pass' => $password));
            if ($insert->rowCount() == 0) {
                $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to create user account</div>"];
//  		echo "you added user ".$this->conn->lastInsertId();
            }
        } else
            $feed = ['status' => 'exist', 'message' => "<div class='alert alert-primary'>Failed to create account,phone or police ID already exist</div>"];
        return $feed;
    }

    // edit
    function updateUser($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>User account updated sucessful</div>"];
        $name = $arr['name'];
        $policeId = $arr['police_id'];
        $phone= $arr['phone'];
        $rank= $arr['rank'];
        $dep = $arr['district'];
        $level = $arr['level'];
        $category = $arr['category'];
        $id = $arr['id'];

        //validating
        $validationStatus = $this->validate->isEmpty(['Name'=>$name,'Phone'=>$phone,'Police Id'=>$policeId,'District'=>$dep,'Rank'=>$rank]);
        $isLevelAllowed = $this->validate->allowed($level,['District']);
        $isCategoryAllowed = $this->validate->allowed($category,['Superadmin','Deployer','Riffle_distributor']);
        $isPoliceIdValid = $this->validate->policeId($policeId);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if(!$isPoliceIdValid['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if($this->validate->phone('rwandan',$phone) == 0) return $feed = ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        if(!$isLevelAllowed['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$isLevelAllowed['message']."</div>"];
        if(!$isCategoryAllowed['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$isCategoryAllowed['message']."</div>"];
        //end validation

        $upd = $this->conn->prepare("UPDATE users set name=:n,police_id=:policeId,ranks=:r,phone=:ph,district=:district,level=:level,category=:category where id=:i ");
        $upd->execute(array('n' => $name,'policeId'=>$policeId, 'r' => $rank, 'ph' => $phone, 'district' => $dep, 'level' => $level,'category' => $category, 'i' => $id));

        if ($upd->rowCount() == 0) $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update user account</div>"];
        return $feed;
    }

    // delete
    function deleteUser($arr)
    {
        $id = $arr['id'];
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>User account created sucessful</div>"];
        $del = $this->conn->prepare("DELETE FROM users where id=:i ");
        $del->execute(array('i' => $id));
        if (!$del)
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to delete user account</div>"];
        return $feed;
    }

    // reset password
    function resetUser($arr)
    {
        $id = $arr['id'];
        if($arr['password']!=$arr['confPassword']) return ['status'=>'notmatch'];
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>User password created successful</div>"];
        $del = $this->conn->prepare("UPDATE users SET password=:pwd where id=:i ");
        $del->execute(array('i' => $id,'pwd'=>base64_encode($arr['password'])));
        if (!$del)
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to reset user password</div>"];
        return $feed;
    }

    function login($arr)
    {   //initialize default super admin
        $this->superAdminExistance();

        $feed = ['status'=>'ok','user'=>''];
        $phone = $arr['phone'];
        $password = base64_encode($arr['password']);

        //validating
        $validationStatus = $this->validate->isEmpty(['Phone'=>$phone,'Password'=>$password]);
        if($validationStatus['status']) return $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>".$validationStatus['message']."</div>"];
        if($this->validate->phone('rwandan',$phone) == 0) return $feed = ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Invalid phone number</div>"];
        //end validation

        $getall = $this->conn->prepare("SELECT * from users where phone=:n AND password=:p");
        $getall->execute(array('n' => $phone, 'p' => $password));
        if($getall->rowCount()==1){
            $fetch = $getall->fetchAll(PDO::FETCH_ASSOC);
            //set sessions
            $feed = array('status' => "ok", 'user' => ["sess_id" => $fetch[0]['id'], "sess_name" => $fetch[0]['name'], "sess_district" => $fetch[0]['district'], "sess_level" => $fetch[0]['level'],"sess_category" => $fetch[0]['category']]);
        } else {
//            return $feed = array('status'=>'fail','message'=>"<div class='alert alert-danger'>Wrong username or password</div>");
            //not yet login of  standard police allowed
            $qy = $this->conn->prepare("SELECT * from police where phone=:n AND password=:p");
            $qy->execute(array('n' => $phone, 'p' => $password));
            if($qy->rowCount()==1){
                $fetch = $qy->fetchAll(PDO::FETCH_ASSOC);
                //set sessions
                $feed = array('status' => "ok", 'user' => ["sess_id" => $fetch[0]['id'], "sess_name" => $fetch[0]['name'], "sess_district" => $fetch[0]['deployment'],"sess_category" => 'Police']);
            }else
                $feed = array('status'=>'fail','message'=>"<div class='alert alert-danger'>Wrong username or password</div>");
        }
        return $feed;
    }

    // fetch or retrieve 
    function getUserById($id)
    {
        $getall = $this->conn->prepare("SELECT * from users where id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getUserByCategory($arr)
    {
        $category = $arr['category'];
        $getall = $this->conn->prepare("SELECT * from users WHERE category=:cate");
        $getall->execute(['cate'=>$category]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function All_users()
    {
        $getall = $this->conn->prepare("SELECT * from users");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


}

?>