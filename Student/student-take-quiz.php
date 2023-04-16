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

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz</title>

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

                    <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm" style="white-space: nowrap;">
                        <div class="container page__container">
                            <nav class="nav navbar-nav">
                                <div class="nav-item navbar-list__item">
                                    <a href="student-take-lesson.php?id=<?php echo $course_id; ?>" class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> Back to Course</a>
                                </div>
                                <div class="nav-item navbar-list__item">
                                    <div class="d-flex align-items-center flex-nowrap">
                                        <div class="mr-16pt">
                                            <a href="student-take-course.php"><img src="<?php echo $course['image_path'] ?>" width="40" alt="Angular" class="rounded"></a>
                                        </div>
                                        <div class="flex">
                                            <a href="student-take-course.php" class="card-title text-body mb-0"><?php echo $course['course_title'] ?></a>
                                            <p class="lh-1 d-flex align-items-center mb-0">
                                                <span class="text-50 small font-weight-bold mr-8pt"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></span>
                                                <span class="text-50 small"><?php echo $instructor['speciality']; ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>


                    <?php
                    // Retrieve the questions for the specified course
                    $sql = "SELECT * FROM quizzes WHERE course_id = '$course_id'";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        die('Error retrieving quiz questions: ' . mysqli_error($conn));
                    }

                    // Display the quiz questions as a form
                    echo '<form method="post" action="student-quiz-result-details.php">';
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="bg-primary pb-lg-64pt py-32pt text-center p-3"><h3>'  . $counter . " " . $row['question'] . '</h3></div>    
                        <div class="container page__container">
                            <div class="page-section p-3">
                                <div class="form-group">
                                    <div class="custom-control">';
                        echo '<input type="radio" name="answer[' . $row['id'] . ']" value="1" class="p-2" required><label for="customCheck01" class="p-2">' . $row['option1'] . '</label><br>';
                        echo '<input type="radio" name="answer[' . $row['id'] . ']" value="2" class="p-2" required><label for="customCheck01" class="p-2">' . $row['option2'] . '</label><br>';
                        echo '<input type="radio" name="answer[' . $row['id'] . ']" value="3" class="p-2" required><label for="customCheck01" class="p-2">' . $row['option3'] . '</label><br>';
                        echo '<input type="radio" name="answer[' . $row['id'] . ']" value="4" class="p-2" required><label for="customCheck01" class="p-2">' . $row['option4'] . '</label><br></div></div></div></div>';
                        $counter++;
                    }
                    
                    // Close the form and display the submit button
                    echo '<input name="course_id" hidden value="' . $course_id . '">';
                    echo '<input type="submit" name="submit_answers" value="Submit Answers">';
                    echo '</form>';

                    // Store the course ID in the session for later use
                    $_SESSION['course_id'] = $course_id;

                    // Close the database connection
                    mysqli_close($conn);

                    ?>

                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./../Public/images/logo/black-70%402x.png" width="30" alt="Luma">Online Classroom
                            </p>
                            <p class="measure-lead-max text-50 small mr-8pt">Online Classroom is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard and more.</p>
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