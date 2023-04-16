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

// Processing form data when form is submitted
if (isset($_POST["save-course"])) {
    // Validate course_title
    if (empty(trim($_POST["course_title"]))) {
        $course_title_err = "Please enter course title.";
    } else {
        // Prepare a select statement
        $sql = "SELECT course_id FROM course WHERE course_title = ?";
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_course_title);

            // Set parameters
            $param_course_title = htmlspecialchars(trim($_POST["course_title"]));

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    $course_title = htmlspecialchars(trim($_POST["course_title"]));
                } else {
                    $course_title_err = "Course title already exists.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate course_description
    if (empty(trim($_POST["course_description"]))) {
        $course_description_err = "Please enter course description.";
    } else {
        $course_description = htmlspecialchars(trim($_POST["course_description"]));
    }

    // Validate course_introduction
    if (empty(trim($_POST["course_introduction"]))) {
        $course_introduction_err = "Please enter section title.";
    } else {
        $course_introduction = htmlspecialchars(trim($_POST["course_introduction"]));
    }

    // Validate course_content
    if (empty(trim($_POST["course_content"]))) {
        $course_content_err = "Please enter section description.";
    } else {
        $course_content = htmlspecialchars(trim($_POST["course_content"]));
    }
    // Validate course_image
    if ($_FILES["course_image"]["error"] == 0) {
        $file_size = $_FILES["course_image"]["size"];
        $file_type = $_FILES["course_image"]["type"];
        $file_name = $_FILES["course_image"]["name"];
        $file_tmp_name = $_FILES["course_image"]["tmp_name"];

        // Check file size
        if ($file_size > 30000000) {
            $file_err = "File size must be less than 30 MB.";
        }

        // Allow certain file formats
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if (!in_array($file_type, $allowed_types)) {
            $file_err = "Only JPG, PNG and GIF files are allowed.";
        }

        if (empty($file_err)) {
            // Define upload path
            $upload_path = "../Course/uploads/images/" . basename($file_name);
            // Set the path for the image in the database
            $course_image = basename($file_name);

            // Move file from temporary location to destination directory
            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                // File uploaded successfully
            } else {
                $file_err = "There was an error uploading your file.";
            }
        }
    }

    if (!empty($course_image)) {
        $image_path = "./../Course/uploads/images/" . $course_image;
    }

    if (!empty($_FILES["file"]["name"])) {
        $file_name = $_FILES["file"]["name"];
        $file_size = $_FILES["file"]["size"];
        $file_type = $_FILES["file"]["type"];
        $file_tmp_name = $_FILES["file"]["tmp_name"];

        // Check file size
        if ($file_size > 100000000) {
            $file_err = "File size must be less than 100 MB.";
        }

        // Allow certain file formats
        $allowed_types = array("application/pdf");
        if (!in_array($file_type, $allowed_types)) {
            $file_err = "Only PDF files are allowed.";
        }

        if (empty($file_err)) {
            // Define upload path
            $upload_path = "../Course/uploads/pdfs/" . basename($file_name);
            // Set the path for the file in the database
            $file_path = basename($file_name);

            // Move file from temporary location to destination directory
            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                // File uploaded successfully
            } else {
                $file_err = "There was an error uploading your file.";
            }
        }
    }

    if (!empty($file_path)) {
        $file_path = "./../Course/uploads/pdfs/" . $file_path;
    }
    // Validate video_link
    if (!empty(trim($_POST["video_link"]))) {
        $video_link = trim($_POST["video_link"]);
        if (!filter_var($video_link, FILTER_VALIDATE_URL)) {
            $video_link_err = "Please enter a valid video link.";
        }
    }

    // Update course data in the database
    if (empty($course_title_err) && empty($course_description_err) && empty($course_introduction_err) && empty($course_content_err) && empty($file_err) && empty($video_link_err) && empty($image_err)) {
        $sql = "UPDATE course SET course_title = ?, course_description = ?, course_introduction = ?, course_content = ?, image_path = ?, file_path = ?, video_link = ? WHERE course_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_course_title, $param_course_description, $param_course_introduction, $param_course_content, $param_image_path, $param_file_path, $param_video_link, $course_id);
            $param_course_title = $course_title;
            $param_course_description = $course_description;
            $param_course_introduction = $course_introduction;
            $param_course_content = $course_content;
            $param_image_path = $image_path;
            $param_file_path = $file_path;
            $param_video_link = $video_link;
            if (mysqli_stmt_execute($stmt)) {
                // Course data updated successfully
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }


    // Close connection
    $conn->close();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Course</title>

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

                    <!-- <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0"
                                type="button"
                                data-toggle="sidebar">
                            <span class="material-icons">short_text</span>
                        </button> -->


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

                    <form class="search-form navbar-search d-none d-md-flex mr-16pt" action="./../index.php">
                        <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        <input type="text" class="form-control" placeholder="Search ...">
                    </form>

                    <!-- // END Navbar Search -->

                    <div class="flex"></div>

                    <!-- Navbar Menu -->

                    <div class="navbar-nav d-flex flex-nowrap ml-auto justify-content-end">

                        
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
                <div class="mdk-drawer-layout__content page-content ">

                    <div class="navbar navbar-light border-0 navbar-expand-sm" style="white-space: nowrap;">
                        <div class="container page__container flex-column flex-sm-row font-weight-bold">
                            <nav class="nav navbar-nav font-weight-bold">
                                <div class="nav-item py-32pt py-sm-0">
                                    <div class="media flex-nowrap">

                                        <div class="media-body d-flex flex-column font-weight-bold">
                                            <a href="student-dashboard.php" class="card-title ">
                                                <h5>View Dashboard</h5>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </nav>

                        </div>
                    </div>

                    <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0" data-effects="blend-background">
                        <div class="mdk-box__content">
                            <div class="hero py-64pt text-center text-sm-left">
                                <div class="container page__container">
                                    <h1 class="text-white"><?php echo $course["course_title"] ?></h1>
                                    <p class="lead text-white-50 measure-hero-lead mb-24pt"><?php echo $course["course_description"] ?></p>
                                    <a href="./student-take-lesson.php?course_id=<?php echo $course['course_id'] ?>" class="btn btn-white">Take course</a>
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
                                                    <div class="card-title m-0" href="instructor-profile.php"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></div>
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
                        </div>
                    </div>

                    <div class="container page__container">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="border-left-2 page-section pl-32pt">

                                    <div class="d-flex align-items-center page-num-container">
                                        <div class="page-num">1</div>
                                        <h4>Getting Started With Angular</h4>
                                    </div>

                                    <p class="text-70 mb-24pt">Good tools make application development quick*er and easier to maintain than* if you did everything by hand. The goal in this guide is to build and run a simple Angular application in TypeScript, using the Angular CLI while adhering to the Style Guide recommendations that benefit every Angular project.</p>

                                    <div class="card mb-32pt mb-lg-64pt">
                                        <ul class="accordion accordion--boxed js-accordion mb-0" id="toc-1">
                                            <li class="accordion__item open">
                                                <a class="accordion__toggle" data-toggle="collapse" data-parent="#toc-1" href="#toc-content-1">
                                                    <span class="flex">1 of 4 Steps</span>
                                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                                </a>
                                                <div class="accordion__menu">
                                                    <ul class="list-unstyled collapse show" id="toc-content-1">
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">check_circle</span>
                                                            <a class="flex" href="student-take-lesson.php">Introduction</a>
                                                            <span class="text-muted">8m 42s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                                                            <a class="flex" href="student-take-lesson.php">Introduction to TypeScript</a>
                                                            <span class="text-muted">50m 13s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                                                            <a class="flex" href="student-take-lesson.php">Comparing Angular to AngularJS</a>
                                                            <span class="text-muted">12m 10s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-50">hourglass_empty</span>
                                                            <a class="flex" href="student-take-quiz.php">Quiz: Getting Started With Angular</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="d-flex align-items-center page-num-container">
                                        <div class="page-num">2</div>
                                        <h4>Creating and Communicating Between Angular Components</h4>
                                    </div>
                                    <p class="text-70 mb-24pt">Data sharing is an essential concept to understand before diving into your first Angular project. In this section, you will learn four different methods for sharing data between Angular components.</p>

                                    <div class="card mb-0">
                                        <ul class="accordion accordion--boxed js-accordion mb-0" id="toc-2">
                                            <li class="accordion__item">
                                                <a class="accordion__toggle" data-toggle="collapse" data-parent="#toc-2" href="#toc-content-2">
                                                    <span class="flex">6 Steps</span>
                                                    <span class="accordion__toggle-icon material-icons">keyboard_arrow_down</span>
                                                </a>
                                                <div class="accordion__menu">
                                                    <ul class="list-unstyled collapse" id="toc-content-2">
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">check_circle</span>
                                                            <a class="flex" href="student-take-lesson.php">Introduction</a>
                                                            <span class="text-muted">8m 42s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                                                            <a class="flex" href="student-take-lesson.php">Introduction to TypeScript</a>
                                                            <span class="text-muted">50m 13s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-body">play_circle_outline</span>
                                                            <a class="flex" href="student-take-lesson.php">Comparing Angular to AngularJS</a>
                                                            <span class="text-muted">12m 10s</span>
                                                        </li>
                                                        <li class="accordion__menu-link">
                                                            <span class="material-icons icon-16pt icon--left text-50">hourglass_empty</span>
                                                            <a class="flex" href="student-take-quiz.php">Quiz: Getting Started With Angular</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-5 page-nav">
                                <div class="page-section">
                                    <div class="page-nav__content">
                                        <div class="page-separator">
                                            <div class="page-separator__text">Table of contents</div>
                                        </div>
                                        <!-- <h4 class="mb-16pt">Table of contents</h4> -->
                                    </div>
                                    <nav class="nav page-nav__menu">
                                        <a class="nav-link active" href="#">Getting Started With Angular</a>
                                        <a class="nav-link" href="#">Creating and Communicating Between Angular Components</a>
                                        <a class="nav-link" href="#">Exploring the Angular Template Syntax</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-section bg-white border-top-2 border-bottom-2">

                        <div class="container page__container">
                            <div class="row ">
                                <div class="col-md-7">
                                    <div class="page-separator">
                                        <div class="page-separator__text">About this course</div>
                                    </div>
                                    <p class="text-70">This course will teach you the fundamentals o*f working with Angular 2. You *will learn everything you need to know to create complete applications including: components, services, directives, pipes, routing, HTTP, and even testing.</p>
                                    <p class="text-70 mb-0">This course will teach you the fundamentals o*f working with Angular 2. You *will learn everything you need to know to create complete applications including: components, services, directives, pipes, routing, HTTP, and even testing.</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="page-separator">
                                        <div class="page-separator__text bg-white">What you’ll learn</div>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">Fundamentals of working with Angular</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">Create complete Angular applications</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">Working with the Angular CLI</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">Understanding Dependency Injection</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">Testing with Angular</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="page-section bg-white border-bottom-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7 mb-24pt mb-md-0">
                                    <h4>About the author</h4>
                                    <p class="text-70 mb-24pt"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?> is a software developer at LearnD*ash. With more than 20 years o*f software development experience, he has gained a passion for Agile software development -- especially Lean.</p>

                                    <div class="page-separator">
                                        <div class="page-separator__text bg-white">More from the author</div>
                                    </div>

                                    <div class="card card-sm mb-8pt">
                                        <div class="card-body d-flex align-items-center">
                                            <a href="./courses.php" class="avatar avatar-4by3 mr-12pt">
                                                <img src="public/images/paths/angular_routing_200x168.png" alt="Angular Routing In-Depth" class="avatar-img rounded">
                                            </a>
                                            <div class="flex">
                                                <a class="card-title mb-4pt" href="./courses.php">Angular Routing In-Depth</a>
                                                <div class="d-flex align-items-center">
                                                    <div class="rating mr-8pt">

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>

                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>

                                                    </div>
                                                    <small class="text-muted">3/5</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-sm mb-16pt">
                                        <div class="card-body d-flex align-items-center">
                                            <a href="course.php" class="avatar avatar-4by3 mr-12pt">
                                                <img src="public/images/paths/angular_testing_200x168.png" alt="Angular Unit Testing" class="avatar-img rounded">
                                            </a>
                                            <div class="flex">
                                                <a class="card-title mb-4pt" href="./courses.php">Angular Unit Testing</a>
                                                <div class="d-flex align-items-center">
                                                    <div class="rating mr-8pt">

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star</span></span>

                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>

                                                    </div>
                                                    <small class="text-muted">4/5</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item px-0">
                                            <a href="#" class="card-title mb-4pt">Angular Best Practices</a>
                                            <p class="lh-1 mb-0">
                                                <small class="text-muted mr-8pt">6h 40m</small>
                                                <small class="text-muted mr-8pt">13,876 Views</small>
                                                <small class="text-muted">13 May 2018</small>
                                            </p>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <a href="#" class="card-title mb-4pt">Unit Testing in Angular</a>
                                            <p class="lh-1 mb-0">
                                                <small class="text-muted mr-8pt">6h 40m</small>
                                                <small class="text-muted mr-8pt">13,876 Views</small>
                                                <small class="text-muted">13 May 2018</small>
                                            </p>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <a href="#" class="card-title mb-4pt">Migrating Applications from AngularJS to Angular</a>
                                            <p class="lh-1 mb-0">
                                                <small class="text-muted mr-8pt">6h 40m</small>
                                                <small class="text-muted mr-8pt">13,876 Views</small>
                                                <small class="text-muted">13 May 2018</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 pt-sm-32pt pt-md-0 d-flex flex-column align-items-center justify-content-start">
                                    <div class="text-center">
                                        <p class="mb-16pt">
                                            <img src="./../Public/images/people/110/guy-6.jpg" alt="guy-6" class="rounded-circle" width="64">
                                        </p>
                                        <h4 class="m-0"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></h4>
                                        <p class="lh-1">
                                            <small class="text-muted">Angular, Web Development</small>
                                        </p>
                                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-start">

                                            <a href="#" class="btn btn-outline-secondary">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-section border-bottom-2">
                        <div class="container">
                            <div class="page-headline text-center">
                                <h2>Feedback</h2>
                                <p class="lead text-70 measure-lead mx-auto">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
                            </div>

                            <div class="position-relative carousel-card p-0 mx-auto">
                                <div class="row d-block js-mdk-carousel" id="carousel-feedback">
                                    <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-feedback" role="button" data-slide="next">
                                        <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                    <div class="mdk-carousel__content">

                                        <div class="col-12 col-md-6">

                                            <div class="card card-feedback card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p class="text-70 small mb-0">A wonderful course on how to start. <?php echo $instructor['first_name']?> beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you <?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?>.</p>
                                                </blockquote>
                                            </div>
                                            <div class="media ml-12pt">
                                                <div class="media-left mr-12pt">
                                                    <div href="student-profile.php" class="avatar avatar-sm">
                                                        <!-- <img src="./../Public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                                        <span class="avatar-title rounded-circle">UK</span>
                                                    </div>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <a href="student-profile.php" class="card-title">Umberto Kass</a>
                                                    <div class="rating mt-4pt">
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12 col-md-6">

                                            <div class="card card-feedback card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p class="text-70 small mb-0">A wonderful course on how to start. <?php echo $instructor['first_name']; ?> beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you <?php echo $instructor['first_name']  . ' ' . $instructor['last_name']; ?>.</p>
                                                </blockquote>
                                            </div>
                                            <div class="media ml-12pt">
                                                <div class="media-left mr-12pt">
                                                    <div href="student-profile.php" class="avatar avatar-sm">
                                                        <!-- <img src="./../Public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                                        <span class="avatar-title rounded-circle">UK</span>
                                                    </div>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <div href="student-profile.php" class="card-title">Umberto Kass</div>
                                                    <div class="rating mt-4pt">
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12 col-md-6">

                                            <div class="card card-feedback card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p class="text-70 small mb-0">A wonderful course on how to start. <?php echo $instructor['first_name']; ?> beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you <?php echo $instructor['first_name']  . ' ' . $instructor['last_name']; ?>.</p>
                                                </blockquote>
                                            </div>
                                            <div class="media ml-12pt">
                                                <div class="media-left mr-12pt">
                                                    <div href="student-profile.php" class="avatar avatar-sm">
                                                        <!-- <img src="./../Public/images/people/110/guy-.jpg" width="40" alt="avatar" class="rounded-circle"> -->
                                                        <span class="avatar-title rounded-circle">UK</span>
                                                    </div>
                                                </div>
                                                <div class="media-body media-middle">
                                                    <div href="student-profile.php" class="card-title">Umberto Kass</div>
                                                    <div class="rating mt-4pt">
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-section bg-white border-bottom-2">

                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Student Feedback</div>
                            </div>
                            <div class="row mb-32pt">
                                <div class="col-md-3 mb-32pt mb-md-0">
                                    <div class="display-1">4.7</div>
                                    <div class="rating rating-24">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <p class="text-muted mb-0">20 ratings</p>
                                </div>
                                <div class="col-md-9">

                                    <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="75% rated 5/5" data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="75" style="width: 75%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="16% rated 4/5" data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="16" style="width: 16%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="12% rated 3/5" data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="12" style="width: 12%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="9% rated 2/5" data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="9" style="width: 9%" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt" data-toggle="tooltip" data-title="0% rated 0/5" data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="pb-16pt mb-16pt border-bottom row">
                                <div class="col-md-3 mb-16pt mb-md-0">
                                    <div class="d-flex">
                                        <div href="student-profile.php" class="avatar avatar-sm mr-12pt">
                                            <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">LB</span>
                                        </div>
                                        <div class="flex">
                                            <p class="small text-muted m-0">2 days ago</p>
                                            <div href="student-profile.php" class="card-title">Laza Bogdan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="rating mb-8pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <p class="text-70 mb-0">A wonderful course on how to start. <?php echo $instructor['first_name']; ?> beautifully conveys all essentials of a becoming a good Angular developer. Very glad to have taken this course. Thank you <?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?>.</p>
                                </div>
                            </div>

                            <div class="pb-16pt mb-16pt border-bottom row">
                                <div class="col-md-3 mb-16pt mb-md-0">
                                    <div class="d-flex">
                                        <div href="student-profile.php" class="avatar avatar-sm mr-12pt">
                                            <!-- <img src="UK" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">UK</span>
                                        </div>
                                        <div class="flex">
                                            <p class="small text-muted m-0">2 days ago</p>
                                            <div href="student-profile.php" class="card-title">Umberto Klass</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="rating mb-8pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <p class="text-70 mb-0">This course is absolutely amazing, <?php echo $instructor['last_name']; ?> goes* out of his way to really expl*ain things clearly I couldn&#39;t be happier, so glad I made this purchase!</p>
                                </div>
                            </div>

                            <div class="pb-16pt mb-24pt row">
                                <div class="col-md-3 mb-16pt mb-md-0">
                                    <div class="d-flex">
                                        <div href="student-profile.php" class="avatar avatar-sm mr-12pt">
                                            <!-- <img src="AD" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">AD</span>
                                        </div>
                                        <div class="flex">
                                            <p class="small text-muted m-0">2 days ago</p>
                                            <a href="student-profile.php" class="card-title">Adrian Demian</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="rating mb-8pt">
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star</span></span>
                                        <span class="rating__item"><span class="material-icons">star_border</span></span>
                                    </div>
                                    <p class="text-70 mb-0">This course is absolutely amazing, <?php echo $instructor['last_name']; ?> goes* out of his way to really expl*ain things clearly I couldn&#39;t be happier, so glad I made this purchase!</p>
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

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>


</html>