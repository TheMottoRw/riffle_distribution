<?php
session_start();
include_once "api_access.php";
if (isset($_GET['id'])) $_SESSION['edit_id'] = $_GET['id'];
elseif (isset($_SESSION['edit_id'])) $_GET['id'] = $_SESSION['edit_id'];

$apiPostReq = curlGetRequest("posts.php?cate=bydistrict&district=" . $_SESSION['sess_district']);
$apiPosts = json_decode($apiPostReq, TRUE);
$apiAssignmentsReq = curlGetRequest("assignment.php?cate=loadbyid&id=".$_GET['id']."&" . $_SESSION['sess_id']);
$apiAssignments = json_decode($apiAssignmentsReq, TRUE);
$apiPoliceReq = curlGetRequest("police.php?cate=byready&deployer=" . $_SESSION['sess_id']);
$apiPolice = json_decode($apiPoliceReq, TRUE);

$assignmentObj = '';
if(count($apiAssignments)>0) $assignmentObj = $apiAssignments[0];

?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Edit assignment</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
<!--    <link rel="stylesheet" href="assets/css/nice-select.css">-->
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!-- ? Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="assets/img/logo/loder.png" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Preloader Start -->
<?php include_once "includes/headers_logged.php";?>
<main><br><br><br><br><br><br>
    <div class="row">
        <div class="col-lg-4 offset-4">
            <form class="form-contact contact_form" action="<?= $_SERVER['PHP_SELF'];?>" method="POST" id="contactForm" novalidate="novalidate">
                <div class="row">
                    <h1>Update Assignment history</h1><hr>
                    <div class="col-12">
                        <?php
                        if(isset($_POST['btnUpdate'])){
                            $postData = array_merge(['cate'=>'update'],$_GET,$_SESSION,$_POST);
                            $resp = curlPostRequest('assignment.php',$postData);
                            $respArr = json_decode($resp,TRUE);
                            if(isset($respArr['message'])){
                                echo $respArr['message'];
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Post</label>
                            <select name="post" class="form-control">
                                <option value="default">Select post</option>
                                <?php
                                foreach ($apiPosts as $post){
                                    ?>
                                    <option value="<?= $post['id']; ?>" <?= $post['id'] == $assignmentObj['post']?"selected":''; ?>><?= $post['name']; ?></option>
                                <?php } ?>
                                ?>
                            </select>
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label>Police</label>-->
<!--                            <input class="form-control" name="police" id="police" type="text" value="--><?//= $assignmentObj['police_id']; ?><!--">-->
<!--                        </div>-->

                        <div class="form-group">
                            <label>Police</label>
                            <select class="form-control" name="police" id="police">
                                <option value="default">Select police</option>
                                <?php foreach ($apiPolice as $afande) { ?>
                                    <option value="<?= $afande['id']; ?>" <?= $apiAssignments[0]['police'] == $afande['id']?"selected":"" ?>><?= $afande['name'] . " - " . $afande['police_id']; ?></option>
                                <?php } ?>
                            </select>
                            <!--                                    <input class="form-control" name="police" id="police" type="text">-->
                        </div>
                        <div class="form-group">
                            Workdate  [<?= "<b>".substr($assignmentObj['work_date'],0,10)."</b>";?>]</label>
                            <input class="form-control" name="workdate" id="workdate" type="date" >
                        </div>
                        <table class="table table-bordered">
                            <center><h3>Assignment history </h3></center>
                            <thead>
                            <tr>
                                <th>#1</th>
                                <th>Police</th>
                                <th>Post</th>
                                <th>Workdate</th>
                            </tr>
                            </thead>
                            <tbody id="assignmentHistory">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input class="genric-btn primary circle" type="submit" name="btnUpdate" value="Update">
                </div>
            </form>
        </div>
    </div>
</main>
</body>
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>

<!-- JS here -->

<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="./assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- Date Picker -->
<script src="./assets/js/gijgo.min.js"></script>
<!-- Nice-select, sticky -->
<!--<script src="./assets/js/jquery.nice-select.min.js"></script>-->
<!--<script src="./assets/js/jquery.sticky.js"></script>-->
<!-- Progress -->
<script src="./assets/js/jquery.barfiller.js"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="./assets/js/jquery.counterup.min.js"></script>
<script src="./assets/js/waypoints.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/hover-direction-snake.min.js"></script>

<!-- contact js -->
<!--<script src="./assets/js/contact.js"></script>-->
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>
<script>
    var assignmentHist = [];
    var d = new Date();
    $("#workdate").change(function(){
        var selectedDate = new Date($(this).val()),
            yesterday = selectedDate;
        yesterday.setDate(yesterday.getDate()-1);
        yesterday = [yesterday.getFullYear(),yesterday.getMonth()+1,yesterday.getDate()];
        console.log(yesterday);
        if(assignmentHist.length != null){
         if(d.setDate($(this).val()-1) == assignmentHist[0]['work_date']){
             console.log("Assigned to previous");
         }else {
             console.log(d);
         }
             }
    });
    $("#police").change(function () {
        if ($(this).val() != "default"
        )
        {
            loadPreviousAssignment();
        }
        else
        {
            $("#assignmentHistory").html("<tr><td colspan='4'><center><font color='brown'>Police should be selected</font></center></td></tr>");
        }
    })
    ;

    function ajax(url, getpars, typ, responseType, responseFunc) {
        $.ajax({
            url: url,
            type: typ,
            data: getpars,
            dataType: responseType,
            success: responseFunc,
            cache: false,
            statuscode: {
                404: function () {
                    alert('Response not found');
                }
            }
        });
    }

    function loadPreviousAssignment() {
        ajax('http://localhost/RUT/Methode/armory/api/requests/assignment.php?cate=bypolice&sess_id=' + $("#sessid").val() + "&police=" + $("#police").val(), null, 'GET', 'json', function (res) {
            assignmentHist = res;
            setLoadedAssignment(res);
        });
    }

    function setLoadedAssignment(obj) {
        var tableData  = "";
        if(obj.length>0){
            for(let i=0;i < obj.length; i++){
                let o = obj[i];
                tableData += "<tr><td>"+(i+1)+"</td>" +
                    "<td>"+o.police_name+"</td>" +
                    "<td>"+o.post_name+"</td>" +
                    "<td>"+o.work_date.substring(0,10)+"</td></tr>";
            }
            $("#assignmentHistory").html(tableData);
        } else {
            $("#assignmentHistory").html("<tr><td colspan='4'><center>No assignment history found</center></td></tr>");
        }
    }
</script>
</html>