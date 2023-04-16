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

// Retrieve the correct answers for the specified course
$course_id = $_SESSION['course_id'];
$sql = "SELECT * FROM quizzes WHERE course_id = '$course_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die('Error retrieving quiz questions: ' . mysqli_error($conn));
}

$course = get_course($course_id);
// fetch the instructor details for the current course
$instructor_id = $course['instructor_id'];
$get_instructor = mysqli_query($conn, "SELECT * FROM instructor WHERE id = $instructor_id");
$instructor = mysqli_fetch_assoc($get_instructor);

if (isset($_POST['submit_answers'])) {
    // Retrieve the course ID from the session
    $course_id = $_SESSION['course_id'];

    if (!$result) {
        die('Error retrieving quiz questions: ' . mysqli_error($conn));
    }

    $get_done_quiz = mysqli_query($conn, "SELECT quiz_id FROM quiz_results WHERE student_id = '$student_id' AND course_id = '$course_id' ");
    $done_quiz = mysqli_fetch_assoc($get_done_quiz);
    if ($done_quiz) {
        // Initialize variables for scoring the quiz
        $total_questions = mysqli_num_rows($result);
        $total_correct = 0; // Initialize total_correct to 0
        $done_quiz_id = $done_quiz['quiz_id'];

        // Retrieve the questions for the specified course
        $sql = "SELECT * FROM quizzes WHERE course_id = '$course_id'";
        $result = mysqli_query($conn, $sql);

        // Loop through each question and check the student's answer
        while ($row = mysqli_fetch_assoc($result)) {
            $answer_id = $row['id'];
            $student_answer = $_POST['answer'][$answer_id];
            $correct_answer = $row['answer'];
            if ($student_answer == $correct_answer) {
                $total_correct++;
            }
        }

        // Calculate the student's score as a percentage
        $score = number_format(($total_correct / $total_questions) * 100, 0);

        // Insert the quiz results into the quiz_results table
        $student_id = $_SESSION['student_id'];
        $submitted_at = date('Y-m-d H:i:s');
        $sql = "UPDATE quiz_results SET score = '$score', date = '$submitted_at' WHERE quiz_id = '$done_quiz_id'";
        $result = mysqli_query($conn, $sql);
        $get_prev_archeivement = mysqli_query($conn, "SELECT arch_id, number FROM achievements WHERE student_id = '$student_id' AND course_id = '$course_id' ");
        $prev_archeivement = mysqli_fetch_assoc($get_prev_archeivement);
        // process acheivement
        if ($score == 100) {
            $submitted_at = date('Y-m-d H:i:s');
            if ($prev_archeivement) {
                $arch_number = $prev_archeivement['number'];
                $arch_id = $prev_archeivement['arch_id'];
                $arch_number = $arch_number + 1;
                $sql = "UPDATE achievements SET score = '$score', date = '$submitted_at', number = '$arch_number' WHERE arch_id = '$arch_id'";
                $result = mysqli_query($conn, $sql);
                $sql2 = "UPDATE enroll_students SET completed = 'Yes' WHERE student_id = '$student_id' AND course_id = '$course_id'";
                $result2 = mysqli_query($conn, $sql2);
            } else {
                $sql = "INSERT INTO achievements (score, date, number, student_id, course_id) VALUES ('$score', '$submitted_at', '1', '$student_id', '$course_id')";
                $result = mysqli_query($conn, $sql);
                $sql2 = "UPDATE enroll_students SET completed = 'Yes' WHERE student_id = '$student_id' AND course_id = '$course_id'";
                $result2 = mysqli_query($conn, $sql2);
            }
        }

        if (!$result) {
            die('Error inserting quiz results: ' . mysqli_error($conn));
        }
    } else {
        // Initialize variables for scoring the quiz
        $total_questions = mysqli_num_rows($result);
        $total_correct = 0; // Initialize total_correct to 0

        // Retrieve the questions for the specified course
        $sql = "SELECT * FROM quizzes WHERE course_id = '$course_id'";
        $result = mysqli_query($conn, $sql);
        // Loop through each question and check the student's answer
        while ($row = mysqli_fetch_assoc($result)) {
            $answer_id = $row['id'];
            $student_answer = $_POST['answer'][$answer_id];
            $correct_answer = $row['answer'];
            if ($student_answer == $correct_answer) {
                $total_correct++;
            }
        }

        // Calculate the student's score as a percentage
        $score = number_format(($total_correct / $total_questions) * 100, 0);

        // Insert the quiz results into the quiz_results table
        $student_id = $_SESSION['student_id'];
        $submitted_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO quiz_results (student_id, course_id, score, date) VALUES ('$student_id', '$course_id', '$score', '$submitted_at')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Error inserting quiz results: ' . mysqli_error($conn));
        }
    }
} else {
    // If the form was not submitted, redirect the user to the quiz page
    header("Location: student-take-quiz.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz Result Details</title>

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

                    <div class="navbar navbar-list navbar-light bg-white border-bottom-2 border-bottom navbar-expand-sm" style="white-space: nowrap;">
                        <div class="container page__container">
                            <nav class="nav navbar-nav">
                                <div class="nav-item navbar-list__item">
                                    <a href="student-take-lesson.php?id=<?php echo $course_id ?>" class="nav-link h-auto"><i class="material-icons icon--left">keyboard_backspace</i> Back to Course</a>
                                </div>
                                <div class="nav-item navbar-list__item">
                                    <div class="d-flex align-items-center flex-nowrap">
                                        <div class="mr-16pt">
                                            <a href="student-take-lesson.php?id=<?php echo $course_id ?>"><img src="<?php echo $course['image_path'] ?>" width="40" alt="Angular" class="rounded"></a>
                                        </div>
                                        <div class="flex">
                                            <a href="student-take-lesson.php?id=<?php echo $course_id ?>" class="card-title text-body mb-0"><?php echo $course['course_title'] ?></a>
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
                    <div class="mdk-box bg-primary mdk-box--bg-gradient-primary2 js-mdk-box mb-0" data-effects="blend-background">
                        <div class="mdk-box__content">
                            <div class="py-64pt text-center text-sm-left">
                                <div class="container d-flex flex-column justify-content-center align-items-center">
                                    <p class="lead text-white-50 measure-lead-max mb-0">Submited on <?php echo $submitted_at; ?></p>
                                    <h1 class="text-white mb-24pt">
                                        <?php
                                        echo '<p>You answered ' . $total_correct . ' out of ' . $total_questions . ' questions correctly (' . $score . '%).</p>'; ?>
                                    </h1>
                                    <a href="student-take-quiz.php?id=<?php echo $course_id; ?>" class="btn btn-outline-white">Restart quiz</a> <br>
                                    <?php
                                    if ($score == 100) {
                                        echo "<p class='p-2 text-white'>Congratulations! You have received +1 acheivement in this course.</p>";
                                    }
                                    echo '<a href="student-my-acheivements.php" class="btn btn-outline-white">See Achievements</a>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navbar navbar-expand-sm navbar-light navbar-submenu navbar-list p-0 m-0 align-items-center">
                        <div class="container page__container">
                            <ul class="nav navbar-nav flex align-items-sm-center">
                                <li class="nav-item navbar-list__item">350/450 Score</li>
                                <li class="nav-item navbar-list__item">
                                    <i class="material-icons text-muted icon--left">schedule</i>
                                    12 minutes
                                </li>
                                <li class="nav-item navbar-list__item">
                                    <i class="material-icons text-muted icon--left">assessment</i>
                                    Intermediate
                                </li>
                            </ul>
                        </div>
                    </div>



                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./../Public/images/logo/black-70%402x.png" width="30" alt="Luma"> Online Classroom
                            </p>
                            <p class="measure-lead-max text-50 small mr-8pt">Online Claasrrom is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard, Curriculum Management, Earnings and Reporting, ERP, HR, CMS, Tasks, Projects, eCommerce and more.</p>
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