<?php
include_once "Database.php";
include_once "Police.php";
include_once "Weapons.php";

class DeploymentAssignment
{
    public $conn;
    public $weaponObj;
    public $policeObj;
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();

        $this->weaponObj = new Weapons();
        $this->policeObj = new Police();
    }

    // insert
    function insert($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'> Assignment done sucessful</div>"];
        $deployer = $arr['sess_id'];
        $post = $arr['post'];
        $police = $arr['police'];
        $workdate = $arr['workdate'];

        //check if he is already assigned
        $qy = $this->conn->prepare("SELECT * FROM deployment_assignment WHERE police=:police AND  work_date =:workdate");
        $qy->execute(['police'=>$police,"workdate"=>$workdate]);

        if($qy->rowCount() > 0) return ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Sorry,he is already assigned to post</div>"];

        //check if yesterday was on the same post
        $qy = $this->conn->prepare("SELECT * FROM deployment_assignment WHERE police=:police AND post=:post AND  work_date = date_sub(:workdate,INTERVAL 1 DAY)");
        $qy->execute(['police'=>$police,"post"=>$post,"workdate"=>$workdate]);

        if($qy->rowCount() > 0) return ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Can't be assigned back to post s/he has been working on yesterday</div>"];

        $insert = $this->conn->prepare("INSERT INTO deployment_assignment set post=:post,deployer=:deployer,police=:police,work_date=:workdate");

        $insert->execute(array('post' => $post, 'deployer' => $deployer, 'police' => $police, 'workdate' => $workdate));

        if ($insert->rowCount() == 0) {
//            echo "you added deploymentAssignment " . $this->conn->lastInsertId();
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to make an assignment</div>"];

        }
        return $feed;
    }

    // edit
    function update($arr)
    {
        $feed = ['status' => 'ok', 'message' => "<div class='alert alert-success'>Assignment updated sucessful</div>"];
        $deployer = $arr['sess_id'];
        $post = $arr['post'];
        $police = $arr['police'];
        $workdate = $arr['workdate'];

        $id = $arr['id'];
        //check if he is already assigned
        $qy = $this->conn->prepare("SELECT * FROM deployment_assignment WHERE police=:police AND  work_date =:workdate AND id!=:id");
        $qy->execute(['police'=>$police,"workdate"=>$workdate,"id"=>$id]);

        if($qy->rowCount() > 0) return ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Sorry,he is already assigned to post</div>"];

        //check if yesterday was on the same post
        $qy = $this->conn->prepare("SELECT * FROM deployment_assignment WHERE police=:police AND post=:post AND  work_date = date_sub(:workdate,INTERVAL 1 DAY)");
        $qy->execute(['police'=>$police,"post"=>$post,"workdate"=>$workdate]);

        if($qy->rowCount() > 0) return ['status'=>'fail',"message"=>"<div class='alert alert-danger'>Can't be assigned back to post s/he has been working on yesterday</div>"];

        $upd = $this->conn->prepare("UPDATE deployment_assignment set post=:post,deployer=:deployer,police=:police,work_date=:workdate where id=:i ");

        $upd->execute(array('post' => $post, 'deployer' => $deployer, 'police' => $police, 'workdate' => $workdate, 'i' => $id));

        if ($upd->rowCount() == 0) {
//            echo "database updated";
            $feed = ['status' => 'fail', 'message' => "<div class='alert alert-danger'>Failed to update assignment</div>"];
        }
        return $feed;
    }

    function assignWeapon($datas)
    {
        $feed = ['status'=>'ok','message'=>"<div class='alert alert-success'>Weapon assigned</div>"];
        $police = $this->policeObj->getByPoliceId($datas['police'])[0]['id'];
        $weapon = $this->weaponObj->getBySerial($datas['weapon'])[0]['id'];
        $upd = $this->conn->prepare("UPDATE deployment_assignment set weapon=:weapon,assigned_on=CURRENT_TIMESTAMP where police=:police AND LEFT(work_date,10)=CURRENT_DATE ");
        $upd->execute(array('weapon' => $weapon,'police' => $police));
        if($upd->rowCount() != 1){
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Failed to assign weapon to police officer</div>"];
        }
        return $feed;
    }
    function submitWeapon($datas)
    {
        $feed = ['status'=>'ok','message'=>"<div class='alert alert-success'>Weapon submitted</div>"];
        $weapon = $this->weaponObj->getBySerial($datas['weapon'])[0]['id'];
        $upd = $this->conn->prepare("UPDATE deployment_assignment set returned_on=CURRENT_TIMESTAMP where weapon=:weapon");
        $upd->execute(array('weapon' => $weapon));
        if($upd->rowCount() != 1){
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Failed to register weapon submission</div>"];
        }
        return $feed;
    }
    function declareWeaponSubmissionDelay($datas)
    {
        $id = $datas['id'];
        $reason = $datas['reason'];
        $feed = ['status'=>'ok','message'=>"<div class='alert alert-success'>Weapon submitted</div>"];
        $weapon = $this->weaponObj->getBySerial($datas['weapon'])[0]['id'];
        $upd = $this->conn->prepare("UPDATE deployment_assignment set reason=:reason where id=:id");
        $upd->execute(array('reason' => $reason,"id"=>$id));
        if($upd->rowCount() != 1){
            $feed = ['status'=>'fail','message'=>"<div class='alert alert-danger'>Failed to register weapon submission".json_encode($upd->errorInfo())."</div>"];
        }
        return $feed;
    }

    // delete
    function delete($id)
    {
        $del = $this->conn->prepare("UPDATE  deployment_assignment SET delete_status=:stat where id=:i ");
        $del->execute(array('stat' => "deleted", 'i' => $id));
        return ['status'=>'ok'];
    }


    // fetch or retrieve 
    function getById($id)
    {
        $getall = $this->conn->prepare("SELECT *,p.police_id from deployment_assignment dass INNER JOIN police p ON p.id=dass.police where delete_status!='deleted' and dass.id=:i ");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByPost($arr)
    {
        $post = $arr['post'];
        $getall = $this->conn->prepare("SELECT * from deployment_assignment where delete_status!='deleted' and post=:post");
        $getall->execute(['post' => $post]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getByDeployer($arr)
    {
        $deployer = $arr['deployer'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,p.police_id,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon where dass.delete_status!='deleted'");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function searchByPoliceKeyword($arr)
    {
        $keyword = $arr['keyword'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon where dass.delete_status!='deleted' and  p.phone=:keyword || p.police_id=:keyword  ORDER BY dass.id DESC");
        $getall->execute(['keyword' => $keyword]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getByPolice($arr)
    {
        $police = $arr['police'];
        if(!is_numeric($police)) return [];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon where dass.police=:police ORDER BY id DESC");
        $getall->execute(['police' => $police]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function get($arr)
    {
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,p.police_id,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getNotReturned($arr){
        $deployer = $arr['sess_id'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NULL");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getReturned($arr){
        $deployer = $arr['sess_id'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NOT NULL");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getNotReturnedByRange($arr){
        $deployer = $arr['sess_id'];
        $from = $arr['from'];
        $to = $arr['to'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NULL AND dass.assigned_on BETWEEN '".$from."' AND '".$to."'");
        $getall->execute();
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getReturnedByRange($arr){
        $deployer = $arr['sess_id'];
        $from = $arr['from'];
        $to = $arr['to'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NOT NULL AND dass.assigned_on BETWEEN '".$from."' AND '".$to."'");
        $getall->execute();

        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getNotReturnedByDate($arr){
        $deployer = $arr['sess_id'];
        $workdate = $arr['workdate'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NULL AND dass.work_date=:workdate");
        $getall->execute(['workdate'=>$workdate]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getReturnedByDate($arr){
        $deployer = $arr['sess_id'];
        $workdate = $arr['workdate'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NOT NULL AND dass.work_date=:workdate");
        $getall->execute(['workdate'=>$workdate]);

        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByDate($arr){
        $deployer = $arr['sess_id'];
        $workdate = $arr['workdate'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,p.police_id,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.work_date=:workdate");
        $getall->execute(['workdate'=>$workdate]);

        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function dashboard($arr){
        $data = [];
        $deployer = $arr['sess_id'];
        $qy = $this->conn->prepare("SELECT COUNT(assigned_on) as not_returned,left(dass.assigned_on,10) AS assignment_date FROM deployment_assignment dass WHERE returned_on IS NULL GROUP BY LEFT(dass.assigned_on,10)");
        $qy->execute();
        $notReturned = $qy->fetchAll(PDO::FETCH_ASSOC);

        $qyReturned = $this->conn->prepare("SELECT COUNT(assigned_on) as returned,left(dass.assigned_on,10) AS assignment_date FROM deployment_assignment dass WHERE returned_on IS NOT NULL GROUP BY LEFT(dass.assigned_on,10)");
        $qyReturned->execute();
        $returned = $qyReturned->fetchAll(PDO::FETCH_ASSOC);

        $qyAllDate = $this->conn->query("SELECT LEFT(assigned_on,10) as dates FROM deployment_assignment GROUP BY LEFT(assigned_on,10)");
        $dataAllDate = $qyAllDate->fetchAll(PDO::FETCH_ASSOC);
        /*
         * [{date:{returned:12,not_returned:12}},]
         *
         */
        foreach ($dataAllDate as $dateObj){
            $tempObj = ['returned'=>0,'not_returned'=>0];
            //check for returned
                foreach ($returned as $returnedObj){
                    if($dateObj['dates'] == $returnedObj['assignment_date']){
                        $tempObj['returned'] = $returnedObj['returned'];
                        break;
                    }
                }
//            }
            //check for not returned on the same date
                foreach ($notReturned as $notReturnedObj){
                    if($dateObj['dates'] == $notReturnedObj['assignment_date']){
                        $tempObj['not_returned'] = $notReturnedObj['not_returned'];
                        break;
                    }
                }
//            echo json_encode($tempObj);exit;
//            format data append it to array
            $data[] =['date'=>$dateObj['dates'],'stats'=>$tempObj];
        }

        return $data;
    }
}

?>