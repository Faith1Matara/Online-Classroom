<?php
include "./../Include/config.php";
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["student_id"])) {
    header("location: ./../login.php");
    exit;
}
$student_id = $_SESSION["student_id"];
function get_course_progress()
{
    global $conn;
    $student_id = $_SESSION["student_id"];
    $sql = mysqli_query($conn, "SELECT * FROM enroll_students WHERE student_id = '$student_id'");
    $course_progs = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        $course_progs[] = $row;
    }
    return $course_progs;
}


$course_progs = get_course_progress($student_id);
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
                                    <h2 class="mb-0">Dashboard</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./student-dashboard.php">Dashboard</a></li>

                                        <li class="breadcrumb-item active">

                                            Track Progress

                                        </li>

                                    </ol>

                                </div>
                            </div>

                            <div class="row" role="tablist">
                                <div class="col-auto">
                                    <a href="student-my-courses.php" class="btn btn-outline-secondary">My Courses</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="container page__container">
                        <div class="page-section tab-content">
                            <div class="page-separator">
                                <div class="page-separator__text">My Progress</div>
                            </div>
                            <div id="track-progress">
                                <div class="col-lg-6 mb-8pt mb-sm-0">
                                    <?php
                                    foreach ($course_progs as $course_prog) :
                                        $course_id = $course_prog['course_id'];
                                        $get_course = mysqli_query($conn, "SELECT * FROM course WHERE course_id = '$course_id'");
                                        $course = mysqli_fetch_assoc($get_course);
                                    ?>
                                        <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 mb-16pt" data-toggle="popover" data-trigger="click">

                                            <div class="card-body d-flex flex-column">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex">
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded mr-12pt z-0 o-hidden">
                                                                <div class="overlay">
                                                                    <img src="<?php echo $course['image_path'] ?>" width="40" height="40" alt="Angular" class="rounded">
                                                                    <span class="overlay__content overlay__content-transparent">
                                                                        <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                            <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex">
                                                                <div class="card-title"><?php echo $course['course_title']; ?></div>
                                                                <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a href="student-take-lesson.php?id=<?php echo $course['course_id'] ?>" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="popoverContainer d-none">
                                            <div class="media">
                                                <div class="media-left mr-12pt">
                                                    <img src="./../Public/images/paths/angular_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                </div>
                                                <div class="media-body">
                                                    <div class="card-title">Angular</div>
                                                    <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                                </div>
                                            </div>

                                            <p class="mt-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

                                            <div class="my-32pt">
                                                <div class="d-flex align-items-center mb-8pt justify-content-center">
                                                    <div class="d-flex align-items-center mr-8pt">
                                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                                        <p class="flex text-50 lh-1 mb-0"><small>50 minutes left</small></p>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="student-take-lesson.php" class="btn btn-primary mr-8pt">Resume</a>
                                                    <a href="student-take-lesson.php" class="btn btn-outline-secondary ml-0">Start over</a>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <small class="text-50 mr-8pt">Your rating</small>
                                                <div class="rating mr-8pt">
                                                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                                                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                                                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                                                    <span class="rating__item"><span class="material-icons text-primary">star</span></span>
                                                    <span class="rating__item"><span class="material-icons text-primary">star_border</span></span>
                                                </div>
                                                <small class="text-50">4/5</small>
                                            </div>
                                        </div>
                                    <?php
                                    endforeach
                                    ?>
                                    <?php if (empty($course_progs)) : ?>
                                        <div class="col-md-12">
                                            <p>No courses found.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./../Public/images/logo/black-70%402x.png" width="30" alt="Luma"> Online Classroom
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

                            <div class="sidebar-heading">Student</div>
                            <ul class="sidebar-menu nav nav-tabs">

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="student-dashboard.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">account_box</span>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="student-my-courses.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">search</span>
                                        <span class="sidebar-menu-text">My Courses</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="dashboard-my-quizzes.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">poll</span>
                                        <span class="sidebar-menu-text">My Quizzes</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="student-my-acheivements.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">assignment_turned_in</span>
                                        <span class="sidebar-menu-text">achievements</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item active">
                                    <a class="sidebar-menu-button" href="dashboard-track-progress.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">timeline</span>
                                        <span class="sidebar-menu-text">Track Progress</span>
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

    <!-- Flatpickr -->
    <script src="./../Public/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="./../Public/js/flatpickr.js"></script>

    <!-- Moment.js -->
    <script src="./../Public/vendor/moment.min.js"></script>
    <script src="./../Public/vendor/moment-range.js"></script>

    <!-- Chart.js -->
    <script src="./../Public/vendor/Chart.min.js"></script>
    <script src="./../Public/js/chartjs.js"></script>

    <!-- Chart.js Samples -->
    <script src="./../Public/js/page.student-dashboard.js"></script>

    <!-- List.js -->
    <script src="./../Public/vendor/list.min.js"></script>
    <script src="./../Public/js/list.js"></script>

    <!-- Tables -->
    <script src="./../Public/js/toggle-check-all.js"></script>
    <script src="./../Public/js/check-selected-row.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>

</html>