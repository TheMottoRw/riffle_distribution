<?php
session_start();
include_once "api_access.php";
if (isset($_SESSION['edit_id'])) unset($_SESSION['edit_id']);
$apiPostReq = curlGetRequest("posts.php?cate=bydistrict&district=" . $_SESSION['sess_district']);
$apiPosts = json_decode($apiPostReq, TRUE);
?>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Posts</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/postsbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!--    Charts files-->
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="assets/vendor/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="assets/vendor/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="assets/vendor/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/vendor/chart.js/Chart.js"></script>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

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
<main class="container"><br><br><br><br><br><br><br><br>

    <!-- Contact Section Heading -->
    <h1 class="text-center">Dashboard of Ripple distribution and submission</h1>
    <input type="hidden" id="sessid" value="<?= $_SESSION['sess_id']; ?>">
    <div class="card-body">
        <canvas id="barChartExample"></canvas>
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
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<!-- Posts -->
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
<!--Charts files-->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/popper.js/umd/popper.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/vendor/jquery-validation/jquery.validate.min.js"></script>


<script>
    loadChartsData();
    // load charts data
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
    function loadChartsData(){
        ajax('http://localhost/RUT/Methode/armory/api/requests/assignment.php?cate=dashboard&sess_id='+$("#sessid").val(),null,'GET','json',function(res){
            formatToChartData(res);
        });
    }
    function formatToChartData(obj){
        var title = [],nonreturned = [],returned = [];
        for(let i =0;i < obj.length; i++){
            let object = obj[i];
            title.push(object.date);
            nonreturned.push(obj[i].stats.returned);
            returned.push(obj[i].stats.not_returned);
        }
        populateChartData(title,returned,nonreturned);
        // console.log(title.toString());
        // console.log(nonreturned.toString());
        // console.log(returned.toString());
    }
    function populateChartData(dates,dataset1,dataset2){
        var ctx1 = $("canvas").get(0).getContext("2d");
        var gradient1 = ctx1.createLinearGradient(150, 0, 150, 300);
        gradient1.addColorStop(0, 'rgba(133, 180, 242, 0.91)');
        gradient1.addColorStop(1, 'rgba(255, 119, 119, 0.94)');

        var gradient2 = ctx1.createLinearGradient(146.000, 0.000, 154.000, 300.000);
        gradient2.addColorStop(0, 'rgba(104, 179, 112, 0.85)');
        gradient2.addColorStop(1, 'rgba(76, 162, 205, 0.85)');

        var bgColor1 = [], bgColor2 = [];
        dates.map((x) => bgColor1.push(gradient2));
        dates.map((x) => bgColor2.push(gradient1));

        var BARCHARTEXMPLE    = $('#barChartExample');
        var barChartExample = new Chart(BARCHARTEXMPLE, {
            type: 'bar',
            options: {
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: '#eee'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: '#eee'
                        }
                    }]
                },
            },
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Returned riffles",
                        backgroundColor: bgColor1,
                        hoverBackgroundColor: bgColor1,
                        borderColor: bgColor1,
                        borderWidth: 1,
                        data: dataset1,
                    },
                    {
                        label: "Non returned riffles",
                        backgroundColor: bgColor2,
                        hoverBackgroundColor: bgColor2,
                        borderColor: bgColor2,
                        borderWidth: 1,
                        data: dataset2,
                    }
                ]
            }
        });

    }
</script>
</html>