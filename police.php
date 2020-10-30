<?php
session_start();
include_once "api_access.php";
if(isset($_SESSION['edit_id'])) unset($_SESSION['edit_id']);
$apiPoliceReq = curlGetRequest("police.php?cate=load&" . sessionsToGetParams());
$apiPolice = json_decode($apiPoliceReq, TRUE);
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Police</title>
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
            <div class="preloader-circle "></div>
            <div class="preloader-img pere-text">
                <img src="assets/img/logo/loder.png" class="genric-btn primary circle" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Preloader Start -->
<?php
$headers = $_SESSION['sess_category'] == 'Superadmin'?'header_admin.php':'headers_logged.php';
include_once "includes/".$headers; ?>
<main class="container-fluid" style="padding: 0% 2% 0% 2%"><br><br><br><br><br>

    <!-- Contact Section Heading -->
    <h2 class="text-center">Registered police</h2>

    <div class="table-responsive">
        <input type="button" class="genric-btn primary circle" data-toggle="modal" data-target="#addPolice"
               value="Add Police">
        <?php
        if (isset($_POST['btnRegister'])) {
            $postData = array_merge(['cate' => 'register', 'sessid' => $_SESSION['sess_id']], $_POST);
            $resp = curlPostRequest("police.php", $postData);
            $respArr = json_decode($resp, TRUE);
            echo $respArr['message'];
        }
        ?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Names</th>
                <th>Phone</th>
                <th>Police ID</th>
                <th>Ranks</th>
                <th>Status</th>
                <th colspan="5">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($apiPolice as $key => $obj) {
                ?>
                <tr>
                    <td><?= $key + 1; ?></td>
                    <td><?= $obj['name']; ?></td>
                    <td><?= $obj['phone']; ?></td>
                    <td><?= $obj['police_id']; ?></td>
                    <td><?= $obj['ranks']; ?></td>
                    <td><?= $obj['deployment'].($obj['deployment']=='Not Ready'?"<br>[".$obj['comment']."]":""); ?></td>
                    <td>
                        <a href="policeDeploy.php?id=<?= $obj['id']; ?>" class="genric-btn bg-secondary"
                           title="Police deployment">Change Status</a>
                        <a href="policeEdit.php?id=<?= $obj['id']; ?>" class="genric-btn primary-border"
                           title="Police edit">Edit</a>
                        <a href="api/requests/police.php?cate=delete&id=<?= $obj['id']; ?>"
                           class="genric-btn danger-border" title="Delete">Delete</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<div class="portfolio-modal modal fade" id="addPolice" tabindex="-1" role="dialog"
     aria-labelledby="portfolioModal2Label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="" class="form-contact">
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12"><br>
                                <!-- Portfolio Modal - Title -->
                                <h4 class="portfolio-modal-title text-center text-secondary text-uppercase mb-0">
                                    Register new
                                    police</h4><br>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control valid" name="name" id="name" type="text"
                                           placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control valid" name="phone" id="phone" type="number"
                                           placeholder="Enter your phone number">
                                </div>
                                <div class="form-group">
                                    <label>Police ID</label>
                                    <input class="form-control" name="police_id" id="police_id" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Rank</label>
                                    <input class="form-control" name="rank" id="rank" type="text">
                                </div>
                                <div class="form-group">
<!--                                    <label>Deployment</label>-->
                                    <input class="form-control" name="district" id="district" type="hidden" value="Ready">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" id="password" type="password"
                                           placeholder="Enter strong password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="genric-btn primary circle" type="submit" name="btnRegister" value="Register">
                        <button class="genric-btn danger-border circle" href="#" data-dismiss="modal">
                            <i class="fas fa-times"></i>
                            Close
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

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
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<!-- Progress -->
<script src="./assets/js/jquery.barfiller.js"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="./assets/js/jquery.counterup.min.js"></script>
<script src="./assets/js/waypoints.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/hover-direction-snake.min.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<!--<script src="./assets/js/jquery.form.js"></script>-->
<!--<script src="./assets/js/jquery.validate.min.js"></script>-->
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</html>
