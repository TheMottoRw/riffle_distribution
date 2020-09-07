<html>
<head>

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


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        ['KMH', 'Kubaka umuhanda', 'Umuhanda',
         new Date(2020, 2, 22), new Date(2020, 5, 20), null, 100, null],
        ['SCH', 'Kuvugurura amashuri', 'Ishuri',
         new Date(2020, 5, 21), new Date(2020, 8, 20), null, 100, null],
        ['2020Autumn', 'Autumn 2020', 'autumn',
         new Date(2020, 8, 21), new Date(2020, 11, 20), null, 100, null],
        ['2020Winter', 'Winter 2020', 'winter',
         new Date(2020, 11, 21), new Date(2020, 2, 21), null, 100, null],
        ['2020Spring', 'Spring 2020', 'spring',
         new Date(2020, 2, 22), new Date(2020, 5, 20), null, 50, null],
        ['2020Summer', 'Summer 2020', 'summer',
         new Date(2020, 5, 21), new Date(2020, 8, 20), null, 0, null],
        ['2020Autumn', 'Autumn 2020', 'autumn',
         new Date(2020, 8, 21), new Date(2020, 11, 20), null, 0, null],
        ['2020Winter', 'Winter 2020', 'winter',
         new Date(2020, 11, 21), new Date(2016, 2, 21), null, 0, null],
        ['Football', 'Football Season', 'sports',
         new Date(2020, 8, 4), new Date(2020, 1, 1), null, 100, null],
        ['Baseball', 'Baseball Season', 'sports',
         new Date(2020, 2, 31), new Date(2020, 9, 20), null, 14, null],
        ['Basketball', 'Basketball Season', 'sports',
         new Date(2020, 9, 28), new Date(2020, 5, 20), null, 86, null],
        ['Hockey', 'Hockey Season', 'sports',
         new Date(2020, 9, 8), new Date(2020, 5, 21), null, 89, null]
      ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
<?php
include_once "includes/headers_logged.php";
?><br><br><br><br><br><br><br>
<div class="container">
  <div id="chart_div"></div>
</div>
</body>
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
<!--<script src="./assets/js/contact.js"></script>-->
<!--<script src="./assets/js/jquery.form.js"></script>-->
<!--<script src="./assets/js/jquery.validate.min.js"></script>-->
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>
</html>

