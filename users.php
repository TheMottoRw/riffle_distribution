<?php
session_start();
include_once "api_access.php";
if(isset($_SESSION['edit_id'])) unset($_SESSION['edit_id']);
$apiUsersReq = curlGetRequest("users.php?cate=load");
$apiUsers = json_decode($apiUsersReq, TRUE);
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Users</title>
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
            <div class="preloader-circle "></div>
            <div class="preloader-img pere-text">
                <img src="assets/img/logo/loder.png" class="genric-btn primary circle" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Preloader Start -->
<?php include_once "includes/header_admin.php"; ?>
<main class="container"><br><br><br><br><br><br>
    <section>
        <div>
            <!-- Contact Section Heading -->
            <h2 class="text-center">Registered user</h2>

            <div class="table-responsive">
                <input type="button" class="genric-btn primary circle" data-toggle="modal" data-target="#addActivity"
                       value="New User">
                <?php
                if (isset($_POST['btnRegister'])) {
                    $postData = array_merge(['cate' => 'register'], $_POST, $_SESSION);
                    $resp = curlPostRequest("users.php", $postData);
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
                        <th>Rank</th>
                        <th>District</th>
                        <th>Level</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($apiUsers as $key => $obj) {
                        ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $obj['name']; ?></td>
                            <td><?= $obj['phone']; ?></td>
                            <td><?= $obj['police_id']; ?></td>
                            <td><?= $obj['ranks']; ?></td>
                            <td><?= $obj['district']; ?></td>
                            <td><?= $obj['level']; ?></td>
                            <td><?= $obj['category']; ?></td>
                            <td>
                                <a href="usersEdit.php?id=<?= $obj['id'];?> " class="genric-btn primary-border" data-toggle="modal" data-target="#resetPassword<?= $obj['id']; ?>" title="Reset"><span
                                            class="fa fa-unlock"></span> Reset</a>
                                <a href="usersEdit.php?id=<?= $obj['id'];?> " class="genric-btn primary-border" title="Edit"><span
                                            class="fa fa-edit"></span>Edit</a>
                                <a href="api/requests/users.php?cate=delete&id=<?= $obj['id'] ?>" class="genric-btn danger-border" title="Delete"><span
                                            class="fa fa-trash"></span>Delete</a>

                                <div class="portfolio-modal modal fade" id="resetPassword<?= $obj['id']; ?>" tabindex="-1" role="dialog"
                                     aria-labelledby="portfolioModal2Label" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <form method="GET" action="api/requests/users.php" class="form-contact contact_form">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-12"><br>
                                                                <!-- Portfolio Modal - Title -->
                                                                <h4 class="portfolio-modal-title text-center text-secondary text-uppercase mb-0">
                                                                    Reset user password</h4>
                                                                <hr>
                                                                <input type="hidden" name="cate" value="reset">
                                                                <input type="hidden" name="id" value="<?= $obj['id'];?>">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input class="form-control valid" name="name" id="name" type="text"
                                                                           placeholder="Enter your name" readonly="readonly" value="<?= $obj['name']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <input class="form-control" name="password" id="password" type="password"
                                                                           placeholder="Enter strong password">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Change Password</label>
                                                                    <input class="form-control" name="confPassword" id="confPassword" type="password"
                                                                           placeholder="Confirm password">
                                                                </div>
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

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</main>
<div class="portfolio-modal modal fade" id="addActivity" tabindex="-1" role="dialog"
     aria-labelledby="portfolioModal2Label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" class="form-contact contact_form">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12"><br>
                                <!-- Portfolio Modal - Title -->
                                <h4 class="portfolio-modal-title text-center text-secondary text-uppercase mb-0">
                                    Register
                                    new
                                    user</h4>
                                <hr>
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
                                    <label>District</label>
                                    <input class="form-control" name="district" id="district" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" class="form-control">
                                        <option value="default">Select category</option>
                                        <option value="Superadmin">Super admin</option>
                                        <option value="Deployer">In charge of deployment</option>
                                        <option value="Riffle_distributor">In charge of Riffle distribution</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level" class="form-control" style="width: 100%">
                                        <option value="default">Select level</option>
                                        <option selected>District</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" name="password" id="password" type="password"
                                           placeholder="Enter strong password">
                                </div>
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
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>
</html>