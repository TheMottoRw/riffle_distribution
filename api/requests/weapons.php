<?php

include_once "../classes/Weapons.php";
$weapons = new Weapons();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {

            case 'register':
                echo json_encode($weapons->insert($_POST));
                break;

            case 'update':
               echo json_encode($weapons->update($_POST));
                break;

        }
        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'delete':
                $del = $weapons->delete($_GET['id']);
                if($del['status']=='ok') header("location:".$_SERVER['HTTP_REFERER']);
                break;

            case 'loadbyid':
                // header("Content-Type:application/json");
                echo json_encode($weapons->getById($_GET['id']));
                break;

            case 'bytype':
                // header("Content-Type:application/json");
                echo json_encode($weapons->getByType($_GET));
                break;

            case 'load':
                // header("Content-Type:application/json");
                echo json_encode($weapons->get($_GET));
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