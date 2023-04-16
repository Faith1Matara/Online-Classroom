<?php
include "./Include/config.php";

function search_help($search_query)
{
    global $conn;
    // build and execute SQL query to search for articles in helpcenter table
    $sql = "SELECT * FROM helpcenter WHERE title LIKE '%$search_query%' OR content LIKE '%$search_query%' OR link LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $rows;
}
$search_query = '';
if (isset($_GET['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
    $results = search_help($search_query);
} else {
    $sql = "SELECT * FROM helpcenter";
    $result = mysqli_query($conn, $sql);
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Help Center</title>

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

                <!-- Navbar -->

                <div class="navbar navbar-expand pr-0 navbar-light bg-white navbar-shadow" id="default-navbar" data-primary>

                    <!-- Navbar Toggler -->

                    <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
                        <span class="material-icons">short_text</span>
                    </button>

                    <!-- // END Navbar Toggler -->

                    <!-- Navbar Brand -->

                    <a href="./index.php" class="navbar-brand mr-16pt">

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>

                    <!-- // END Navbar Brand -->


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

                                <a class="dropdown-item" href="./index.php">Logout</a>
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
                                    <h2 class="mb-0">Help Center</h2>

                                    <ol class="breadcrumb p-0 m-0">
                                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>

                                        <li class="breadcrumb-item active">

                                            Help Center

                                        </li>

                                    </ol>

                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="container page__container page-section">

                        <div class="search-form form-control-rounded search-form--light mb-16pt">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="d-flex justify-content-between w-100">
                                <input type="text" class="form-control w-100" placeholder="Search articles" name="search_query" value="<?php echo $search_query; ?>">
                                <button class="btn" type="submit"><i class="material-icons">search</i></button>
                            </form>
                        </div>


                        <div class="mdk-drawer-layout__content page-content">

                            <div class="pt-32pt">
                                <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                                    <div class="flex d-flex flex-column flex-sm-row align-items-center">

                                        <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                            <h2 class="mb-0">FAQ</h2>


                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="page-section">
                                <div class="container page__container">




                                    <div class="row card-group-row">
                                        <?php foreach ($results as $row) { ?>
                                            <div class="col-md-6 card-group-row__col">

                                                <div class="card card--elevated card-group-row__card">
                                                    <div class="card-body d-flex">
                                                        <span class="icon-holder icon-holder--outline-muted rounded-circle d-inline-flex mr-16pt">
                                                            <i class="material-icons">question_answer</i>
                                                        </span>
                                                        <div class="flex">
                                                            <a class="card-title mb-4pt" href="#"><?php echo $row['title']; ?></a>
                                                            <p class="text-70 mb-0"><?php echo $row['content']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex lh-1 px-16pt py-8pt">
                                                        <div class="flex text-muted"><small><a class="text-primary" href="<?php echo $row['link']; ?>"><?php echo $row['link']; ?></a></small></div>
                                                        <a href="#" class="text-20"><i class="material-icons icon-16pt">thumb_up</i></a>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php }
                                        if (empty($results)) {
                                            echo '<div class="col-md-6 card-group-row__col">

                                            <div class="card card--elevated card-group-row__card"><p class="h6">No results found.</p></div>

                                            </div>';
                                        } ?>
                                    </div>

                                    <ul class="pagination justify-content-start pagination-xsm m-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                <span>Prev</span>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Page 1">
                                                <span>1</span>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Page 2">
                                                <span>2</span>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span>Next</span>
                                                <span aria-hidden="true" class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <!-- Footer -->

                            <div class="bg-white border-top-2 mt-auto">
                                <div class="container page__container page-section d-flex flex-column">
                                    <p class="text-70 brand mb-24pt">
                                        <img class="brand-icon" src="./Public/images/logo/black-70%402x.png" width="30" alt="Luma"> Online Classroom
                                    </p>
                                    <p class="measure-lead-max text-50 small mr-8pt">Online is a beautifully crafted user interface for modern Education Platforms, including Courses & Tutorials, Video Lessons, Student and Teacher Dashboard and more.</p>
                                    <p class="mb-8pt d-flex">
                                        <a href="#" class="text-70 text-underline mr-8pt small">Terms</a>
                                        <a href="#" class="text-70 text-underline small">Privacy policy</a>
                                    </p>
                                    <p class="text-50 small mt-n1 mb-0">Copyright 2023 &copy; All rights reserved.</p>
                                </div>
                            </div>

                            <!-- // END Footer -->

                        </div>


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
        <script src="./Public/Js/app.js"></script>

        <!-- Preloader -->
        <script src="./Public/Js/preloader.js"></script>

        <!-- App Settings (safe to remove) -->
        <!-- <script src="./Public/Js/app-settings.js"></script> -->
</body>

</html>