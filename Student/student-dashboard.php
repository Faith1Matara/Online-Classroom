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
    $sql = mysqli_query($conn, "SELECT * FROM quiz_results WHERE student_id = '$student_id' ORDER BY quiz_id DESC limit 2");
    $my_quizzes = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        $my_quizzes[] = $row;
    }
    return $my_quizzes;
}
$my_quizzes = get_my_quizzes();


function get_course_progress()
{
    global $conn;
    $student_id = $_SESSION["student_id"];
    $sql = mysqli_query($conn, "SELECT * FROM enroll_students WHERE student_id = '$student_id' ORDER BY course_id DESC limit 2");
    $course_progs = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        $course_progs[] = $row;
    }
    return $course_progs;
}
$course_progs = get_course_progress();

function get_courses()
{
    global $conn;
    $student_id = $_SESSION["student_id"];
    $sql = mysqli_query($conn, "SELECT * FROM enroll_students WHERE student_id = '$student_id' ORDER BY course_id DESC LIMIT 2");
    $courses = array();
    while ($row = mysqli_fetch_assoc($sql)) {
        $courses[] = $row;
    }
    return $courses;
}
$courses = get_courses();

function get_achievements($conn, $student_id)
{
    $sql = mysqli_query($conn, "SELECT * FROM achievements where student_id = '$student_id'");
    $achievements = array();
    if ($sql) {
        while ($achievement = mysqli_fetch_assoc($sql)) {
            $achievements[] = $achievement;
        }
    }
    return $achievements;
}
$achievements = get_achievements($conn, $student_id);
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

                        <!-- Notifications dropdown -->
                        <div class="nav-item dropdown dropdown-notifications dropdown-xs-down-full" data-toggle="tooltip" data-title="Messages" data-placement="bottom" data-boundary="window">
                            <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown" data-caret="false">
                                <i class="material-icons icon-24pt">mail_outline</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar class="position-relative">
                                    <div class="dropdown-header"><strong>Messages</strong></div>
                                    <div class="list-group list-group-flush mb-0">

                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <img src="./../Public/images/people/110/woman-5.jpg" alt="people" class="avatar-img rounded-circle">
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Michelle</strong>
                                                    <span class="text-black-70">Clients loved the new design.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 minutes ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <img src="./../Public/images/people/110/woman-5.jpg" alt="people" class="avatar-img rounded-circle">
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Michelle</strong>
                                                    <span class="text-black-70">🔥 Superb job..</span>
                                                </span>
                                            </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // END Notifications dropdown -->

                        <!-- Notifications dropdown -->
                        <div class="nav-item ml-16pt dropdown dropdown-notifications dropdown-xs-down-full" data-toggle="tooltip" data-title="Notifications" data-placement="bottom" data-boundary="window">
                            <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown" data-caret="false">
                                <i class="material-icons">notifications_none</i>
                                <span class="badge badge-notifications badge-accent">2</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar class="position-relative">
                                    <div class="dropdown-header"><strong>System notifications</strong></div>
                                    <div class="list-group list-group-flush mb-0">

                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">3 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-accent">account_circle</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">

                                                    <span class="text-black-70">Your profile information has not been synced correctly.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 hours ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-primary">group_add</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Adrian. D</strong>
                                                    <span class="text-black-70">Wants to join your private group.</span>
                                                </span>
                                            </span>
                                        </a>

                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">1 day ago</small>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-warning">storage</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">

                                                    <span class="text-black-70">Your deploy was successful.</span>
                                                </span>
                                            </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // END Notifications dropdown -->

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
                                        <li class="breadcrumb-item"><a href="./../index.php">Home Page</a></li>

                                        <li class="breadcrumb-item active">

                                            Dashboard

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
                                <div class="page-separator__text">Overview</div>
                            </div>
                            <div class="row mb-lg-8pt">
                                <div class="col-lg-12">
                                    <div id="carouselExampleFade" class="carousel carousel-card slide mb-24pt">
                                        <div class="carousel-inner">
                                            <?php foreach ($achievements as $achievement) : ?>
                                                <div class="carousel-item active">
                                                    <div class="d-flex gap-4 flex-wrap">
                                                        <a class="card border-0 mb-0 m-3" href="#">
                                                            <img src="./../Public/images/achievements/angular.png" alt="Angular fundamentals" class="card-img" style="max-height: 100%; width: initial;">
                                                            <div class="fullbleed bg-primary" style="opacity: .5;"></div>
                                                            <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                                                                <span class="row flex-nowrap">
                                                                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                                        <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                                                                        <span class="text-white-60 d-block mb-24pt"><?php
                                                                                                                    $date_time = strtotime($achievement['date']);
                                                                                                                    $formatted_date_time = date('d F Y. g:iA', $date_time);
                                                                                                                    echo $formatted_date_time;
                                                                                                                    ?>
                                                                        </span>
                                                                    </span>
                                                                    <span class="col d-flex flex-column">
                                                                        <span class="text-right flex mb-16pt">
                                                                            <img src="./../Public/images/paths/angular_64x64.png" width="64" alt="Angular fundamentals" class="rounded">
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                                <span class="row flex-nowrap">
                                                                    <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                                        <img src="./../Public/images/illustration/achievement/128/white.png" width="64" alt="achievement">
                                                                    </span>
                                                                    <span class="col d-flex flex-column">
                                                                        <span>
                                                                            <?php
                                                                            $course_id = $achievement['course_id'];
                                                                            $sql = mysqli_query($conn, "SELECT * FROM course WHERE course_id = '$course_id'");
                                                                            $get_course = mysqli_fetch_assoc($sql);
                                                                            ?>
                                                                            <span class="card-title text-white mb-4pt d-block"><?php echo $get_course['course_title']; ?></span>
                                                                            <span class="text-white-60"><?php echo substr($get_course['course_description'], 0, 100); ?>...</span>
                                                                        </span>
                                                                        <span class="text-white-60"><?php echo $achievement['number'] . " Acheivements." ?></span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            <?php if (empty($achievements)) : ?>
                                                <div class="col-md-12">
                                                    <p>You do not have any achievements.</p>
                                                </div>
                                            <?php endif; ?>

                                            <div class="carousel-item">
                                            </div>

                                        </div>
                                        <!-- <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_left</span>
    <span class="sr-only">Previous</span>
  </a> -->
                                        <!-- <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                                            <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                            <span class="sr-only">Next</span>
                                        </a> -->
                                    </div>

                                </div>
                            </div>

                            <div class="row mb-lg-16pt">
                                <div class="col-lg-6 mb-8pt mb-sm-0">
                                    <div class="page-separator">
                                        <div class="page-separator__text">Track Progress</div>
                                    </div>

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
                                            <p>You have not stared any course.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6">

                                    <div class="page-separator">
                                        <div class="page-separator__text">Courses</div>
                                    </div>

                                    <div class="position-relative carousel-card">
                                        <div class="js-mdk-carousel row d-block" id="carousel-courses1">

                                            <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-courses1" role="button" data-slide="next">
                                                <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                                <span class="sr-only">Next</span>
                                            </a>

                                            <div class="mdk-carousel__content">
                                                <?php
                                                foreach ($courses as $course) :
                                                    // fetch the instructor details for the current course
                                                    $instructor_id = $course['instructor_id'];
                                                    $course_id = $course['course_id'];
                                                    $get_instructor_name = mysqli_query($conn, "SELECT first_name, last_name FROM instructor WHERE id = $instructor_id");
                                                    $instructor = mysqli_fetch_assoc($get_instructor_name);
                                                    $get_course_details = mysqli_query($conn, "SELECT * FROM course WHERE course_id = $course_id");
                                                    $course_details = mysqli_fetch_assoc($get_course_details);
                                                ?>
                                                    <div class="col-12 col-sm-6">

                                                        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal " data-partial-height="44" data-toggle="popover" data-trigger="click">

                                                            <a href="student-take-course.php?course_id=<?php echo $course['course_id']; ?>" class="js-image" data-position="">
                                                                <img src="<?php echo $course_details['image_path']; ?>" alt="course" height="70px">
                                                            </a>

                                                            <span class="corner-ribbon corner-ribbon--default-right-top corner-ribbon--shadow bg-accent text-white">NEW</span>

                                                            <div class="mdk-reveal__content">
                                                                <div class="card-body">
                                                                    <div class="d-flex">
                                                                        <div class="flex">
                                                                            <a class="card-title" href="student-take-course.php"><?php echo $course_details['course_title']; ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php
                                                endforeach;
                                                ?>
                                                <?php if (empty($courses)) : ?>
                                                    <div class="col-md-12">
                                                        <p>You have nit started any course.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="page-separator">
                                <div class="page-separator__text">Quizzes</div>
                            </div>

                            <div class="row card-group-row">

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
                                                                echo '<p>Completed!</p><a href="student-take-quiz.php?id=' . $my_quizz['quiz_id'] . '" class="btn btn-light btn-sm">

                                                                    <i class="material-icons icon--left">refresh</i> Retake
    
                                                                </a>';
                                                            } else {
                                                                echo '<a href="student-take-quiz.php?id=' . $my_quizz['quiz_id'] . '" class="btn btn-light btn-sm">

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
                                            <p>You do not have any qizzes.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mb-32pt">

                                <!-- <ul class="pagination justify-content-center pagination-sm">
  <li class="page-item disabled">
    <a class="page-link" href="#" aria-label="Previous">
      <span aria-hidden="true" class="material-icons">chevron_left</span>
      <span>Prev</span>
    </a>
  </li>
  <li class="page-item active">
    <a class="page-link" href="#" aria-label="1">
      <span>1</span>
    </a>
  </li>
  <li class="page-item">
    <a class="page-link" href="#" aria-label="1">
      <span>2</span>
    </a>
  </li>
  <li class="page-item">
    <a class="page-link" href="#" aria-label="Next">
      <span>Next</span>
      <span aria-hidden="true" class="material-icons">chevron_right</span>
    </a>
  </li>
</ul> -->
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

                                <li class="sidebar-menu-item active">
                                    <a class="sidebar-menu-button" href="#">
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
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="dashboard-track-progress.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">timeline</span>
                                        <span class="sidebar-menu-text">Track Progress</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item active">
                                    <a class="sidebar-menu-button" href="./../help-center.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">help</span>
                                        <span class="sidebar-menu-text">Help Center</span>
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
    <script src="./../Public/Js/settings.js"></script>

    <!-- Flatpickr -->
    <script src="./../Public/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="./../Public/Js/flatpickr.js"></script>

    <!-- Moment.js -->
    <script src="./../Public/vendor/moment.min.js"></script>
    <script src="./../Public/vendor/moment-range.js"></script>

    <!-- Chart.js -->
    <script src="./../Public/vendor/Chart.min.js"></script>
    <script src="./../Public/Js/chartjs.js"></script>

    <!-- Chart.js Samples -->
    <script src="./../Public/Js/page.student-dashboard.js"></script>

    <!-- List.js -->
    <script src="./../Public/vendor/list.min.js"></script>
    <script src="./../Public/Js/list.js"></script>

    <!-- Tables -->
    <script src="./../Public/Js/toggle-check-all.js"></script>
    <script src="./../Public/Js/check-selected-row.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/Js/app-settings.js"></script> -->
</body>

</html>