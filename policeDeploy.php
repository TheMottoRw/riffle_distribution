<?php
session_start();
include_once "api_access.php";

if (isset($_GET['id'])) $_SESSION['edit_id'] = $_GET['id'];
elseif (isset($_SESSION['edit_id'])) $_GET['id'] = $_SESSION['edit_id'];
else header("location:police.php");

$apiPoliceReq = curlGetRequest("police.php?cate=loadbyid&id=" . $_GET['id'] . "&" . sessionsToGetParams());
$apiPolice = json_decode($apiPoliceReq, TRUE);
$policeObj = '';
if (count($apiPolice) > 0) $policeObj = $apiPolice[0];

?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Edit police</title>
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
    <link rel="stylesheet" href="assets/css/nice-select.css">
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
<?php
$headers = $_SESSION['sess_category'] == 'Superadmin' ? 'header_admin.php' : 'headers_logged.php';
include_once "includes/" . $headers; ?>
<main><br><br><br><br><br><br>
    <div class="row">
        <div class="col-lg-4 offset-4">
            <form class="form-contact contact_form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" id="contactForm"
                  novalidate="novalidate">
                <div class="row">
                    <h1>Deploy police</h1>
                    <hr>
                    <div class="col-12">
                        <?php
                        if (isset($_POST['btnDeploy'])) {
//                            echo ($_POST['district']=="Not Ready"?"Yes":"Bad")." == ";
                            $isCommentInvalid = $_POST['district'] == "Not Ready" && empty(trim($_POST['comment']))?true:is_null(trim($_POST['comment']))?true:false;
                            if($isCommentInvalid){
                                echo "<div class='alert alert-danger'>Reason s/he not ready should be provided </div>";
                            } else {
                            $postData = array_merge(['cate' => 'deploy'], $_GET, $_POST, $_SESSION);
//                                echo json_encode($postData);
                            $resp = curlPostRequest('police.php', $postData);
                            $respArr = json_decode($resp, TRUE);
                            echo $respArr['message'];
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control valid" name="name" id="name" type="text"
                                   placeholder="Enter your name" value="<?= $policeObj['name']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Deployment status</label><br>
                            <select class="form-control valid" name="district" id="district">
                                <option <?= $policeObj['deployment'] == "Ready" ? "selected" : ""; ?>>Ready</option>
                                <option <?= $policeObj['deployment'] == "Not Ready" ? "selected" : ""; ?>>Not Ready
                                </option>
                            </select>
                        </div>
                        <div class="form-group" id="commentForm" style="display: <?= $policeObj['deployment'] == 'Ready'? 'none':'block'; ?>">
                            <label>Reason why s/he is not ready</label><br>
                            <textarea class="form-control valid" id="comment" name="comment" rows="5">
                                <?= $policeObj['comment'];?>
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input class="genric-btn primary circle" type="submit" name="btnDeploy" value="Deploy">
                    </div>
            </form>
        </div>
    </div>
</main>
</body>
<!-- Scroll Up -->
<div id="back-top">
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
<script src="./assets/js/jquery.sticky.js"></script>
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
    $("#district").change(function(){
        if($(this).val() == 'Not Ready') $("#commentForm").show();
        else  $("#commentForm").hide();
    })
</script>
</html>