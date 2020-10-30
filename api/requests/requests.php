<?php
include_once "../classes/Requests.php";
$assignment = new Requests();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {
            case 'register':
                echo json_encode($assignment->insert($_POST));
                break;

        }

        break;
    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {
            case 'bypolice':
                // header("Content-Type:application/json");
                echo json_encode($assignment->getByPolice($_GET));
                break;

            case 'load':
                // header("Content-Type:application/json");
                echo json_encode($assignment->get($_GET));
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