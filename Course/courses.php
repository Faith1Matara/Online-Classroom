<?php

include "./../Include/config.php";
include "./../Include/functions.php";
// Initialize the session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION["student_id"])) {
    header("location: ./../login.php");
    exit;
}
$student_id = $_SESSION["student_id"];
$courses = get_courses(20);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Courses</title>

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

    <div class="preloader d-none">
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
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">Courses</a>
                        </li>

                    </ul>

                    <form class="search-form navbar-search d-none d-lg-flex mr-16pt" action="" style="max-width: 230px">
                        <button class="btn" type="submit"><i class="material-icons">search</i></button>
                        <input type="text" class="form-control" placeholder="Search ...">
                    </form>


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

                    <div class="page-section">
                        <div class="container page__container">




                            <div class="page-separator">
                                <div class="page-separator__text"> Courses</div>
                            </div>

                            <div class="row card-group-row">
                                <?php
                                // loop through each course
                                foreach ($courses as $course) :
                                    $img_url = './uploads/images/' . $course['course_image'];

                                    // fetch the instructor details for the current course
                                    $instructor_id = $course['instructor_id'];
                                    $get_instructor_name = mysqli_query($conn, "SELECT first_name, last_name FROM instructor WHERE id = $instructor_id");
                                    $instructor = mysqli_fetch_assoc($get_instructor_name);
                                ?>

                                    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col" id="<?php echo $course['course_id']; ?>">
                                        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card" data-overlay-onload-show data-popover-onload-show data-force-reveal data-partial-height="44" data-toggle="popover" data-trigger="click">
                                            <img src="<?php echo $img_url ?>" alt="course" height="200" width="100%" onerror="this.onerror=null;this.src='./../Public/images/default_cover_image.png';">
                                            <span class="overlay__content align-items-start justify-content-start">
                                                <span class="overlay__action card-body d-flex align-items-center">
                                                    <i class="material-icons mr-4pt">play_circle_outline</i>
                                                    <span class="card-title text-white">Preview</span>
                                                </span>
                                            </span>
                                            <div class="mdk-reveal__content">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex">
                                                            <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>"><?php echo $course["course_title"]; ?></a>
                                                            <small class="text-50 font-weight-bold mb-4pt"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?></small>
                                                        </div>
                                                        <?php
                                                        $course_id = $course['course_id'];
                                                        $sql = "SELECT * FROM enroll_students WHERE student_id = '$student_id' AND course_id = '$course_id'";
                                                        $result = mysqli_query($conn, $sql);
                                                        $stu = mysqli_fetch_assoc($result);
                                                        $s_id = $stu['student_id'];
                                                        $c_id = $stu['course_id'];
                                                        if ($stmt = $conn->prepare($sql)) {
                                                            if ($stmt->execute()) {
                                                                $stmt->store_result();
                                                                if ($stmt->num_rows > 0) {
                                                                    $sql1 = mysqli_query($conn, "SELECT * FROM achievements WHERE course_id = '$c_id' AND student_id = '$s_id'");
                                                                    $achv = mysqli_fetch_assoc($sql1);
                                                                    if ($achv) { ?>
                                                                        <a href="./../Student/student-quiz-result-details.php?id=<?php echo $course['course_id']; ?>" class="btn btn-secondary h-50">COMPLETED</a>
                                                                    <?php } else { ?>
                                                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-secondary h-50">CONTINUE</a>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id'] ?>">
                                                                        <form action="./../Student/student-take-lesson.php?id=<?php echo $course['course_id'] ?>" method="post">
                                                                            <input type="text" value="<?php echo $student_id ?>" name="student_id" hidden>
                                                                            <input type="text" hidden value="<?php echo $instructor['first_name'] . ' ' . $instructor['last_name']; ?>" name="instructor_name">
                                                                            <input type="text" hidden value="<?php echo $course['course_id']; ?>" name="course_id">
                                                                            <input type="text" hidden value="<?php echo $course["course_title"]; ?>" name="course_name">
                                                                            <input type="submit" value="ENROLL" name="enroll" class="btn btn-secondary">
                                                                        </form>
                                                                    </a>
                                                        <?php }
                                                            } else {
                                                                echo "Oops! Something went wrong. Please try again later.";
                                                            }

                                                            $stmt->close();
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="rating flex">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                        <small class="text-50">6 hours</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="popoverContainer d-none">
                                            <div class="media">
                                                <div class="media-left mr-12pt">
                                                    <img src="./../Public/images/paths/mailchimp_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                                </div>
                                                <div class="media-body">
                                                    <div class="card-title mb-0">Newsletter Design</div>
                                                    <p class="lh-1 mb-0">
                                                        <span class="text-50 small">with</span>
                                                        <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                    <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
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

                            <div class="page-separator">
                                <div class="page-separator__text"></div>
                            </div>

                            <div class="row card-group-row">

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/angular_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Learn Angular fundamentals</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/angular_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Learn Angular fundamentals</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/swift_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Build an iOS Application in Swift</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/swift_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Build an iOS Application in Swift</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/wordpress_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Build a WordPress Website</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/wordpress_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Build a WordPress Website</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="left" data-height="140">
                                            <img src="./../Public/images/paths/react_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Become a React Native Developer</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/react_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Become a React Native Developer</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="page-separator">
                                <div class="page-separator__text"> </div>
                            </div>

                            <div class="row card-group-row">

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/sketch_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Learn Sketch</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/sketch_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Learn Sketch</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/flinto_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Learn Flinto</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/flinto_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Learn Flinto</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/photoshop_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Learn Photoshop</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/photoshop_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Learn Photoshop</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

                                    <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card" data-toggle="popover" data-trigger="click">

                                        <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="card-img-top js-image" data-position="" data-height="140">
                                            <img src="./../Public/images/paths/figma_430x168.png" alt="course">
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
                                                    <a class="card-title" href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>">Learn Figma</a>
                                                    <small class="text-50 font-weight-bold mb-4pt">Elijah Murray</small>
                                                </div>
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
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
                                                <img src="./../Public/images/paths/figma_40x40%402x.png" width="40" height="40" alt="Angular" class="rounded">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-title mb-0">Learn Figma</div>
                                                <p class="lh-1 mb-0">
                                                    <span class="text-50 small">with</span>
                                                    <span class="text-50 small font-weight-bold">Elijah Murray</span>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="my-16pt text-70">Learn the fundamentals of working with Angular and how to create basic applications.</p>

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
                                                <a href="./../Student/student-take-lesson.php?id=<?php echo $course['course_id']; ?>" class="btn btn-primary">Enroll</a>
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