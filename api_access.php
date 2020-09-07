<?php
function curlPostRequest($page,$dataArr){
    $url = 'http://localhost/RUT/Methode/armory/api/requests/';
    $url.=$page;
   //create name value pairs seperated by &
   
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($_POST));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArr);    
 
    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}
function curlGetRequest($page){
    $url = 'http://localhost/RUT/Methode/armory/api/requests/';
    $url.=$page;
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type"=>"application/json"));
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
}
function setSession($arr){
    foreach ($arr as $key=>$val){
        $_SESSION[$key] = $val;
    }
}
function validateSession($allowedSession){
    if(!isset($_SESSION['sessid']) || !isset($_SESSION['category'])) header("location:login.php");
    else{//validate if allowed to access the page
        if($_SESSION['category'] != $allowedSession) {
            session_destroy();
                header("location:login.php");
        }
    }
}
function sessionsToGetParams(){
    $data = "";
    foreach ($_SESSION as $k=>$v){
        $v = str_replace(" ","%20",$v);
        if($data!="") $data.="&".$k."=".$v;
        else $data = $k."=".$v;
    }
    return $data;
}
?>