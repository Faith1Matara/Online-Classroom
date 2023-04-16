<?php
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["instructor_id"])) {
    header("location: ./login.php");
    exit;
}
require_once './../Include/config.php';


$course_id = $_GET['id'];
// Query the database to get the course data for the specified ID
$sql = "SELECT * FROM course WHERE course_id = '$course_id'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Store the retrieved course data in variables
$course_title = $row['course_title'];

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
} else {
    $course_id = "";
}

// If the form is submitted
if (isset($_POST['submit'])) {

    // Get the form data
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $answer = $_POST['answer'];

    // If the question and answer are not empty
    if (!empty($question) && !empty($answer)) {

        // If the question ID is set, update the question
        if (isset($_SESSION['edit_question_id'])) {
            $question_id = $_SESSION['edit_question_id'];
            $sql = "UPDATE quizzes SET question='$question', option1='$option1', option2='$option2', option3='$option3', option4='$option4', answer='$answer' WHERE id=$question_id";
            $result = mysqli_query($conn, $sql);
            unset($_SESSION['edit_question_id']);
        } else {
            // Insert the question into the database
            $sql = "INSERT INTO quizzes (course_id, question, option1, option2, option3, option4, answer) VALUES ('$course_id', '$question', '$option1', '$option2', '$option3', '$option4', '$answer')";
            $result = mysqli_query($conn, $sql);
            // header('"location: ./nstructor-edit-course.php?" . $corse_id');
        }

        // If the query is successful, display a success message
        if ($result) {
            $success_msg = "Question saved successfully.";
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $error_msg = "Question and answer fields are required.";
    }
}

// If the delete button is clicked
if (isset($_GET['delete'])) {
    $question_id = $_GET['delete'];
    $sql = "DELETE FROM quizzes WHERE id=$question_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $success_msg = "Question deleted successfully.";
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}

// If the edit button is clicked
if (isset($_GET['edit'])) {
    $question_id = $_GET['edit'];
    $_SESSION['edit_question_id'] = $question_id;
    $sql = "SELECT * FROM quizzes WHERE id=$question_id";
    $result = mysqli_query($conn, $sql);
    $question = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Course</title>

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

    <!-- Quill Theme -->
    <link type="text/css" href="./../Public/Css/quill.css" rel="stylesheet">
    <!-- Select2 -->
    <link type="text/css" href="./../Public/vendor/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="./../Public/Css/select2.css" rel="stylesheet">

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
                            <div class="flex d-flex flex-column flex-sm-row align-items-center">

                                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                    <h2 class="mb-0"><?php echo $course_title ?> Quizzes</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./instructor-dashboard.php">Dashboard</a></li>

                                        <li class="breadcrumb-item active">

                                            Course Quizzes

                                        </li>

                                    </ol>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="page-section border-bottom-2">
                        <div class="container page__container">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="page-separator">
                                        <div class="page-separator__text">Questions</div>
                                    </div>
                                    <div class="form-group mb-24pt">
                                        <div class="container">
                                            <h1>Create Quiz</h1>
                                            <?php if (isset($error_msg)) { ?>
                                                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                                            <?php } ?>
                                            <?php if (isset($success_msg)) { ?>
                                                <div class="alert alert-success"><?php echo $success_msg; ?></div>
                                            <?php } ?>
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="question">Question:</label>
                                                    <textarea class="form-control" id="question" name="question" rows="3"><?php $question ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="option1">Option 1:</label>
                                                    <input type="text" class="form-control" id="option1" name="option1" value="<?php $option1 ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="option2">Option 2:</label>
                                                    <input type="text" class="form-control" id="option2" name="option2" value="<?php $option2 ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="option3">Option 3:</label>
                                                    <input type="text" class="form-control" id="option3" name="option3" value="<?php $option3 ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="option4">Option 4:</label>
                                                    <input type="text" class="form-control" id="option4" name="option4" value="<?php $option4 ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="answer">Answer:</label>
                                                    <select class="form-control" id="answer" name="answer">
                                                        <option value="">Select answer</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                        <option value="4">Option 4</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="page-separator">
                                        <div class="page-separator__text">Add</div>
                                    </div>
                                    <div class="card">
                                        <div class="form-group">
                                            <div class="card-header text-center form-group">
                                                <a class="btn btn-accent" href="./instructor-add-question.php?id=<?php echo $course_id; ?>">Add Another Question</a>
                                            </div>
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

                            <div class="sidebar-heading">Instructor</div>
                            <ul class="sidebar-menu">

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="instructor-dashboard.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
                                        <span class="sidebar-menu-text">Instructor Dashboard</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="instructor-courses.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">import_contacts</span>
                                        <span class="sidebar-menu-text">Manage Courses</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="instructor-track-course-progress.php">
                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">trending_up</span>
                                        <span class="sidebar-menu-text">Track Course Progress</span>
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

    <!-- Quill -->
    <script src="./../Public/vendor/quill.min.js"></script>
    <script src="./../Public/js/quill.js"></script>
    <!-- Select2 -->
    <script src="./../Public/vendor/select2/select2.min.js"></script>
    <script src="./../Public/js/select2.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>

</html>