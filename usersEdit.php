<?php
session_start();
include_once "api_access.php";

if(isset($_GET['id'])) $_SESSION['edit_id'] = $_GET['id'];
elseif(isset($_SESSION['edit_id'])) $_GET['id'] = $_SESSION['edit_id'];
else header("location:users.php");

$apiUsersReq = curlGetRequest("users.php?cate=loadbyid&id=".$_GET['id']);
$apiUsers = json_decode($apiUsersReq, TRUE);
$userObj = '';
if(count($apiUsers)>0) $userObj = $apiUsers[0];
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Edit users </title>
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
<?php include_once "includes/header_admin.php";?>
<main><br><br><br><br><br><br>
    <div class="row">
        <div class="col-lg-4 offset-4">
            <form class="form-contact contact_form" action="<?= $_SERVER['PHP_SELF'];?>"  method="POST" id="contactForm">
                <div class="row">
                    <h1>Update users</h1><hr>
                    <div class="col-12">
                        <?php
                            if(isset($_POST['btnUpdate'])){
                                $postData = array_merge(['cate'=>'update'],$_GET,$_POST,$_SESSION);
                                $resp = curlPostRequest('users.php',$postData);
                                $respArr = json_decode($resp,TRUE);
                                echo $respArr['message'];
                            }
                        ?>
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control valid" name="name" id="name" type="text"
                                       placeholder="Enter your name" value="<?= $userObj['name']; ;?>">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control valid" name="phone" id="phone" type="number"
                                       placeholder="Enter your phone number" value="<?= $userObj['phone']; ;?>">
                            </div>
                            <div class="form-group">
                                <label>Police ID</label>
                                <input class="form-control" name="police_id" id="police_id" type="text" value="<?= $userObj['police_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>Rank</label>
                                <input class="form-control" name="rank" id="rank" type="text" value="<?= $userObj['ranks'];?>">
                            </div>
                            <div class="form-group">
                                <label>District</label>
                                <input class="form-control" name="district" id="district" type="text"  value="<?= $userObj['district'];?>">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="default">Select category</option>
                                    <option value="Superadmin" <?= $userObj['category']=='Superadmin'?"selected":'';?>>Super admin</option>
                                    <option value="Deployer" <?= $userObj['category']=='Deployer'?"selected":'';?>>In charge of deployment</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Level</label>
                                <select name="level" class="form-control" style="width: 100%">
                                    <option value="default">Select level</option>
                                    <option selected>District</option>
                                </select>
                            </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input class="genric-btn primary circle" type="submit" name="btnUpdate" value="Update">
                </div>
            </form>
        </div>
    </div>
</main>
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

</body>
</html>