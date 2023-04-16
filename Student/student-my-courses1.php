<?php
include "./../Include/config.php";
include "./../Include/functions.php";
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["student_id"])) {
    header("location: ./../login.php");
    exit;
}
$student_id = $_SESSION["student_id"];
$courses = get_student_courses($student_id);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Courses</title>

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

    <div class="preloader d-none">
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
                                    <h2 class="mb-0">Courses</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./../index.php">Home</a></li>

                                        <li class="breadcrumb-item active">

                                            Courses

                                        </li>

                                    </ol>

                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="container page__container">
                        <div class="page-section">

                            <div class="page-separator">
                                <div class="page-separator__text">Track Progress</div>
                            </div>

                            <!-- <div class="page-heading">
      <h4>Learning Paths</h4>
      <a 
        href="" 
        class="text-underline ml-sm-auto">All my learning paths</a>
    </div> -->

                            <div class="row card-group-row mb-lg-8pt">

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/angular_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">Angular</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary border-1 border-secondary">Resume</a>

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

                                        <p class="mt-16pt text-70">Angular is a platform for building mobile and desktop web applications.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/swift_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">Swift</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="./../Public/images/paths/swift_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title">Swift</div>
                                                <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                            </div>
                                        </div>

                                        <p class="mt-16pt text-70">Swift is a powerful and intuitive programming language for macOS, iOS, watchOS, tvOS and beyond.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/react_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">React Native</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="./../Public/images/paths/react_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title">React Native</div>
                                                <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                            </div>
                                        </div>

                                        <p class="mt-16pt text-70">Learn the fundamentals of working with React Native and how to create basic applications.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/wordpress_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">WordPress</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="./../Public/images/paths/wordpress_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title">WordPress</div>
                                                <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                            </div>
                                        </div>

                                        <p class="mt-16pt text-70">WordPress is open source software you can use to create a beautiful website, blog, or app.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/devops_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">Dev Ops</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="./../Public/images/paths/devops_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title">Dev Ops</div>
                                                <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                            </div>
                                        </div>

                                        <p class="mt-16pt text-70">Learn the fundamentals of working with Dev Ops and how to create basic applications.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                                <div class="col-sm-4 card-group-row__col">

                                    <div class="card js-overlay card-sm overlay--primary-dodger-blue stack stack--1 card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center">
                                                <div class="flex">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded mr-12pt z-0 o-hidden">
                                                            <div class="overlay">
                                                                <img src="./../Public/images/paths/redis_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                                <span class="overlay__content overlay__content-transparent">
                                                                    <span class="overlay__action d-flex flex-column text-center lh-1">
                                                                        <small class="h6 small text-white mb-0" style="font-weight: 500;">80%</small>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex">
                                                            <div class="card-title">Redis</div>
                                                            <p class="flex text-50 lh-1 mb-0"><small>18 courses</small></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="student-path.php" class="ml-4pt btn btn-sm btn-link text-secondary">Resume</a>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="popoverContainer d-none">
                                        <div class="media">
                                            <div class="media-left mr-12pt">
                                                <img src="./../Public/images/paths/redis_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title">Redis</div>
                                                <p class="text-50 d-flex lh-1 mb-0 small">18 courses</p>
                                            </div>
                                        </div>

                                        <p class="mt-16pt text-70">Learn the fundamentals of working with Redis and how to create basic applications.</p>

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
                                                <a href="student-path.php" class="btn btn-primary mr-8pt">Resume</a>
                                                <a href="student-path.php" class="btn btn-outline-secondary ml-0">Start over</a>
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

                                </div>

                            </div>

                            <div class="mb-32pt">

                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                            <span>Prev</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Page 1">
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Page 2">
                                            <span>2</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span>Next</span>
                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <div class="page-separator">
                                <div class="page-separator__text">Enrolled Courses</div>
                            </div>

                            <div class="row card-group-row">
                                <?php
                                // loop through each course
                                foreach ($courses as $course) :
                                    $img_url = './uploads/images/' . $course['course_image'];

                                    // fetch the instructor details for the current course
                                    $instructor_id = $course['instructor_id'];
                                    $get_instructor_name = mysqli_query($conn, "SELECT first_name, last_name FROM instructor WHERE id = $instructor_id");
                                    $instructor = mysqli_fetch_assoc($get_instructor_name);
                                ?>

                                    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">
                                        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card" data-overlay-onload-show data-popover-onload-show data-force-reveal data-partial-height="44" data-toggle="popover" data-trigger="click">
                                            <img src="<?php echo $img_url ?>" alt="course" height="200" width="100%" onerror="this.onerror=null;this.src='./../Public/images/default_cover_image.png';">
                                            <span class="overlay__content align-items-start justify-content-start">
                                                <span class="overlay__action card-body d-flex align-items-center">
                                                    <i class="material-icons mr-4pt">play_circle_outline</i>
                                                    <span class="card-title text-white">Preview</span>
                                                </span>
                                            </span>
                                            <div class="mdk-reveal__content">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex">
                                                            <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>"><?php echo $course["course_title"]; ?></a>
                                                            <small class="text-50 font-weight-bold mb-4pt"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></small>
                                                        </div>
                                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-secondary h-50">CONTINUE</a>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="rating flex">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                        <small class="text-50">6 hours</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="popoverContainer d-none">
                                            <div class="media">
                                                <div class="media-left mr-12pt">
                                                    <img src="./../Public/images/paths/mailchimp_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                </div>
                                                <div class="media-body">
                                                    <div class="card-title mb-0">Newsletter Design</div>
                                                    <p class="lh-1 mb-0">
                                                        <span class="text-50 small">with</span>
                                                        <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

                                            <div class="mb-16pt">
                                                <div class="d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with Angular</small></p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular applications</small></p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular CLI</small></p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency Injection</small></p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                    <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="d-flex align-items-center mb-4pt">
                                                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                                        <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-4pt">
                                                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                                                        <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                                                    </div>
                                                </div>
                                                <div class="col text-right">
                                                    <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                <?php endforeach; ?>
                                <?php if (empty($course)) : ?>
                                    <div class="col-md-12">
                                        <p>No courses found.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-32pt">

                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                            <span>Prev</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Page 1">
                                            <span>1</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Page 2">
                                            <span>2</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span>Next</span>
                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>




                            <div class="page-separator">
                                <div class="page-separator__text">Achievements</div>
                            </div>

                            <!-- <div class="page-heading">
      <h4>Achievements</h4>
      <a 
        href="" 
        class="text-underline ml-sm-auto">My achievements</a>
    </div> -->

                            <div class="position-relative carousel-card">
                                <div class="js-mdk-carousel row d-block" id="carousel-achievements">

                                    <a class="carousel-control-next js-mdk-carousel-control" href="#carousel-achievements" role="button" data-slide="next">
                                        <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                        <span class="sr-only">Next</span>
                                    </a>

                                    <div class="mdk-carousel__content">

                                        <div class="col-12 col-sm-6">

                                            <a class="card border-0 mb-0" href="#">
                                                <img src="./../Public/images/achievements/flinto.png" alt="Flinto" class="card-img" style="max-height: 100%; width: initial;">
                                                <div class="fullbleed bg-primary" style="opacity: .5;"></div>
                                                <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                                                    <span class="row flex-nowrap">
                                                        <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                            <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                                                            <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
                                                        </span>
                                                        <span class="col d-flex flex-column">
                                                            <span class="text-right flex mb-16pt">
                                                                <img src="./../Public/images/paths/flinto_40x40%402x.png" width="64" alt="Flinto" class="rounded">
                                                            </span>
                                                        </span>
                                                    </span>
                                                    <span class="row flex-nowrap">
                                                        <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                            <img src="./../Public/images/illustration/achievement/128/white.png" width="64" alt="achievement">
                                                        </span>
                                                        <span class="col d-flex flex-column">
                                                            <span>
                                                                <span class="card-title text-white mb-4pt d-block">Flinto</span>
                                                                <span class="text-white-60">Introduction to The App Design Application</span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>

                                        </div>

                                        <div class="col-12 col-sm-6">

                                            <a class="card border-0 mb-0" href="#">
                                                <img src="./../Public/images/achievements/angular.png" alt="Angular fundamentals" class="card-img" style="max-height: 100%; width: initial;">
                                                <div class="fullbleed bg-primary" style="opacity: .5;"></div>
                                                <span class="card-body d-flex flex-column align-items-center justify-content-center fullbleed">
                                                    <span class="row flex-nowrap">
                                                        <span class="col-auto text-center d-flex flex-column justify-content-center align-items-center">
                                                            <span class="h5 text-white text-uppercase font-weight-normal m-0 d-block">Achievement</span>
                                                            <span class="text-white-60 d-block mb-24pt">Jun 5, 2018</span>
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
                                                                <span class="card-title text-white mb-4pt d-block">Angular fundamentals</span>
                                                                <span class="text-white-60">Creating and Communicating Between Angular Components</span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./../Public/images/logo/black-70%402x.png" width="30" alt="Online Classroom"> Online Classroom
                            </p>
                            <p class="measure-lead-max text-50 small mr-8pt">Online Classroom is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.</p>
                            <p class="mb-8pt d-flex">
                                <a href="#" class="text-70 text-underline mr-8pt small">Terms</a>
                                <a href="#" class="text-70 text-underline small">Privacy policy</a>
                            </p>
                            <p class="text-50 small mt-n1 mb-0">Copyright 2019 &copy; All rights reserved.</p>
                        </div>
                    </div>

                    <!-- // END Footer -->

                </div>
                <!-- // END drawer-layout__content -->

                <!-- Drawer -->


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

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>


</html>