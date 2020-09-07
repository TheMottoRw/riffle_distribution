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
        $police = $this->policeObj->getByPoliceId($arr['police'])[0]['id'];
        $workdate = $arr['workdate'];

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
        $police = $this->policeObj->getByPoliceId($arr['police'])[0]['id'];
        $workdate = $arr['workdate'];

        $id = $arr['id'];

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

    // delete
    function delete($id)
    {
        $del = $this->conn->prepare("DELETE FROM deployment_assignment where id=:i ");
        $del->execute(array('stat' => "deleted", 'i' => $id));
        if ($del) {
            echo "deleted succeffully";
        } else {
            echo "failed to delete" . json_encode($del->errorInfo());
        }
    }


    // fetch or retrieve 
    function getById($id)
    {
        $getall = $this->conn->prepare("SELECT *,p.police_id from deployment_assignment dass INNER JOIN police p ON p.id=dass.police where dass.id=:i");
        $getall->execute(array('i' => $id));
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getByPost($arr)
    {
        $post = $arr['post'];
        $getall = $this->conn->prepare("SELECT * from deployment_assignment where post=:post");
        $getall->execute(['post' => $post]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function getByDeployer($arr)
    {
        $deployer = $arr['deployer'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon where dass.deployer=:deployer");
        $getall->execute(['deployer' => $deployer]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function get($arr)
    {
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
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
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NULL AND dass.deployer=:deployer");
        $getall->execute(['deployer'=>$deployer]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getReturned($arr){
        $deployer = $arr['sess_id'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NOT NULL AND dass.deployer=:deployer");
        $getall->execute(['deployer'=>$deployer]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getNotReturnedByRange($arr){
        $deployer = $arr['sess_id'];
        $from = $arr['from'];
        $to = $arr['to'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NULL AND dass.deployer=:deployer AND dass.assigned_on BETWEEN '".$from."' AND '".$to."'");
        $getall->execute(['deployer'=>$deployer]);
        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function getReturnedByRange($arr){
        $deployer = $arr['sess_id'];
        $from = $arr['from'];
        $to = $arr['to'];
        $getall = $this->conn->prepare("SELECT dass.*,p.name as police_name,pst.name as post_name,w.serial_number as weapon_serial_number from deployment_assignment dass 
                                                    INNER JOIN posts pst on pst.id=dass.post INNER JOIN police p ON p.id=dass.police
                                                     LEFT JOIN weapons w ON w.id=dass.weapon WHERE dass.returned_on IS NOT NULL AND dass.deployer=:deployer AND dass.assigned_on BETWEEN '".$from."' AND '".$to."'");
        $getall->execute(['deployer'=>$deployer]);

        $data = $getall->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function dashboard($arr){
        $data = [];
        $deployer = $arr['sess_id'];
        $qy = $this->conn->prepare("SELECT COUNT(assigned_on) as not_returned,left(dass.assigned_on,10) AS assignment_date FROM deployment_assignment dass WHERE deployer=:deployer AND returned_on IS NULL GROUP BY LEFT(dass.assigned_on,10)");
        $qy->execute(['deployer'=>$deployer]);
        $notReturned = $qy->fetchAll(PDO::FETCH_ASSOC);

        $qyReturned = $this->conn->prepare("SELECT COUNT(assigned_on) as returned,left(dass.assigned_on,10) AS assignment_date FROM deployment_assignment dass WHERE deployer=:deployer AND returned_on IS NOT NULL GROUP BY LEFT(dass.assigned_on,10)");
        $qyReturned->execute(['deployer'=>$deployer]);
        $returned = $qyReturned->fetchAll(PDO::FETCH_ASSOC);

        $qyAllDate = $this->conn->query("SELECT LEFT(assigned_on,10) as dates FROM deployment_assignment WHERE deployer=$deployer GROUP BY LEFT(assigned_on,10)");
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