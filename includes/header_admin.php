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
                                <li><a href="users.php">Users</a></li>
                                <li><a href="police.php">Police</a></li>
                                <li><a href="weapons.php">Weapons</a></li>
                                <li><a href="returned_reports.php">Returned</a></li>
                                <li><a href="nonreturned_report.php">Non Returned</a></li>
                                <li><a href="standard_reports.php">Work locations</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header-btn -->
                    <div class="header-btns d-none d-lg-block f-right">
                        <a href="signout.php" class="btn">Sign Out</a>
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
<?php validateSession(["Superadmin"]); ?>