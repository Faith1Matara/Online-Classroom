<?php
include "./../Include/config.php";



// Define variables and initialize with empty values
$resetcode = $password =  $confirmpassword = '';
$resetcode_err = $password_err = $confirmpassword = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate email
    if (empty(trim($_POST['resetcode']))) {
        $resetcode_err = 'Please enter your reset code';
    } else {
        $resetcode = trim($_POST['resetcode']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirmpassword"]))) {
        $confirmpassword_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirmpassword"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirmpassword_err = "Password did not match.";
        }
    }

    // Check input errors before resetting password
    if (empty($reset_code_err) && empty($password_err) && empty($confirm_password_err)) {
        // Check if reset code exists in database
        $result = mysqli_query($conn, "SELECT * FROM instructor WHERE reset_code = '$resetcode'");
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            $reset_code_err = "Invalid reset code.";
        } else {
            $user_id = $user['id'];
            // Update user's password and reset code
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_query($conn, "UPDATE instructor SET password = '$hashed_password', reset_code = NULL, reset_timestamp = NULL WHERE id = '$user_id'");
            if($stmt){
                header("location: ./login.php");
                exit();
            } else {
                $reset_code_err = "Cannot update password at the moment.";
            }
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from Online classroom.humatheme.com/Demos/Sticky_App_Layout/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Feb 2023 18:59:42 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link href="./../Public/Css/css8f03.css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap" rel="stylesheet">

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

                <div class="navbar navbar-expand navbar-light bg-white navbar-shadow" id="default-navbar" data-primary>

                    <!-- Navbar toggler -->
                    <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span>
                    </button>

                    <!-- Navbar Brand -->
                    <a href="./../index.php" class="navbar-brand mr-16pt">
                        <!-- <img class="navbar-brand-icon" src="./../Public/images/logo/white-100@2x.png" width="30" alt="Online Classroom"> -->

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./../Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>

                    <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                        <li class="nav-item">
                            <a href="./../index.php" class="nav-link">Home</a>
                        </li>

                    </ul>


                    <ul class="nav navbar-nav ml-auto mr-0">

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

                    <div class="pt-32pt pt-sm-64pt pb-32pt">
                        <div class="container page__container">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-md-5 p-0 mx-auto">
                                <div class="form-group">
                                    <label class="form-label" for="resetcode">Reset Code:</label>
                                    <input id="resetcode" name="resetcode" type="text" class="form-control" placeholder="Enter reset code" value="<?php echo $resetcode; ?>">
                                    <span class="help-block text-warning"><?php echo $resetcode_err; ?></span>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">Password:</label>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="new password" value="<?php echo $password; ?>">
                                    <span class="help-block text-warning"><?php echo $password_err; ?></span>

                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="confirmpassword">Confirm Password:</label>
                                    <input id="confirmpassword" name="confirmpassword" type="password" class="form-control" placeholder="confirm password" value="<?php echo $confirmpassword; ?>">
                                    <span class="help-block text-warning"><?php echo $confirmpassword_err; ?></span>

                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary">Save</button>
                                </div>
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
    <!-- <script src="./../Public/Js/app-settings.js"></script> -->
</body>


<!-- Mirrored from Online classroom.humatheme.com/Demos/Sticky_App_Layout/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Feb 2023 18:59:42 GMT -->

</html>