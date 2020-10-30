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
		
        case 'delete':
        $del = $userObj->deleteUser($_GET);
            if($del['status']=='ok') header("location:".$_SERVER['HTTP_REFERER']);
         break;
        case 'reset':
            header("Content-Type:text/html");
            $res = $userObj->resetUser($_GET);
            if($res['status'] == 'ok')
                echo "<script>alert('Password resetted successful');</script>";
            else if($res['status']=='notmatch') echo "<script>alert('Password does not match');</script>";
            else echo "<script>alert('Failed to reset password')</script>";
            echo "<script>window.location='../../users.php';</script>";
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
			echo json_encode(['error'=>"value of parameter category not known"]);
			break;
	}
	break;
	default:
        echo json_encode(['error'=>$_SERVER['REQUEST_METHOD']." Request method not allowed"]);
		break;
}

?>