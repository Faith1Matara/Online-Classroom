<?php
include "./../Include/config.php";



// Define variables and initialize with empty values
$email = '';
$email_err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate email address
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        // Check if email address exists in database
        $email = $_POST['email'];
        $sql = "SELECT * FROM instructor WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            $email_err = "Email address not found.";
        } else {
            // Generate reset code
            $reset_code = bin2hex(random_bytes(16));

            $reset_message = '<div style="padding: 5px">
            <div>
                <p>You have requested for a password reset code</p>
                <p>Your reset code is <span style="color: blue">' . $reset_code . '</span></p>
            </div>
        </div>';


            // Store reset code and timestamp in database
            $sql = "UPDATE instructor SET reset_code = '$reset_code', reset_timestamp = NOW() WHERE id = '{$user['id']}'";
            mysqli_query($conn, $sql);

            // Send email with reset code
            require './../Mailer/PHPMailer/src/SMTP.php';
            require './../Mailer/PHPMailer/src/Exception.php';
            require './../Mailer/PHPMailer/src/PHPMailer.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = "matara10028@gmail.com";
                $mail->Password   = 'jurgayemjtvbmslr';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('matara10028@gmail.com', 'Online Classroom');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body    = $reset_message;

                $mail->send();

                // Redirect to reset password page
                header("Location: /instructor-reset-password.php?email=" . $email);
                exit();
            } catch (Exception $e) {
                $email_err = "An error occurred while sending the email: " . $mail->ErrorInfo;
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
                        <!-- <img class="navbar-brand-icon" src="./Public/images/logo/white-100@2x.png" width="30" alt="Online Classroom"> -->

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
                                    <label class="form-label" for="email">Email: </label>
                                    <input id="email" name="email" type="text" class="form-control" placeholder="Your email address ..." value="<?php echo $email; ?>">
                                    <span class="help-block text-warning"><?php echo $email_err; ?></span>
                                </div>

                               
                                
                                <div class="text-center">
                                    <button class="btn btn-primary">Send code</button>
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
    <!-- <script src="./Public/Js/app-settings.js"></script> -->
</body>


<!-- Mirrored from Online classroom.humatheme.com/Demos/Sticky_App_Layout/login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Feb 2023 18:59:42 GMT -->

</html>