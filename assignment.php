<?php
session_start();
include_once "api_access.php";
if (isset($_SESSION['edit_id'])) unset($_SESSION['edit_id']);

$apiPostReq = curlGetRequest("posts.php?cate=bydistrict&district=" . $_SESSION['sess_district']);
$apiPosts = json_decode($apiPostReq, TRUE);
$apiAssignmentsReq = curlGetRequest("assignment.php?cate=bydeployer&deployer=" . $_SESSION['sess_id']);
$apiAssignments = json_decode($apiAssignmentsReq, TRUE);
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Assignment </title>
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
<?php include_once "includes/headers_logged.php"; ?>
<main class="container"><br><br><br><br><br><br>

    <!-- Contact Section Heading -->
    <h2 class="text-center">Assign police to post</h2>

    <div class="table-responsive">
        <input type="button" class="genric-btn primary circle" data-toggle="modal" data-target="#addActivity"
               value="Make an assignment">
        <?php
        if (isset($_POST['btnRegister'])) {
            $postData = array_merge(['cate' => 'register'], $_POST, $_SESSION);
            $resp = curlPostRequest('assignment.php', $postData);
            $respArr = json_decode($resp, TRUE);
            if (isset($respArr['message'])) {
                echo $respArr['message'];
            }
        }
        ?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Police</th>
                <th>Post</th>
                <th>Weapon</th>
                <th>Given on</th>
                <th>Return date</th>
                <th>Workdate</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($apiAssignments as $key => $obj) {
            ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= $obj['police_name']; ?></td>
                <td><?= $obj['post_name']; ?></td>
                <td><?= $obj['weapon_serial_number']; ?></td>
                <td><?= $obj['assigned_on']; ?></td>
                <td><?= $obj['returned_on']; ?></td>
                <td><?= $obj['work_date']; ?></td>
                <td>
                    <?php if ($obj['weapon_serial_number'] == null) { ?>
                        <a href="#assign.php?id=<?= $obj['id'];?>" class=" genric-btn primary-border" title="Edit"><span
                                    class="fa fa-plus-square"></span> Assign</a>
                    <?php } ?>
                    <a href="assignmentEdit.php?id=<?= $obj['id']; ?>" class="genric-btn info-border"
                       title="Edit"><span class="fa fa-edit"></span> Edit</a>

                    <a href="#" class="genric-btn danger-border" title="Delete"><span class="fa fa-trash"></span>
                        Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<div class="portfolio-modal modal fade" id="addActivity" tabindex="-1" role="dialog"
     aria-labelledby="portfolioModal2Label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= $_SESSION['PHP_SELF']; ?>" method="POST" class="form-contact contact_form">
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12"><br>
                                <!-- Portfolio Modal - Title -->
                                <h1 class="portfolio-modal-title text-center text-secondary text-uppercase mb-0">
                                    Assign police to post</h1>
                                <hr>
                                <div class="form-group">
                                    <label>Post</label>
                                    <select name="post" class="form-control">
                                        <option value="default">Select post</option>
                                        <?php
                                        foreach ($apiPosts as $post){
                                        ?>
                                        <option value="<?= $post['id']; ?>"><?= $post['name']; ?></option>
                                        <?php } ?>
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Police ID</label>
                                    <input class="form-control" name="police" id="police" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Workdate</label>
                                    <input class="form-control" name="workdate" id="date" type="date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="genric-btn primary circle pull-right" type="submit" name="btnRegister"
                           value="Register"/>
                    <button class="genric-btn danger-border circle pull-right" href="#" data-dismiss="modal">
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
<script src="./assets/js/contact.js"></script>
<!--<script src="./assets/js/jquery.form.js"></script>-->
<!--<script src="./assets/js/jquery.validate.min.js"></script>-->
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>
</html>
</html>