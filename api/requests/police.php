<?php

include_once "../classes/Police.php";
$police = new Police();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {
            case 'register':
                echo json_encode($police->insert($_POST));
                break;

            case 'update':
                echo json_encode($police->update($_POST));
                break;
            case 'deploy':
                echo json_encode($police->deploy($_POST));
                break;
        }

        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {
            case 'load':
                echo json_encode($police->get());
                break;
            case 'delete':
                $del = $police->delete($_GET);
                if($del['status']=='ok') header("location:".$_SERVER['HTTP_REFERER']);
                break;

            case 'loadbyid':
                echo json_encode($police->getById($_GET));
                break;

            case 'bydeployment':
                echo json_encode($police->getByDeployment($_GET));
                break;
            case 'byready':
                echo json_encode($police->getByReadyForDeployment($_GET));
                break;
            case 'search':
                echo json_encode($police->search($_GET));
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