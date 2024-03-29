<?php
include_once "../classes/DeploymentAssignment.php";
$assignment = new DeploymentAssignment();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {
            case 'register':
                echo json_encode($assignment->insert($_POST));
                break;

            case 'update':
                echo json_encode($assignment->update($_POST));
                break;
            case 'assign':
                echo json_encode($assignment->assignWeapon($_POST));
                break;
            case 'submit':
                echo json_encode($assignment->submitWeapon($_POST));
                break;
            case 'declare':
                echo json_encode($assignment->declareWeaponSubmissionDelay($_POST));
                break;

        }

        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'delete':
                $del = $assignment->delete($_GET['id']);
                if($del['status']=='ok') header("location:".$_SERVER['HTTP_REFERER']);
                break;

            case 'loadbyid':
                // header("Content-Type:application/json");
                echo json_encode($assignment->getById($_GET['id']));
                break;

            case 'bypost':
                // header("Content-Type:application/json");
                echo json_encode($assignment->getByPost($_GET));
                break;
            case 'bydeployer':
                // header("Content-Type:application/json");
                echo json_encode($assignment->getByDeployer($_GET));
                break;
            case 'bypolice':
                // header("Content-Type:application/json");
                echo json_encode($assignment->getByPolice($_GET));
                break;


            case 'load':
                // header("Content-Type:application/json");
                echo json_encode($assignment->get($_GET));
                break;
            case 'search':
                echo json_encode($assignment->searchByPoliceKeyword($_GET));
                break;
            case 'dashboard':
                echo json_encode($assignment->dashboard($_GET));
                break;
            case 'returned':
                echo json_encode($assignment->getReturned($_GET));
                break;
            case 'notreturned':
                echo json_encode($assignment->getNotReturned($_GET));
                break;
            case 'returnedbyrange':
                echo json_encode($assignment->getReturnedByRange($_GET));
                break;
            case 'notreturnedbyrange':
                echo json_encode($assignment->getNotReturnedByRange($_GET));
                break;
            case 'returnedbydate':
                echo json_encode($assignment->getReturnedByDate($_GET));
                break;
            case 'notreturnedbydate':
                echo json_encode($assignment->getNotReturnedByDate($_GET));
                break;
            case 'bydate':
                echo json_encode($assignment->getByDate($_GET));
                break;
            default:
                echo json_encode(['error'=>"value of parameter category not known"]);
                break;
        }
        break;
    default:
        echo json_encode(['error'=>$_SERVER['REQUEST_METHOD'] . "Request method not allowed"]);
        break;
}

?>