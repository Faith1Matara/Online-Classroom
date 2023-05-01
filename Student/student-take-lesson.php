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


// Define variables and initialize with empty values
$student_id = $_SESSION["student_id"];
$course_id = $_GET['id']; // Get the course ID from the URL parameter
$course = get_course($course_id);

// fetch the instructor details for the current course
$instructor_id = $course['instructor_id'];
$get_instructor = mysqli_query($conn, "SELECT * FROM instructor WHERE id = '$instructor_id'");
$instructor = mysqli_fetch_assoc($get_instructor);

if (isset($_POST["enroll"])) {
    // echo "<script>alert('submitted!')</script>";
    $student_id = $_POST["student_id"];
    $course_name = $_POST["course_name"];
    $course_id = $_POST['course_id'];
    $instructor_name = $_POST['instructor_name'];

    $sql = "SELECT * FROM enroll_students WHERE student_id = '$student_id' AND course_id = '$course_id'";

    if ($stmt = $conn->prepare($sql)) {
        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                echo "<script>alert('You are already enrolled. Continue Learning!')</script>";
            } else {
                $sql = "INSERT INTO enroll_students (student_id, course_name, course_id, instructor_name, instructor_id) VALUES ('$student_id', '$course_name', '$course_id', '$instructor_name', '$instructor_id')";
                $execute = mysqli_query($conn, $sql);
                if ($execute) {
                    echo "<script>alert('Enrolled Successfully')</script>";
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        $stmt->close();
    }
}

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
                            <a href="./student-my-courses.php" class="nav-link">My Courses</a>
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
                                            <a href="student-take-lesson.php?id=<?php echo $course_id ?>"><img src="./../Public/images/paths/angular_64x64.png" width="40" alt="Angular" class="rounded"></a>
                                        </div>
                                        <div class="media-body d-flex flex-column">
                                            <a href="student-take-lesson.php?id=<?php echo $course_id ?>" class="card-title"><?php echo $course['course_title']; ?></a>
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
                                    <a href="#lesson-video" class="nav-link">Video</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#lesson-content" class="nav-link">Notes</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bg-primary pb-lg-64pt py-32pt">
                        <div class="container page__container">
                            <nav class="course-nav">
                                <a data-toggle="tooltip" data-placement="bottom" data-title="Getting Started with Angular: Introduction" href="#"><span class="material-icons">check_circle</span></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-title="Getting Started with Angular: Introduction to TypeScript" href="#"><span class="material-icons text-primary">account_circle</span></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-title="Getting Started with Angular: Comparing Angular to AngularJS" href="#"><span class="material-icons">play_circle_outline</span></a>
                                <a data-toggle="tooltip" data-placement="bottom" data-title="Quiz: Getting Started with Angular" href="student-take-quiz.php"><span class="material-icons">hourglass_empty</span></a>
                            </nav>
                            <div class="js-player bg-primary embed-responsive embed-responsive-16by9 mb-32pt" id="lesson-video">
                                <div class="player embed-responsive-item">
                                    <div class="player__content">
                                        <div class="player__image" style="--player-image: url(public/images/illustration/player.svg)"></div>
                                        <a href="#" class="player__play bg-primary">
                                            <span class="material-icons">play_arrow</span>
                                        </a>
                                    </div>
                                    <div class="player__embed d-none">
                                        <video src="<?php echo $video_link;?>" controls></video>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-end mb-16pt">
                                <h1 class="text-white flex m-0">Introduction to <?php echo $course["course_title"]; ?></h1>
                                <p class="h1 text-white-50 font-weight-light m-0">50:13</p>
                            </div>

                            <p class="hero__lead measure-hero-lead text-white-50 mb-24pt"><?php echo substr($course["course_introduction"], 0, 100); ?></p>
                        </div>
                    </div>
                    <div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
                        <div class="container page__container">
                            <ul class="nav navbar-nav flex align-items-sm-center">
                                <li class="nav-item navbar-list__item">
                                    <div class="media align-items-center">
                                        <span class="media-left mr-16pt">
                                            <img src="./../Public/images/people/50/guy-6.jpg" width="40" alt="avatar" class="rounded-circle">
                                        </span>
                                        <div class="media-body">
                                            <div class="card-title m-0" href="teacher-profile.php"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></div>
                                            <p class="text-50 lh-1 mb-0">Instructor</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item navbar-list__item">
                                    <i class="material-icons text-muted icon--left">schedule</i>
                                    2h 46m
                                </li>
                                <li class="nav-item navbar-list__item">
                                    <i class="material-icons text-muted icon--left">assessment</i>
                                    Beginner
                                </li>
                                <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                                    <div class="rating rating-24">
                                        <div class="rating__item"><i class="material-icons">star</i></div>
                                        <div class="rating__item"><i class="material-icons">star</i></div>
                                        <div class="rating__item"><i class="material-icons">star</i></div>
                                        <div class="rating__item"><i class="material-icons">star</i></div>
                                        <div class="rating__item"><i class="material-icons">star_border</i></div>
                                    </div>
                                    <p class="lh-1 mb-0"><small class="text-muted">20 ratings</small></p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="page-section" id="lesson-content">
                        <div class="container page__container">

                            <div class="d-flex align-items-center mb-heading">
                                <h4 class="m-0">Course Content</h4>
                            </div>

                            <div class="border-top">

                                <div class="list-group list-group-flush">

                                    <div class="list-group-item p-3">
                                        <h5 class="m-1">Introduction</h5>
                                        <div class="row align-items-start">
                                            <?php echo $course["course_introduction"]; ?> <br>
                                        </div>
                                    </div>

                                    <div class="list-group-item p-3">
                                        <h5 class="m-1">Content</h5>
                                        <div class="row align-items-start">
                                            <?php echo $course["course_content"]; ?> <br>
                                        </div>
                                    </div>
                                    <div class="list-group-item p-3">
                                        <h5 class="m-1">Course PDF</h5>
                                        <div class="row align-items-start">
                                            <a href="./student-read-book.php?course_id=<?= $course['course_id'] ?>" class="btn btn-primary">Read Book</a> <br>
                                        </div>
                                    </div>
                                    <div class="list-group-item p-3">
                                        <h5 class="m-1">Take Quiz</h5>
                                        <div class="row align-items-start">
                                            <a href="./student-take-quiz.php?id=<?= $course['course_id'] ?>" class="btn btn-primary">Take Quiz</a> <br>
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