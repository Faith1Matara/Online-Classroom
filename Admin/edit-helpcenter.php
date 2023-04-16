<?php

require_once './../Include/config.php';
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("location: ./login.php");
    exit;
}

$help_id = $_GET['id'];

$get_help = mysqli_query($conn, "SELECT * FROM helpcenter WHERE help_id = '$help_id'");
$help = mysqli_fetch_assoc($get_help);

// Define variables and initialize with empty values
$title = $help['title'];
$content = $help['content'];
$link = $help['link'];
$title_err = $content_err = $link_err = "";

// Processing form data when form is submitted
if (isset($_POST['update-help'])) {
    // Validate email
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a help title.";
    } else {
        // Prepare a select statement
        $sql = "SELECT help_id FROM helpcenter WHERE title = ? AND help_id != ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_title, $help_id);

            // Set parameters
            $param_title = trim($_POST["title"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $title_err = "This title is already created.";
                } else {
                    $title = trim($_POST["title"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter help content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Validate link
    if (empty(trim($_POST["link"]))) {
        $link_err = "Please enter a link.";
    } else {
        $link = trim($_POST["link"]);
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            $link_err = "Please enter a valid URL.";
        }
    }

    // Check input errors before updating in database
    if (empty($title_err) && empty($content_err) && empty($link_err)) {
        // Prepare an update statement
        $sql = "UPDATE helpcenter SET title = '$title', content = '$content', link = '$link' WHERE help_id = '$help_id'";
        $exec = mysqli_query($conn, $sql);
        if ($exec) {
            header("location: ./admin-manage-helpcenter.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close connection
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">




<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Help</title>

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

        <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.html -->
    </div>

    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <!-- Header -->

        <div id="header" class="mdk-header js-mdk-header mb-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand navbar-light bg-white navbar-shadow" id="default-navbar" data-primary>

                    <!-- Navbar toggler -->
                    <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span>
                    </button>

                    <!-- Navbar Brand -->
                    <a href="./../index.php" class="navbar-brand mr-16pt">
                        <!-- <img class="navbar-brand-icon" src="./../Public/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./../Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classsroom</span>
                    </a>





                    <ul class="nav navbar-nav ml-auto mr-0">
                        <li class="nav-item">
                            <a href="./login.php" class="nav-link" data-toggle="tooltip" data-title="Login" data-placement="bottom" data-boundary="window"><i class="material-icons">lock_open</i></a>
                        </li>
                        <li class="nav-item">
                            <a href="./signup.php" class="btn btn-outline-dark">Get Started</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <!-- Drawer Layout -->
            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">

                <!-- Drawer Layout Content -->
                <div class="mdk-drawer-layout__content page-content">

                    <div class="page-section pb-0">
                        <div class="container page__container d-flex flex-column flex-sm-row align-items-sm-center">
                            <div class="flex">
                                <h1 class="h2 mb-0">Edit Help</h1>
                                <p class="text-breadcrumb">Edit help questions</p>
                            </div>
                            <p class="d-sm-none"></p>
                            <a href="#" class="btn btn-outline-secondary flex-column">
                                Need Help?
                                <span class="btn__secondary-text">Contact us</span>
                            </a>
                        </div>
                    </div>
                    <div class="page-section">
                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Edit Help Content</div>
                            </div>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label class="form-label" for="title">Title:</label>
                                    <input id="title" name="title" type="text" class="form-control" placeholder="Type a title ..." value="<?php echo $title; ?>">
                                    <span class="help-block text-warning"><?php echo $title_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="content">Content:</label>
                                    <input id="content" name="content" type="text" class="form-control" placeholder="Type content ..." value="<?php echo $content; ?>">
                                    <span class="help-block text-warning"><?php echo $content_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="link">Link:</label>
                                    <input id="link" name="link" type="text" class="form-control" placeholder="add a link ..." value="<?php echo $link; ?>">
                                    <span class="help-block text-warning"><?php echo $link_err; ?></span>
                                </div>
                                <button type="submit" name="update-help" class="btn btn-primary">Update</button>
                            </form>
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