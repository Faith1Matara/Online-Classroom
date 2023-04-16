<?php

include "./../Include/config.php";
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("location: ./login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link href="./Public/Css/css8f03.css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="./../Public/vendor/spinkit.css" rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="./../Public/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="./../Public/Css/material-icons.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="./../Public/Css/fontawesome.css" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="./../Public/Css/preloader.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="./../Public/Css/app.css" rel="stylesheet">
    <style>
        @media print {
            #insrtuctor-table {
                display: block;
            }
        }
    </style>
</head>

<body class="layout-sticky layout-sticky-subnav ">

    <div class="preloader">
        <div class="sk-chase">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>

        <!-- <div class="sk-bounce">
    <div class="sk-bounce-dot"></div>
    <div class="sk-bounce-dot"></div>
  </div> -->

        <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.php -->
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header mb-0" data-fixed>
            <div class="mdk-header__content">

                <!-- Navbar -->

                <div class="navbar navbar-expand pr-0 navbar-light bg-white navbar-shadow" id="default-navbar" data-primary>

                    <!-- Navbar Toggler -->

                    <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span>
                    </button>

                    <!-- // END Navbar Toggler -->

                    <!-- Navbar Brand -->

                    <a href="./../index.php" class="navbar-brand mr-16pt">

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./../Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>

                    <!-- // END Navbar Brand -->

                    <!-- Navbar Search -->

                    <form class="search-form navbar-search d-none d-md-flex mr-16pt" action="">
                        <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        <input type="text" class="form-control" placeholder="Search ...">
                    </form>

                    <!-- // END Navbar Search -->

                    <div class="flex"></div>

                    <!-- Navbar Menu -->

                    <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">


                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown" data-caret="false">

                                <span class="avatar avatar-sm mr-8pt2">

                                    <span class="avatar-title rounded-circle bg-primary"><i class="material-icons">account_box</i></span>

                                </span>

                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header"><strong>Account</strong></div>
                                <a class="dropdown-item" href="edit-account.php">Edit Account</a>
                                <a class="dropdown-item" href="./logout.php">Logout</a>
                            </div>
                        </div>
                    </div>

                    <!-- // END Navbar Menu -->

                </div>

                <!-- // END Navbar -->

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <!-- Drawer Layout -->
            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">

                <!-- Drawer Layout Content -->
                <div class="mdk-drawer-layout__content page-content">

                    <div class="pt-32pt">
                        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                    <h2 class="mb-0">Manage Students</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./admin-dashboard.php">Dashboard</a></li>

                                        <li class="breadcrumb-item active">

                                            Manage Students

                                        </li>

                                    </ol>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="page-section border-bottom-2">
                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Manage Student</div>
                            </div>

                            <div class="card mb-32pt">
                            <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" onclick="printTable()">Print</button>
                                </div>
                                <div class="table-responsive" data-toggle="lists" data-lists-sort-by="js-lists-values-from" data-lists-sort-desc="true" data-lists-values='["js-lists-values-first-name", "js-lists-values-last-name", "js-lists-values-email", "js-lists-values-action"]'>

                                    <table class="table mb-0 thead-border-top-0 table-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 18px;" class="pr-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#leaves" id="customCheckAllleaves">
                                                        <label class="custom-control-label" for="customCheckAllleaves"><span class="text-hide">Toggle all</span></label>
                                                    </div>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-first-name">First Name</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-last-name">Last Name</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-email">Email</a>
                                                </th>
                                                <th style="width: 48px;" colspan="2" class="text-center">
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-action">Action</a>
                                                </th>
                                                <th style="width: 24px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="leaves">
                                            <?php
                                            // Replace with your SQL query to retrieve the data from the instructor table
                                            $sql = "SELECT * FROM student";

                                            // Execute the SQL query and fetch the data
                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td class="pr-0">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck<?php echo $row['id']; ?>">
                                                            <label class="custom-control-label" for="customCheck<?php echo $row['id']; ?>"><span class="text-hide">Check</span></label>
                                                        </div>
                                                    </td>
                                                    <td class="js-lists-values-first-name"><?php echo $row['first_name']; ?></td>
                                                    <td class="js-lists-values-last-name"><?php echo $row['last_name']; ?></td>
                                                    <td class="js-lists-values-email"><?php echo $row['email']; ?></td>
                                                    <td>
                                                        <a href="edit-student.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">Edit</a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo $row['email'] == 'student' ? 'delete-student.php?id=' : 'delete-student.php?id='; ?><?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive d-none" id="studenttable">

                                    <table class="table mb-0 thead-border-top-0 table-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 18px;" class="pr-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#leaves" id="customCheckAllleaves">
                                                        <label class="custom-control-label" for="customCheckAllleaves"><span class="text-hide">Toggle all</span></label>
                                                    </div>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-first-name">First Name</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-last-name">Last Name</a>
                                                </th>
                                                <th>
                                                    <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-email">Email</a>
                                                </th>
                                               
                                                <th style="width: 24px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="leaves">
                                            <?php
                                            // Replace with your SQL query to retrieve the data from the instructor table
                                            $sql = "SELECT * FROM student";

                                            // Execute the SQL query and fetch the data
                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <tr>
                                                    <td class="pr-0">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck<?php echo $row['id']; ?>">
                                                            <label class="custom-control-label" for="customCheck<?php echo $row['id']; ?>"><span class="text-hide">Check</span></label>
                                                        </div>
                                                    </td>
                                                    <td class="js-lists-values-first-name"><?php echo $row['first_name']; ?></td>
                                                    <td class="js-lists-values-last-name"><?php echo $row['last_name']; ?></td>
                                                    <td class="js-lists-values-email"><?php echo $row['email']; ?></td>
                                                    

                                                  
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="container page__container page-section">



                    </div>

                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./../Public/images/logo/black-70%402x.png" width="30" alt="Online Classroom"> Online Classroom
                            </p>
                            <p class="measure-lead-max text-50 small mr-8pt">Online Classroom is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard and more.</p>
                            <p class="mb-8pt d-flex">
                                <a href="#" class="text-70 text-underline mr-8pt small">Terms</a>
                                <a href="#" class="text-70 text-underline small">Privacy policy</a>
                            </p>
                            <p class="text-50 small mt-n1 mb-0">Copyright 2023 &copy; All rights reserved.</p>
                        </div>
                    </div>

                    <!-- // END Footer -->

                </div>
                <!-- // END drawer-layout__content -->

                <!-- Drawer -->

                <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
                    <div class="mdk-drawer__content top-navbar">
                        <div class="sidebar sidebar-dark-pickled-bluewood sidebar-left sidebar-p-t" data-perfect-scrollbar>

                            <!-- Sidebar Content -->

                            <div class="sidebar-heading">Admin</div>
                            <ul class="sidebar-menu">

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="./admin-dashboard.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
                                        <span class="sidebar-menu-text">Admin Dashboard</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="./admin-manage-course.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>
                                        <span class="sidebar-menu-text">Manage Courses</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="./admin-manage-instructor.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
                                        <span class="sidebar-menu-text">Manage Instructors</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item active">
                                    <a class="sidebar-menu-button" href="./admin-manage-student.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
                                        <span class="sidebar-menu-text">Manage Students</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="./admin-manage-feedback.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
                                        <span class="sidebar-menu-text">Manage Feedback</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item ">
                                    <a class="sidebar-menu-button" href="./admin-manage-helpcenter.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
                                        <span class="sidebar-menu-text">Manage Helpcenter</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- // END Sidebar Content -->

                        </div>
                    </div>
                </div>

                <!-- // END Drawer -->

            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END Header Layout Content -->

    </div>
    <!-- // END Header Layout -->
    <script>
        function printTable() {
            var printContents = document.getElementById('studenttable').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <!-- jQuery -->
    <script src="./../Public/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="./../Public/vendor/popper.min.js"></script>
    <script src="./../Public/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="./../Public/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="./../Public/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="./../Public/vendor/material-design-kit.js"></script>

    <!-- App JS -->
    <script src="./../Public/Js/app.js"></script>

    <!-- Preloader -->
    <script src="./../Public/Js/preloader.js"></script>

    <!-- Global Settings -->
    <script src="./../Public/js/settings.js"></script>

    <!-- Moment.js -->
    <script src="./../Public/vendor/moment.min.js"></script>
    <script src="./../Public/vendor/moment-range.js"></script>

    <!-- Chart.js -->
    <script src="./../Public/vendor/Chart.min.js"></script>

    <!-- UI Charts Page JS -->
    <script src="./../Public/js/chartjs-rounded-bar.js"></script>
    <script src="./../Public/js/chartjs.js"></script>

    <!-- Chart.js Samples -->
    <script src="./../Public/js/page.instructor-dashboard.js"></script>

    <!-- List.js -->
    <script src="./../Public/vendor/list.min.js"></script>
    <script src="./../Public/js/list.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>


</html>