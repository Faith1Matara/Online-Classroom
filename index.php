<?php
session_start();
include "./Include/config.php";
include "./Include/functions.php";
$courses = get_courses(20);

function get_feedback()
{
    global $conn;

    $sql = "SELECT * FROM feedback WHERE status = 'approved'";
    $result = mysqli_query($conn, $sql);
    $feedback = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $feedback[] = $row;
    }
    return $feedback;
}

$feedbacks = get_feedback();
$feedback_err = "";
if (isset($_POST['send-feedback'])) {
    if (empty($_POST['feedback'])) {
        $feedback_err = "Please Enter feedback or comments";
        echo '<script>alert("Please Enter feedback or comments")</script>';
    } else {
        $feedback = $_POST['feedback'];
    }
    $email = $_POST['email'];
    if (empty($feedback_err)) {
        $exec = mysqli_query($conn, "INSERT INTO feedback (student_email, feedback) VALUES ('$email', '$feedback')");
        echo '<script>alert("Thank you for your feedback! It will be reviwed shortly.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Online Classroom</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <link href="./Public/Css/css8f03.css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="./Public/vendor/spinkit.css" rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="./Public/vendor/perfect-scrollbar.css" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="./Public/Css/material-icons.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="./Public/Css/fontawesome.css" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="./Public/Css/preloader.css" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="./Public/Css/app.css" rel="stylesheet">

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
                    <a href="./index.php" class="navbar-brand mr-16pt">
                        <!-- <img class="navbar-brand-icon" src="./Public/images/logo/white-100@2x.png" width="30" alt="Online Classroom"> -->

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>

                    <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                        <li class="nav-item active">
                            <a href="./index.php" class="nav-link">Home</a>
                        </li>



                    </ul>



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


            <!-- Drawer Layout Content -->
            <div class="mdk-drawer-layout__content page-content">

                <div class="mdk-box mdk-box--bg-primary bg-dark js-mdk-box mb-0" data-effects="parallax-background blend-background">
                    <div class="mdk-box__bg">
                        <div class="mdk-box__bg-front" style="background-image: url(./Public/images/photodune-4161018-group-of-students-m.jpg);"></div>
                    </div>
                    <div class="mdk-box__content justify-content-center">
                        <div class="hero container page__container text-center py-112pt text-md-left">
                            <h1 class="text-white text-shadow">Learn to Code</h1>
                            <p class="lead measure-hero-lead mx-auto mx-md-0 text-white text-shadow mb-48pt">Business, Technology and Creative Skills taught by industry experts. Explore a wide range of skills with our professional tutorials.</p>

                            <a href=" ./Course/courses.php" class="btn btn-lg btn-white btn--raised mb-16pt">Browse Courses</a>

                            <p class="mb-0"><a href="./Instructor/instructor-dashboard.php" class="text-white text-shadow"><strong>Are you a teacher?</strong></a></p>

                        </div>
                    </div>
                </div>

                <div class="border-bottom-2 py-16pt navbar-light bg-white border-bottom-2">
                    <div class="container page__container">
                        <div class="row align-items-center">
                            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                                    <i class="material-icons text-white">subscriptions</i>
                                </div>
                                <div class="flex">
                                    <div class="card-title mb-4pt">8,000+ Courses</div>
                                    <p class="card-subtitle text-70">Explore a wide range of skills.</p>
                                </div>
                            </div>
                            <div class="d-flex col-md align-items-center border-bottom border-md-0 mb-16pt mb-md-0 pb-16pt pb-md-0">
                                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                                    <i class="material-icons text-white">verified_user</i>
                                </div>
                                <div class="flex">
                                    <div class="card-title mb-4pt">By Industry Experts</div>
                                    <p class="card-subtitle text-70">Professional development from the best people.</p>
                                </div>
                            </div>
                            <div class="d-flex col-md align-items-center">
                                <div class="rounded-circle bg-primary w-64 h-64 d-inline-flex align-items-center justify-content-center mr-16pt">
                                    <i class="material-icons text-white">update</i>
                                </div>
                                <div class="flex">
                                    <div class="card-title mb-4pt">Unlimited Access</div>
                                    <p class="card-subtitle text-70">Signup and get unlimited access to learning materials.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="page-section border-bottom-2">
                    <div class="container page__container">
                        <div class="page-separator">
                            <div class="page-separator__text"> Courses</div>
                        </div>
                        <div class="position-relative carousel-card p-0 mx-auto">
                            <div class="row d-block js-mdk-carousel" id="carousel-feedback">
                                <a class="carousel-control-next js-mdk-carousel-control mt-n24pt" href="#carousel-feedback" role="button" data-slide="next">
                                    <span class="carousel-control-icon material-icons" aria-hidden="true">keyboard_arrow_right</span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <div class="mdk-carousel__content">

                                    <div class="row card-group-row">
                                        <?php
                                        // loop through each course
                                        foreach ($courses as $course) :
                                            $img_url = './Course/uploads/images/' . $course['course_image'];

                                            // fetch the instructor details for the current course
                                            $instructor_id = $course['instructor_id'];
                                            $get_instructor_name = mysqli_query($conn, "SELECT first_name, last_name FROM instructor WHERE id = $instructor_id");
                                            $instructor = mysqli_fetch_assoc($get_instructor_name);
                                        ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                                <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                                    <a href=" ./Course/courses.php#<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                                        <img src="<?php echo $img_url ?>" alt="course" onerror="this.onerror=null;this.src='./Public/images/default_cover_image.png';">
                                                        <span class="overlay__content">
                                                            <span class="overlay__action d-flex flex-column text-center">
                                                                <i class="material-icons icon-32pt">play_circle_outline</i>
                                                                <span class="card-title text-white">Preview</span>
                                                            </span>
                                                        </span>
                                                    </a>

                                                    <div class="card-body flex">
                                                        <div class="d-flex">
                                                            <div class="flex">
                                                                <a class="card-title" href=" ./Course/courses.php#<?php echo $course['course_id']; ?>"><?php echo $course['course_title']; ?></a>
                                                                <small class="text-50 font-weight-bold mb-4pt"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></small>
                                                            </div>

                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="rating flex">
                                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            </div>
                                                            <!-- <small class="text-50">6 hours</small> -->
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="row justify-content-between">
                                                            <div class="col-auto d-flex align-items-center">
                                                                <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                                                <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center">
                                                                <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                                                <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="popoverContainer d-none">
                                                    <div class="media">
                                                        <div class="media-left mr-12pt">
                                                            <img src="./Public/images/paths/sketch_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="card-title mb-0"><?php echo $course['course_title'] ?></div>
                                                            <p class="lh-1 mb-0">
                                                                <span class="text-50 small">with</span>
                                                                <span class="text-50 small font-weight-bold"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <p class="my-16pt text-70"><?php echo $course['course_description'] ?></p>

                                                    <div class="mb-16pt">
                                                        <div class="d-flex align-items-center">
                                                            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                            <p class="flex text-50 lh-1 mb-0"><small>Fundamentals of working with Angular</small></p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                            <p class="flex text-50 lh-1 mb-0"><small>Create complete Angular applications</small></p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                            <p class="flex text-50 lh-1 mb-0"><small>Working with the Angular CLI</small></p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                            <p class="flex text-50 lh-1 mb-0"><small>Understanding Dependency Injection</small></p>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
                                                            <p class="flex text-50 lh-1 mb-0"><small>Testing with Angular</small></p>
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="d-flex align-items-center mb-4pt">
                                                                <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                                                                <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-4pt">
                                                                <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                                                                <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                                                                <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                                                            </div>
                                                        </div>
                                                        <div class="col text-right">
                                                            <a href=" ./Course/courses.php#<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-section">
            <div class="container page__container">
                <div class="page-headline text-center">
                    <h2>Feedback</h2>
                    <p class="lead measure-lead mx-auto text-70">What other students turned professionals have to say about us after learning with us and reaching their goals.</p>
                </div>
                <div class="row">
                    <?php foreach ($feedbacks as $feedback) : ?>
                        <div class="col-md-4">
                            <div class="card card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-70 small mb-0"><?php echo $feedback['feedback']; ?></p>
                                </blockquote>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($feedback)) : ?>
                        <div class="col-md-12">
                            <p>No feedbacks available.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['email'])) {
                    echo '';
                } ?>
                <div class="text-center p-3">
                    <h3>Add feedback</h3>
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" value="<?php echo $_SESSION['email']; ?>" name="email" hidden>
                        </div>
                        <div class="form-group">
                            <textarea name="feedback" id="" cols="60" rows="6" placeholder="Enter your feedback"></textarea>
                            <p class="text-warning"><?php echo $feedback_err; ?></p>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send" name="send-feedback" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <style>
            .btn-floating {
                position: relative;
                overflow: hidden;
                padding: 0;
                width: 3rem;
                height: 3rem;
                line-height: 3rem;
                border-radius: 50%;
                text-align: center;
            }

            .rounded-circle {
                border-radius: 50% !important;
            }

            .position-fixed {
                position: fixed !important;
            }

            .bottom-0 {
                bottom: 0 !important;
            }

            .end-0 {
                right: 0 !important;
            }

            .mb-3 {
                margin-bottom: 1rem !important;
            }

            .me-3 {
                margin-right: 1rem !important;
            }
        </style>

        <!-- Button to redirect to helpcenter page -->
        <a href="help-center.php" class="btn btn-primary btn-floating rounded-circle position-fixed bottom-0 end-0 mb-3 me-3" style="z-index: 1030;">
            <i class="bi bi-question-circle">Help</i>
        </a>

        <!-- Footer -->

        <div class="bg-white border-top-2 mt-auto">
            <div class="container page__container page-section d-flex flex-column">
                <p class="text-70 brand mb-24pt">
                    <img class="brand-icon" src="./Public/images/logo/black-70%402x.png" width="30" alt="Online Classroom"> Online Classroom
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

        <!-- // END drawer-layout__content -->

        <!-- Drawer -->

        <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
            <div class="mdk-drawer__content top-navbar">
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
    <script src="./Public/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="./Public/vendor/popper.min.js"></script>
    <script src="./Public/vendor/bootstrap.min.js"></script>

    <!-- Perfect Scrollbar -->
    <script src="./Public/vendor/perfect-scrollbar.min.js"></script>

    <!-- DOM Factory -->
    <script src="./Public/vendor/dom-factory.js"></script>

    <!-- MDK -->
    <script src="./Public/vendor/material-design-kit.js"></script>

    <!-- App JS -->
    <script src="./Public/Js//app.js"></script>

    <!-- Preloader -->
    <script src="./Public/Js//preloader.js"></script>

    <!-- App Settings (safe to remove) -->
    <!-- <script src="./Public/Js//app-settings.js"></script> -->
</body>



</html>