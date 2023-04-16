<?php
include "./../Include/config.php";

// Check if the admin is already logged in, and redirect to the home page
if (isset($_SESSION['admin_id'])) {
    header('Location: ./admin-dashboard.php');
    exit();
}

// Define variables and initialize with empty values
$email = $password = '';
$email_err = $password_err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate email
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter your email.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }

    // Check for errors before accessing the database
    if (empty($email_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, email, password FROM admin WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $admin_id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Retrieve the admin's name from the database
                            $sql = "SELECT first_name FROM admin WHERE email = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $first_name);
                            mysqli_stmt_fetch($stmt);

                            // Store data in session variables
                            $_SESSION['admin_id'] = $admin_id;
                            $_SESSION['email'] = $email;
                            $_SESSION['first_name'] = $first_name;

                            // Redirect admin to home page
                            header('Location: ./admin-dashboard.php');
                            exit();
                        } else {
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered is not valid.';
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = 'No account found with that email.';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later.';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en"
      dir="ltr">

    
<!-- Mirrored from Online classroom.humatheme.com/Demos/Sticky_App_Layout/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Feb 2023 18:59:42 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"
              content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login</title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots"
              content="noindex">

        <link href="./../Public/Css/css8f03.css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="./../Public/vendor/spinkit.css"
              rel="stylesheet">

        <!-- Perfect Scrollbar -->
        <link type="text/css"
              href="./../Public/vendor/perfect-scrollbar.css"
              rel="stylesheet">

        <!-- Material Design Icons -->
        <link type="text/css"
              href="./../Public/Css/material-icons.css"
              rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link type="text/css"
              href="./../Public/Css/fontawesome.css"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="./../Public/Css/preloader.css"
              rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css"
              href="./../Public/Css/app.css"
              rel="stylesheet">

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

            <div id="header"
                 class="mdk-header js-mdk-header mb-0"
                 data-fixed>
                <div class="mdk-header__content">

                    <div class="navbar navbar-expand navbar-light bg-white navbar-shadow"
                         id="default-navbar"
                         data-primary>

                        <!-- Navbar toggler -->
                        <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0"
                                type="button"
                                data-toggle="sidebar">
                            <span class="material-icons">short_text</span>
                        </button>

                        <!-- Navbar Brand -->
                        <a href="./../index.php"
                           class="navbar-brand mr-16pt">
                            <!-- <img class="navbar-brand-icon" src="./../Public/images/logo/white-100@2x.png" width="30" alt="Online Classroom"> -->

                            <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                                <span class="avatar-title rounded bg-primary"><img src="./../Public/images/illustration/student/128/white.svg"
                                         alt="logo"
                                         class="img-fluid" /></span>

                            </span>

                            <span class="d-none d-lg-block">Online Classroom</span>
                        </a>

                        <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                            <li class="nav-item">
                                <a href="./../index.php"
                                   class="nav-link">Home</a>
                            </li>
                            
                        </ul>

                      
                    </div>

                </div>
            </div>

            <!-- // END Header -->

            <!-- Header Layout Content -->
            <div class="mdk-header-layout__content">

                <!-- Drawer Layout -->
                <div class="mdk-drawer-layout js-mdk-drawer-layout"
                     data-push
                     data-responsive-width="992px">

                    <!-- Drawer Layout Content -->
                    <div class="mdk-drawer-layout__content page-content">

                        <div class="pt-32pt pt-sm-64pt pb-32pt">
                            <div class="container page__container">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                                      class="col-md-5 p-0 mx-auto">
                                    <div class="form-group">
                                        <label class="form-label"
                                               for="email">Email:</label>
                                        <input id="email"
                                                name="email"
                                               type="text"
                                               class="form-control"
                                               placeholder="Your email address ..."
                                               value="<?php echo $email; ?>">
                                               <span class="help-block text-warning"><?php echo $email_err; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"
                                               for="password">Password:</label>
                                        <input id="password"
                                                name="password"
                                               type="password"
                                               class="form-control"
                                               placeholder="Your first and last name ..."
                                               value="<?php echo $password; ?>">
                                               <span class="help-block text-warning"><?php echo $password_err; ?></span>
                                        <p class="text-right"><a href="reset-password.php"
                                               class="small">Forgot your password?</a></p>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                       

                        <!-- Footer -->

                        <div class="bg-white border-top-2 mt-auto">
                            <div class="container page__container page-section d-flex flex-column">
                                <p class="text-70 brand mb-24pt">
                                    <img class="brand-icon"
                                         src="./../Public/images/logo/black-70%402x.png"
                                         width="30"
                                         alt="Luma"> Online Classroom
                                </p>
                                <p class="measure-lead-max text-50 small mr-8pt">Online Classroom is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard and more.</p>
                                <p class="mb-8pt d-flex">
                                    <a href="#"
                                       class="text-70 text-underline mr-8pt small">Terms</a>
                                    <a href="#"
                                       class="text-70 text-underline small">Privacy policy</a>
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