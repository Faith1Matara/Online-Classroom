<?php
// Initialize the session
session_start();

include "./../Include/config.php";

// Redirect to login page if user is not logged in
if (!isset($_SESSION["instructor_id"])) {
    header("location: ./login.php");
    exit;
}

function get_instructor_courses()
{
    global $conn;
    $instructor_id = $_SESSION["instructor_id"];

    $sql = "SELECT * FROM course WHERE instructor_id = $instructor_id ORDER BY course_id DESC LIMIT 3";
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

function get_courses_progress()
{
    global $conn;
    $instructor_id = $_SESSION["instructor_id"];

    $sql = "SELECT * FROM enroll_students WHERE instructor_id = $instructor_id  ORDER BY course_id DESC LIMIT 1";
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
$course_progress = get_courses_progress();
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
                                        <li class="breadcrumb-item"><a href="./../index.php">Home</a></li>

                                        <li class="breadcrumb-item active">

                                            Dashboard

                                        </li>

                                    </ol>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="page-section border-bottom-2">
                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Recent Courses</div>
                            </div>
                            <div class="row">
                                <?php foreach ($courses as $course) :
                                    $course_id = $course['course_id'];
                                    $get_image = mysqli_query($conn, "SELECT course_image FROM course WHERE course_id = '$course_id'");
                                    $course_data = mysqli_fetch_assoc($get_image);
                                    if ($course_data) { // Check if $course_data is not null
                                        $img_name = $course_data['course_image'];
                                        $img_url = './../Course/uploads/images/' . $img_name;
                                    }
                                ?>
                                    <div class="col-lg-4 mb-4">
                                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                            <div class="card-body" style="min-height: 300px">
                                                <img src="<?php echo $img_url ?>" alt="course" height="180px" width="100%" class="rounded" onerror="this.onerror=null;this.src='./../Public/images/default_cover_image.png';">
                                                <h5 class="mb-0">
                                                    <?php
                                                    echo $course['course_title'];
                                                    ?>
                                                </h5>
                                                <div>
                                                    <?php
                                                    $course_id = $course['course_id'];
                                                    // Count number of rows from the 'course' table
                                                    $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM enroll_students WHERE course_id = '$course_id'");
                                                    $count_result = mysqli_fetch_assoc($count_query);
                                                    $num_rows1 = $count_result['total'];
                                                    echo "Enrolled Students: " . $num_rows1;
                                                    ?>
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

                        </div>
                    </div>

                    <div class="container page__container page-section">

                        <div class="page-separator">
                            <div class="page-separator__text">Recent Course Progress</div>
                        </div>

                        <div class="card card-body mb-32pt">
                            <div class="card mb-0">
                                <div data-toggle="lists" data-lists-values='[
      "js-lists-values-course", 
      "js-lists-values-revenue",
      "js-lists-values-fees"
    ]' data-lists-sort-by="js-lists-values-revenue" data-lists-sort-desc="true" class="table-responsive">
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
                                        <?php foreach ($course_progress as $progress) :
                                            $course_id = $progress['course_id'];
                                            $get_image = mysqli_query($conn, "SELECT course_image FROM course WHERE course_id = '$course_id'");
                                            $progress_data = mysqli_fetch_assoc($get_image);
                                            if ($progress_data) { // Check if $course_data is not null
                                                $img_name = $progress_data['course_image'];
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
                                                                <a class="text-body js-lists-values-course" href="instructor-edit-course.php"><strong><?php echo $progress['course_name'] ?></strong></a>
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
                                            <tr>
                                                <td>
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
                        <div class="card card-body mb-32pt">
                            <div id="legend" class="chart-legend mt-0 mb-24pt justify-content-start"></div>
                            <div class="chart" style="height: 320px;">
                                <canvas id="earningsChart" class="chart-canvas js-update-chart-bar" data-chart-legend="#legend" data-chart-line-background-color="gradient:primary,gray" data-chart-prefix="$" data-chart-suffix="k"></canvas>
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

                                <li class="sidebar-menu-item active">
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
                                    <a class="sidebar-menu-button" href="./instructor-track-course-progress.php">
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

    <!-- Global Settings -->
    <script src="./../Public/js/settings.js"></script>

    <!-- Moment.js -->
    <script src="./../Public/vendor/moment.min.js"></script>
    <script src="./../Public/vendor/moment-range.js"></script>

    <!-- Chart.js -->
    <script src="./../Public/vendor/Chart.min.js"></script>

    <!-- UI Charts Page JS -->
    <script src="./../Public/js/chartjs-rounded-bar.js"></script>
    <script src="./../Public/js/chartjs.js"></script>

    <!-- Chart.js Samples -->
    <script src="./../Public/js/page.instructor-dashboard.js"></script>

    <!-- List.js -->
    <script src="./../Public/vendor/list.min.js"></script>
    <script src="./../Public/js/list.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./../Public/js/app-settings.js"></script> -->
</body>

</html>