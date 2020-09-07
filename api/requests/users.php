<?php

include_once "../classes/Users.php";
$userObj = new Users();

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':
	switch ($_POST['cate']) {
		case 'register':
			echo json_encode($userObj->insertUser($_POST));
			break;
		case 'update':
		 echo json_encode($userObj->updateUser($_POST));
		break;
        case 'login':
            // header("Content-Type:application/json");
            echo json_encode($userObj->login($_POST));
            break;

    }
		break;
	case 'GET':
        header("Content-Type:application/json");
	switch ($_GET['cate']) {
		
        case 'deleteUser':
        $userObj->deleteUser($_GET['id']); 
         break;

        case 'loadbyid':
        // header("Content-Type:application/json");
        echo json_encode($userObj->getUserById($_GET['id']));
              break;

        case 'bystatus':
        // header("Content-Type:application/json");
        echo json_encode($userObj->getUserByCategory($_GET));
              break;
        case 'load':
        // header("Content-Type:application/json");
        echo json_encode($userObj->All_users());
              break;      

		default:
			echo "value of parameter category not known";
			break;
	}
	break;
	default:
		echo $_SERVER['REQUEST_METHOD']." Request method not allowed";
		break;
}

?>