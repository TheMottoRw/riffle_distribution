<?php

include_once "../classes/Posts.php";
$posts = new Posts();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        switch ($_POST['cate']) {

            case 'register':
                echo json_encode($posts->insert($_POST));
                break;

            case 'update':
                echo json_encode($posts->update($_POST));
                break;
        }
        break;

    case 'GET':
        header("Content-Type:application/json");
        switch ($_GET['cate']) {

            case 'delete':
                $posts->delete($_GET['id']);
                break;

            case 'loadbyid':
                // header("Content-Type:application/json");
                echo json_encode($posts->getById($_GET['id']));
                break;

            case 'bydistrict':
                // header("Content-Type:application/json");
                echo json_encode($posts->getByDistrict($_GET));
                break;

            case 'load':
                // header("Content-Type:application/json");
                echo json_encode($posts->get());
                break;

            default:
                echo "value of parameter category not known";
                break;
        }
        break;
    default:
        echo $_SERVER['REQUEST_METHOD'] . "Request method not allowed";
        break;
}

?>