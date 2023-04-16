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
function get_my_quizzes()
{
    global $conn;
    $student_id = $_SESSION["student_id"];
    $sql = mysqli_query($conn, "SELECT * FROM quiz_results WHERE student_id = '$student_id'");
    $my_quizzes = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        $my_quizzes[] = $row;
    }
    return $my_quizzes;
}


$my_quizzes = get_my_quizzes($student_id);
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

                                            My Quizzes

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
                                <div class="page-separator__text">My Quizzes</div>
                            </div>
                            <div id="my-quizzes">
                                <div class="row card-group-row">
                                    <?php
                                    foreach ($my_quizzes as $my_quizz) :
                                        $course_id = $my_quizz['course_id'];
                                        $get_course = mysqli_query($conn, "SELECT * FROM course WHERE course_id = '$course_id'");
                                        $course = mysqli_fetch_assoc($get_course);
                                    ?>
                                        <div class="card-group-row__col col-md-6">

                                            <div class="card card-group-row__card card-sm">
                                                <div class="card-body d-flex align-items-center">
                                                    <a href="student-take-quiz.php" class="avatar overlay overlay--primary avatar-4by3 mr-12pt">
                                                        <img src="<?php echo $course['image_path']; ?>" alt="Angular Routing In-Depth" class="avatar-img rounded">
                                                        <span class="overlay__content"></span>
                                                    </a>
                                                    <div class="flex mr-12pt">
                                                        <a class="card-title" href="student-take-quiz.php"><?php echo $course['course_title']; ?></a>
                                                        <div class="card-subtitle text-50">
                                                            <?php
                                                            $date = strtotime($my_quizz['date']);
                                                            $now = time();
                                                            $diff = $now - $date;

                                                            if ($diff < 60) {
                                                                echo "Just now";
                                                            } elseif ($diff < 3600) {
                                                                $minutes = floor($diff / 60);
                                                                echo $minutes . " minutes ago";
                                                            } elseif ($diff < 86400) {
                                                                $hours = floor($diff / 3600);
                                                                echo $hours . " hours ago";
                                                            } else {
                                                                echo "on " . date('j F, Y', $date);
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $score = $my_quizz['score'];
                                                    ?>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="lead text-headings lh-1"><?php echo $score; ?></span>
                                                        <small class="text-50 text-uppercase text-headings">Score</small>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-0" style="height: 4px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $score; ?>%;" aria-valuenow="<?php echo $score; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>


                                                <div class="card-footer">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex mr-2">
                                                            <?php
                                                            if ($score == 100) {
                                                                echo '<p>Completed!</p><a href="student-take-quiz.php?id=' . $my_quizz['course_id'] . '" class="btn btn-light btn-sm">

                                                                    <i class="material-icons icon--left">refresh</i> Retake
    
                                                                </a>';
                                                            } else {
                                                                echo '<a href="student-take-quiz.php?id=' . $my_quizz['course_id'] . '" class="btn btn-light btn-sm">

                                                                    <i class="material-icons icon--left">refresh</i> Continue
    
                                                                </a>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php if (empty($my_quizzes)) : ?>
                                            <div class="col-md-12">
                                                <p>No Quizzes found.</p>
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
                                <li class="sidebar-menu-item active">
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
                                <li class="sidebar-menu-item">
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