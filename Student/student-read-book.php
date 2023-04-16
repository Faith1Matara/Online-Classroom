<?php
session_start();
include "./../Include/config.php";
include "./../Include/functions.php";
// Initialize the session

// Redirect to login page if user is not logged in
if (!isset($_SESSION["student_id"])) {
    header("location: ./../login.php");
    exit;
}



// Define variables and initialize with empty values
$student_id = $_SESSION["student_id"];
$course_id = $_GET['course_id']; // Get the course ID from the URL parameter
$course = get_course($course_id);

// fetch the instructor details for the current course
$instructor_id = $course['instructor_id'];
$get_instructor = mysqli_query($conn, "SELECT * FROM instructor WHERE id = $instructor_id");
$instructor = mysqli_fetch_assoc($get_instructor);


// Query the database to get the course data for the specified ID
$sql = "SELECT * FROM course WHERE course_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $course_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Store the retrieved course data in variables
$course_title = $row['course_title'];
$course_description = $row['course_description'];
$course_introduction = $row['course_introduction'];
$course_content = $row['course_content'];
$image_path = $row['image_path'];
$file_path = $row['file_path'];
$video_link = $row['video_link'];

// Close the database connection and statement
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lesson</title>

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


                    <!-- // END Navbar Toggler -->

                    <!-- Navbar Brand -->

                    <a href="./../index.php" class="navbar-brand mr-16pt">

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./../Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>
                    <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                        <li class="nav-item active">
                            <a href="student-take-course.php" class="nav-link">Course</a>
                        </li>


                    </ul>


                    <!-- // END Navbar Brand -->

                    <!-- Navbar Search -->

                    <form class="search-form navbar-search d-none d-md-flex mr-16pt" action="./../index.php">
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

                    <div class="navbar navbar-light border-0 navbar-expand-sm" style="white-space: nowrap;">
                        <div class="container page__container flex-column flex-sm-row">
                            <nav class="nav navbar-nav">
                                <div class="nav-item py-16pt py-sm-0">
                                    <div class="media flex-nowrap">
                                        <div class="media-left mr-16pt">
                                            <a href="student-take-course.php"><img src="./../Public/images/paths/angular_64x64.png" width="40" alt="Angular" class="rounded"></a>
                                        </div>
                                        <div class="media-body d-flex flex-column">
                                            <a href="student-take-course.php" class="card-title"><?php echo $course['course_title']; ?></a>
                                            <div class="d-flex">
                                                <span class="text-50 small font-weight-bold mr-8pt">By <?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></span>
                                                <span class="text-50 small"><?php echo $instructor['speciality']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                            <ul class="nav navbar-nav ml-sm-auto align-items-center align-items-sm-end d-none d-lg-flex">
                                <li class="nav-item active ml-sm-16pt">
                                    <a href="./student-take-lesson.php?course_id=<?= $course['course_id']?>#lesson-video" class="nav-link">Video</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#lesson-content" class="nav-link">Notes</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-primary pb-lg-64pt py-32pt">
                        <main class="container py-4" style="min-height: 58vh;">
                                <div class="embed-responsive embed-responsive-4by3 w-full" style="width: 100%; height:100vh;">
                                    <embed class="embed-responsive-item" style="width: 100%; height:100vh;" src="<?php echo $course['file_path'] ?>" type="application/pdf" />
                                </div>
                        </main>
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