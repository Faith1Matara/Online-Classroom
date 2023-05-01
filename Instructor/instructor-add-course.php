<?php
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["instructor_id"])) {
    header("location: ./login.php");
    exit;
}
require_once './../Include/config.php';

// Define variables and initialize with empty values
$instructor_id = $_SESSION["instructor_id"];
$course_title = $course_description = $course_introduction = $image_path = $file_path = $course_content = $file_err = $course_image = $video_link = "";
$instructor_id_err = $course_title_err = $course_description_err = $course_introduction_err = $course_content_err = $file_err = $video_link_err = $image_err = "";

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
            $upload_path = "../Course/uploads/images/" . $file_name;
            // Set the path for the image in the database
            $course_image = $file_name;

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
            $upload_path = "../Course/uploads/pdfs/" . $file_name;
            // Set the path for the file in the database
            $file_path = $file_name;

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

    // Check input errors before inserting in database
    if (empty($course_title_err) && empty($course_description_err) && empty($course_introduction_err) && empty($course_content_err) && empty($file_err) && empty($video_link_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO course (instructor_id, course_title, course_description, course_introduction, course_content, course_image, video_link, image_path, file_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("issssssss", $param_instructor_id, $param_course_title, $param_course_description, $param_course_introduction, $param_course_content, $param_course_image, $param_video_link, $param_course_image_path, $param_file_path);

            // Set parameters
            $param_instructor_id = $instructor_id;
            $param_course_title = $course_title;
            $param_course_description = $course_description;
            $param_course_introduction = $course_introduction;
            $param_course_content = $course_content;
            $param_course_image = $course_image;
            $param_video_link = $video_link;
            $param_course_image_path = $image_path;
            $param_file_path = $file_path;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to courses page
                header("location: ./instructor-add-course.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
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
                                    <h2 class="mb-0">Add Course</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./instructor-courses.php">Dashboard</a></li>

                                        <li class="breadcrumb-item active">

                                            Add Course

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
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="page-separator">
                                            <div class="page-separator__text">Basic information</div>
                                        </div>
                                        <div class="form-group mb-24pt">
                                            <label class="form-label" for="course_title">Course title</label>
                                            <input type="text" class="form-control form-control-lg" value="<?php echo $course_title ?>" name="course_title">
                                            <span class="help-block text-warning"><?php echo $course_title_err; ?></span>
                                        </div>

                                        <div class="form-group mb-32pt">
                                            <label class="form-label" for="course_description">Description</label>
                                            <textarea class="form-control" rows="3" name="course_description"><?php echo $course_description ?></textarea>
                                            <!-- <div style="height: 150px;" class="mb-0" data-toggle="quill" data-quill-placeholder="Course description">
                                                <h1>Hello World!</h1>
                                                <p>Some initial <strong>bold</strong> text</p>
                                                <p><br></p>
                                            </div> -->
                                            <span class="help-block text-warning"><?php echo $course_description_err; ?></span>
                                        </div>

                                        <div class="page-separator">
                                            <div class="page-separator__text">Sections</div>
                                        </div>
                                        <div class="form-group mb-24pt">
                                            <label class="form-label" for="course_introduction">Course Introduction</label>
                                            <input type="text" class="form-control form-control-lg" value="<?php echo $course_introduction ?>" name="course_introduction">
                                            <span class="help-block text-warning"><?php echo $course_introduction_err; ?></span>
                                        </div>
                                        <div class="form-group mb-24pt">
                                            <label class="form-label" for="course_content">Course Content</label>
                                            <input type="text" class="form-control form-control-lg" value="<?php echo $course_content ?>" name="course_content">
                                            <span class="help-block text-warning"><?php echo $course_content_err; ?></span>
                                        </div>

                                        <div class="form-group mb-32pt">
                                            <label class="form-label" for="file">Content File (PDF only)</label>
                                            <input type="file" name="file" class="form-control-file <?php echo (!empty($file_err)) ? 'is-invalid' : ''; ?>">
                                            <span class="help-block text-warning"><?php echo $file_err; ?></span>
                                        </div>

                                        <div class="form-group mb-32pt">
                                            <label class="form-label">Display Image</label>
                                            <input type="file" name="course_image" class="form-control-file <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                                            <span class="help-block text-warning"><?php echo $image_err; ?></span>
                                        </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="page-separator">
                                        <div class="page-separator__text">Video</div>
                                    </div>

                                    <div class="card">

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Video Upload</label>
                                                <input type="file" accept="video/*" class="form-control" name="video_file" onchange="loadVideo(event)">
                                                <span class="help-block text-warning"><?php echo $video_file_err; ?></span>
                                                <video id="video-preview" style="display:none;" controls></video>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="form-group">
                                            <div class="card-header text-center form-group">
                                                <input class="btn btn-accent" type="submit" name="save-course" value="Add Course"></input>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
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
   <script>
    function loadVideo(event) {
    var video = document.getElementById('video-preview');
    var file = event.target.files[0];
    var video_url = URL.createObjectURL(file);
    video.src = video_url;
    video.style.display = "block";
    document.getElementsByName('video_link')[0].value = video_url;
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