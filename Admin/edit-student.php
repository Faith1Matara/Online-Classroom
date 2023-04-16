<?php

require_once './../Include/config.php';
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("location: ./login.php");
    exit;
}

// Get the logged-in user's id
$student_id = $_GET['id'];

// Replace with your SQL query to retrieve the data from the student table
$sql = "SELECT * FROM student WHERE id = ?";

// Prepare the SQL query
$stmt = $conn->prepare($sql);

// Bind parameters to the prepared statement
$stmt->bind_param("i", $student_id);

// Execute the prepared statement
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Fetch the row
$row = $result->fetch_assoc();

$email = $row["email"];
$first_name = $row["first_name"];
$last_name = $row["last_name"];

// Define variables and initialize with empty values
$password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM student WHERE email = ? AND id != ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_email, $student_id);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate first_name
    if (empty(trim($_POST["first_name"]))) {
        $first_name_err = "Please enter first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last_name
    if (empty(trim($_POST["last_name"]))) {
        $last_name_err = "Please enter a last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate password
    if (!empty(trim($_POST["password"]))) {
        if (strlen(trim($_POST["password"])) < 8) {
            $password_err = "Password must have at least 8 characters.";
        } else {
            $password = trim($_POST["password"]);
        }
    } else {
        $password_err = "Please enter a password.";
    }

    // Validate confirm password
    if (!empty(trim($_POST["confirm_password"]))) {
        if (empty($password_err) && ($password != trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Passwords did not match.";
        }
    } else {
        $confirm_password_err = "Please confirm password.";
    }

    // Check input errors before updating in database
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($first_name_err) && empty($last_name_err)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Prepare an update statement
        $sql = "UPDATE student SET email = '$email', first_name = '$first_name', last_name = '$last_name', password = '$password' WHERE id = '$student_id'";
        $exec = mysqli_query($conn, $sql);
        if ($exec) {
            header("location: ./admin-manage-student.php");
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
    <title>Edit profile</title>

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
                                <h1 class="h2 mb-0">Edit Profile</h1>
                                <p class="text-breadcrumb">Account Management</p>
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
                                <div class="page-separator__text">Change Password</div>
                            </div>
                            <form method="post" class="col-sm-5 p-0">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password:</label>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Type a new password ..." value="<?php echo $password; ?>">
                                    <span class="help-block text-warning"><?php echo $password_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password2">Confirm Password:</label>
                                    <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Confirm your new password ..." value="<?php echo $confirm_password; ?>">
                                    <span class="help-block text-warning"><?php echo $confirm_password_err; ?></span>
                                </div>


                        </div>
                    </div>
                    <div class="page-section">
                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Change Name</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">First Name:</label>
                                <input id="first_name" name="first_name" type="text" class="form-control" placeholder="Type a first name ..." value="<?php echo $first_name; ?>">
                                <span class="help-block text-warning"><?php echo $first_name_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password2">Last Name:</label>
                                <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Type a last name ..." value="<?php echo $last_name; ?>">
                                <span class="help-block text-warning"><?php echo $last_name_err; ?></span>
                            </div>


                        </div>
                    </div>
                    <div class="page-section">
                        <div class="container page__container">
                            <div class="page-separator">
                                <div class="page-separator__text">Change Email</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email:</label>
                                <input name="email" id="email" type="email" class="form-control" placeholder="Type a new email ..." value="<?php echo $email; ?>">
                                <span class="help-block text-warning"><?php echo $email_err; ?></span>
                            </div>


                            <button type="submit" name="update-changes" class="btn btn-primary">Save changes</button>
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