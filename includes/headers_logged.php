<header>
    <!-- Header Start -->
    <div class="header-area header-transparent bg-dark " style="background: url('assets/img/hero/hero2.png')">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="menu-wrapper d-flex align-items-center justify-content-between">
                    <!-- Logo -->
                    <div class="logo">
                        <h2 class="text-white">
                            <a href="#"><img src="assets/img/logo/RNP_LOGO.png" alt="" width="100px"></a>
                            RNP - ARMORY AND RIFFLE DISTRIBUTION
                        </h2>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-menu f-right d-none d-lg-block">
                        <nav>
                            <ul id="navigation">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><a href="posts.php">Posts</a></li>
                                <li><a href="assignment.php">Assignment</a></li>
                                <li><a href="requests.php">Request</a></li>
                                <li><a href="returned_reports.php">Returned Weapon</a></li>
                                <li><a href="nonreturned_report.php">Non-Returned </a></li>
                                <li><a href="standard_reports.php">Work locations </a></li>
                                <li><a href="signout.php">Signout </a></li>

                                <!--                                <li><a href="routine.php">Routine</a></li>-->
                            </ul>
                        </nav>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
<?php validateSession(["Deployer"]); ?>