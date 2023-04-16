

<!DOCTYPE html>
<html lang="en"
      dir="ltr">

    
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"
              content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, shrink-to-fit=no">
              <title>Certificate of Completion</title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots"
              content="noindex">
              
	<style>
		/* certificate container styles */
		.certificate-container {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
			background-color: #f0f0f0;
		}

		/* certificate styles */
		.certificate {
			width: 800px;
			height: 580px;
			padding: 20px;
			text-align: center;
			border: 10px solid #787878;
			background-color: #ffffff;
		}

		/* download button styles */
		.download-button {
			display: inline-block;
			padding: 10px;
			background-color: #4285f4;
			color: #ffffff;
			font-size: 20px;
			font-weight: bold;
			border-radius: 5px;
			cursor: pointer;
			margin-top: 20px;
		}
	</style>

        <link href="../../../fonts.googleapis.com/css8f03.css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="../../Public/vendor/spinkit.css"
              rel="stylesheet">

        <!-- Perfect Scrollbar -->
        <link type="text/css"
              href="../../Public/vendor/perfect-scrollbar.css"
              rel="stylesheet">

        <!-- Material Design Icons -->
        <link type="text/css"
              href="../../Public/Css/material-icons.css"
              rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link type="text/css"
              href="../../Public/Css/fontawesome.css"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="../../Public/Css/preloader.css"
              rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css"
              href="../../Public/Css/app.css"
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

                    <!-- Navbar -->

                    <div class="navbar navbar-expand pr-0 navbar-light bg-white navbar-shadow"
                         id="default-navbar"
                         data-primary>



                        <!-- // END Navbar Toggler -->

                        <!-- Navbar Brand -->

                        <a href="./../index.php"
                           class="navbar-brand mr-16pt">

                            <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                                <span class="avatar-title rounded bg-primary"><img src="../../Public/images/illustration/student/128/white.svg"
                                         alt="logo"
                                         class="img-fluid" /></span>

                            </span>

                            <span class="d-none d-lg-block">Online Classroom</span>
                        </a>
                        <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                            <li class="nav-item active">
                                <a href="student-dashboard.php"
                                   class="nav-link">Dashboard</a>
                            </li>
                        
                         
                
                        </ul>


                        <!-- // END Navbar Brand -->


                        <!-- Navbar Search -->

                       
                        <!-- // END Navbar Search -->

                        <div class="flex"></div>

                        <!-- Navbar Menu -->

                        <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">

                            <!-- Notifications dropdown -->
                         
                            <!-- // END Notifications dropdown -->

                            <!-- Notifications dropdown -->
                            
                            <!-- // END Notifications dropdown -->

                            <div class="nav-item dropdown">
                                <a href="#"
                                   class="nav-link d-flex align-items-center dropdown-toggle"
                                   data-toggle="dropdown"
                                   data-caret="false">

                                    <span class="avatar avatar-sm mr-8pt2">

                                        <span class="avatar-title rounded-circle bg-primary"><i class="material-icons">account_box</i></span>

                                    </span>

                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header"><strong>Account</strong></div>
                                    <a class="dropdown-item"
                                       href="edit-account.php">Edit Account</a>
                                    
                                    <a class="dropdown-item"
                                       href="login.php">Logout</a>
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
                
                     <div class="certificate-container">
                        <div class="certificate">
                            <h1 style="font-size:50px; font-weight:bold; margin-bottom: 50px;">Certificate of Completion</h1>
                            <p style="font-size:25px; margin-bottom: 20px;"><i>This is to certify that</i></p>
                            <p style="font-size:30px; margin-bottom: 20px;"><b>$student.getFullName()</b></p>
                            <p style="font-size:25px; margin-bottom: 20px;"><i>has completed the course</i></p>
                            <p style="font-size:30px; margin-bottom: 20px;">$course.getName()</p>
                            <p style="font-size:20px; margin-bottom: 50px;">with a score of <b>$grade.getPoints()%</b></p>
                            <p style="font-size:25px; margin-bottom: 20px;"><i>dated</i></p>
                            <p style="font-size:20px; margin-bottom: 30px;">$DateFormatter.getFormattedDate($grade.getAwardDate(), "MMMM dd, yyyy")</p>
                            <button class="download-button" onclick="window.print()">Download Certificate</button>
                        </div>
                    </div>

                    <!-- Drawer Layout Content -->
                   
                    <!-- // END drawer-layout__content -->

                    <!-- Drawer -->


                </div>
                <!-- // END drawer-layout -->

            </div>
            <!-- // END Header Layout Content -->

        </div>
        <!-- // END Header Layout -->

        <!-- jQuery -->
        <script src="../../Public/vendor/jquery.min.js"></script>

        <!-- Bootstrap -->
        <script src="../../Public/vendor/popper.min.js"></script>
        <script src="../../Public/vendor/bootstrap.min.js"></script>

        <!-- Perfect Scrollbar -->
        <script src="../../Public/vendor/perfect-scrollbar.min.js"></script>

        <!-- DOM Factory -->
        <script src="../../Public/vendor/dom-factory.js"></script>

        <!-- MDK -->
        <script src="../../Public/vendor/material-design-kit.js"></script>

        <!-- App JS -->
        <script src="../../Public/js/app.js"></script>

        <!-- Preloader -->
        <script src="../../Public/js/preloader.js"></script>

        <!-- App Settings (safe to remove) -->
        <!-- <script src="../../Public/js/app-settings.js"></script> -->
    </body>

</html>