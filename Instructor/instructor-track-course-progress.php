<?php
include "./../Include/config.php";
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["instructor_id"])) {
    header("location: ./login.php");
    exit;
}

function get_instructor_courses()
{
    global $conn;
    $instructor_id = $_SESSION["instructor_id"];

    $sql = "SELECT * FROM enroll_students WHERE instructor_id = $instructor_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $courses = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }

    return $courses;
}
$courses = get_instructor_courses();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Track Course</title>

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

    <!-- Flatpickr -->
    <link type="text/css" href="./../Public/Css/flatpickr.css" rel="stylesheet">
    <link type="text/css" href="./../Public/Css/flatpickr-airbnb.css" rel="stylesheet">
    <style>
        @media print {
            #progress-table {
                display: block;
            }
        }
    </style>

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
                            <div class="flex d-flex flex-column flex-sm-row align-items-center">

                                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                    <h2 class="mb-0">Course Progress</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./../index.php">Home</a></li>

                                        <li class="breadcrumb-item active">

                                            Course Progress

                                        </li>

                                    </ol>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="container page__container page-section">


                        <div class="page-separator">
                            <div class="page-separator__text">Course Progress</div>
                        </div>
                        <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" onclick="printTable()">Print</button>
                                </div>
                        <div class="card mb-0">
                            <div data-toggle="lists" data-lists-values='["js-lists-values-course", "js-lists-values-revenue","js-lists-values-fees"]' data-lists-sort-by="js-lists-values-revenue" data-lists-sort-desc="true" class="table-responsive">
                                <table class="table table-nowrap table-flush">
                                    <thead>
                                        <tr class="text-uppercase small">
                                            <th>
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-course">Course</a>
                                            </th>
                                            <th class="text-center" style="width:130px">
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-revenue">Completed</a>
                                            </th>
                                            <th class="text-center" style="width:130px">
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-fees">In Progress</a>
                                            </th>

                                        </tr>
                                    </thead>
                                    <?php foreach ($courses as $course) :
                                        $course_id = $course['course_id'];
                                        $get_image = mysqli_query($conn, "SELECT course_image FROM course WHERE course_id = '$course_id'");
                                        $course_data = mysqli_fetch_assoc($get_image);
                                        if ($course_data) { // Check if $course_data is not null
                                            $img_name = $course_data['course_image'];
                                            $img_url = './../Course/uploads/images/' . $img_name;
                                        }
                                    ?>
                                        <tbody class="list">

                                            <tr>
                                                <td>
                                                    <div class="media flex-nowrap align-items-center">
                                                        <a href="instructor-edit-course.php" class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
                                                            <img src="<?php echo $img_url ?>" alt="course" class="avatar-img rounded" onerror="this.onerror=null;this.src='./../Public/images/default_cover_image.png';">
                                                            <span class="overlay__content"></span>
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course" href="instructor-edit-course.php"><strong><?php echo $course['course_name'] ?></strong></a>
                                                            <div class="text-muted small">
                                                                <?php
                                                                // Count number of rows from the 'course' table
                                                                $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM enroll_students WHERE course_id = '$course_id'");
                                                                $count_result = mysqli_fetch_assoc($count_query);
                                                                $num_rows1 = $count_result['total'];
                                                                echo $num_rows1 . "Student(s)";
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center text-70">
                                                    <span class="js-lists-values-revenue">
                                                        <?php
                                                        // Count number of rows from the 'course' table
                                                        $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM enroll_students WHERE course_id = '$course_id' AND completed = 'Yes'");
                                                        $count_result = mysqli_fetch_assoc($count_query);
                                                        $num_rows2 = $count_result['total'];
                                                        echo $num_rows2;
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="text-center text-70">

                                                    <span class="js-lists-values-fees">
                                                        <?php echo $num_rows1 - $num_rows2;
                                                        ?>
                                                    </span>

                                                </td>
                                            </tr>

                                        </tbody>
                                    <?php endforeach; ?>
                                    <?php if (empty($course)) : ?>
                                        <div class="col-md-12">
                                            <p>No courses found.</p>
                                        </div>
                                    <?php endif; ?>
                                    <tfoot class="text-right">
                                        </td>
                                        <td colspan="3" class="text-center">
                                            <?php
                                            // Count number of rows from the 'course' table
                                            $instructor_id = $_SESSION["instructor_id"];
                                            $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM enroll_students WHERE instructor_id = '$instructor_id'");
                                            $count_result = mysqli_fetch_assoc($count_query);
                                            $num_rows2 = $count_result['total'];
                                            echo "<p class='font-bold'> My Total Students: " . $num_rows2 . "</p>";
                                            ?>
                                        </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-0 d-none"  id='progress-table' >
                            <div data-toggle="lists" data-lists-values='["js-lists-values-course", "js-lists-values-revenue","js-lists-values-fees"]' data-lists-sort-by="js-lists-values-revenue" data-lists-sort-desc="true" class="table-responsive">
                                <table class="table table-nowrap table-flush">
                                    <thead>
                                        <tr class="text-uppercase small">
                                            <th>
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-course">Course</a>
                                            </th>
                                            <th class="text-center" style="width:130px">
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-revenue">Completed</a>
                                            </th>
                                            <th class="text-center" style="width:130px">
                                                <a href="javascript:void(0)" class="sort" data-sort="js-lists-values-fees">In Progress</a>
                                            </th>

                                        </tr>
                                    </thead>
                                    <?php foreach ($courses as $course) :
                                        $course_id = $course['course_id'];
                                        $get_image = mysqli_query($conn, "SELECT course_image FROM course WHERE course_id = '$course_id'");
                                        $course_data = mysqli_fetch_assoc($get_image);
                                        if ($course_data) { // Check if $course_data is not null
                                            $img_name = $course_data['course_image'];
                                            $img_url = './../Course/uploads/images/' . $img_name;
                                        }
                                    ?>
                                        <tbody class="list">

                                            <tr>
                                                <td>
                                                    <div class="media flex-nowrap align-items-center">
                                                        <div class="media-body">
                                                            <a class="text-body js-lists-values-course" href="instructor-edit-course.php"><strong><?php echo $course['course_name'] ?></strong></a>
                                                            <div class="text-muted small">
                                                                <?php
                                                                // Select all students enrolled in the current course
                                                                $enrolled_students_query = mysqli_query($conn, "SELECT * FROM enroll_students WHERE course_id = '$course_id'");
                                                                while ($enrolled_student = mysqli_fetch_assoc($enrolled_students_query)) {
                                                                    $student_id = $enrolled_student['student_id'];
                                                                    // Select the student with the matching ID
                                                                    $student_query = mysqli_query($conn, "SELECT * FROM student WHERE id = '$student_id'");
                                                                    $student = mysqli_fetch_assoc($student_query);
                                                                    // Display the student's name
                                                                    echo $student['first_name'] . " " . $student['last_name'] . "<br>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center text-70">
                                                    <span class="js-lists-values-revenue">
                                                        <?php
                                                        // Select all students enrolled in the current course
                                                        $enrolled_students_query = mysqli_query($conn, "SELECT student_id FROM achievements WHERE course_id = '$course_id'");
                                                        $displayed_students = array(); // Array to store IDs of displayed students
                                                        while ($enrolled_student = mysqli_fetch_assoc($enrolled_students_query)) {
                                                            $student_id = $enrolled_student['student_id'];
                                                            // Check if the student has already been displayed
                                                            if (!in_array($student_id, $displayed_students)) {
                                                                // Add the student's ID to the array of displayed students
                                                                $displayed_students[] = $student_id;
                                                                // Select the student with the matching ID
                                                                $student_query = mysqli_query($conn, "SELECT * FROM student WHERE id = '$student_id'");
                                                                $student = mysqli_fetch_assoc($student_query);
                                                                // Display the student's name
                                                                echo $student['first_name'] . " " . $student['last_name'] . "<br>";
                                                            }
                                                        }
                                                        ?>

                                                    </span>
                                                </td>
                                                <td class="text-center text-70">

                                                    <span class="js-lists-values-fees">
                                                        <?php
                                                        // Select all students enrolled in the current course who are not in the achievements table
                                                        $students_query = mysqli_query($conn, "SELECT student.id, student.first_name, student.last_name 
                                       FROM enroll_students 
                                       LEFT JOIN achievements ON enroll_students.student_id = achievements.student_id 
                                       AND enroll_students.course_id = achievements.course_id
                                       INNER JOIN student ON enroll_students.student_id = student.id
                                       WHERE achievements.student_id IS NULL AND enroll_students.course_id = '$course_id'");

                                                        while ($student = mysqli_fetch_assoc($students_query)) {
                                                            // Display the student's name
                                                            echo $student['first_name'] . " " . $student['last_name'] . "<br>";
                                                        }
                                                        ?>

                                                    </span>

                                                </td>
                                            </tr>

                                        </tbody>
                                    <?php endforeach; ?>
                                    <?php if (empty($course)) : ?>
                                        <div class="col-md-12">
                                            <p>No courses found.</p>
                                        </div>
                                    <?php endif; ?>
                                    <tfoot class="text-right">
                                        </td>
                                        <td colspan="3" class="text-center">
                                            <?php
                                            // Count number of rows from the 'course' table
                                            $instructor_id = $_SESSION["instructor_id"];
                                            $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM enroll_students WHERE instructor_id = '$instructor_id'");
                                            $count_result = mysqli_fetch_assoc($count_query);
                                            $num_rows2 = $count_result['total'];
                                            echo "<p class='font-bold'> My Total Students: " . $num_rows2 . "</p>";
                                            ?>
                                        </td>
                                        </tr>
                                    </tfoot>
                                </table>
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

                                <li class="sidebar-menu-item active">
                                    <a class="sidebar-menu-button" href="#">
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
    <script>
        function printTable() {
            var printContents = document.getElementById('progress-table').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
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

    <!-- Flatpickr -->
    <script src="./../Public/vendor/flatpickr/flatpickr.min.js"></script>
    <script src="./../Public/js/flatpickr.js"></script>

    <!-- Global Settings -->
    <script src="./../Public/js/settings.js"></script>

    <!-- Chart.js -->
    <script src="./../Public/vendor/Chart.min.js"></script>
    <script src="./../Public/js/chartjs-rounded-bar.js"></script>
    <script src="./../Public/js/chartjs.js"></script>

    <!-- Chart.js Samples -->
    <script src="./../Public/js/page.instructor-earnings.js"></script>

    <!-- List.js -->
    <script src="./../Public/vendor/list.min.js"></script>
    <script src="./../Public/js/list.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>


</html>