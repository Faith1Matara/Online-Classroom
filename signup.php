<?php

require_once './Include/config.php';

// Define variables and initialize with empty values
$email = $first_name = $last_name =  $password = $confirm_password = "";
$email_err = $first_name_err = $last_name_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Validate email
if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email address.";
} else {
    // Prepare a select statement
    $sql = "SELECT id FROM student WHERE email = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);

        // Set parameters
        $param_email = trim($_POST["email"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $email_err = "This email address is already taken.";
            } else {
                // Check if email is valid
                if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
                    $email_err = "Please enter a valid email address.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

}  
      
    

    // Validate first_name
    if (empty(trim($_POST["first_name"]))) {
        $first_name_err = "Please enter first name.";
    } else if (!preg_match("/^[\p{L}\s'-]+$/u", $_POST['first_name'])) {
        $first_name_err = "Only letters, apostrophes, hyphens, and spaces are allowed.";
    } else {
        $first_name = trim($_POST['first_name']);
    }

    // Validate last_name
    if (empty(trim($_POST["last_name"]))) {
        $last_name_err = "Please enter a last name.";
    } else {
        if (!preg_match("/^[\p{L}\s'-]+$/u", $_POST['last_name'])) {
            $last_name_err = "Only letters, apostrophes, hyphens, and spaces are allowed.";
        } else {
            $last_name = trim($_POST['last_name']);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        if (strlen(trim($_POST["password"])) < 8) {
            $password_err = "Password must have at least 8 characters.";
        } else {
            $password = trim($_POST["password"]);
        }
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($first_name_err) && empty($last_name_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO student (email, first_name, last_name, password) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_email, $param_first_name, $param_last_name, $param_password);

            // Set parameters
            $param_email = $email;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">



<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign Up</title>

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
                        <!-- <img class="navbar-brand-icon" src="./Public/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                            <span class="avatar-title rounded bg-primary"><img src="./Public/images/illustration/student/128/white.svg" alt="logo" class="img-fluid" /></span>

                        </span>

                        <span class="d-none d-lg-block">Online Classroom</span>
                    </a>

                    <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                        <li class="nav-item">
                            <a href="./index.php" class="nav-link">Home</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav ml-auto mr-0">
                        <li class="nav-item">
                            <a href="./login.php" class="nav-link" data-toggle="tooltip" data-title="Login" data-placement="bottom" data-boundary="window"><i class="material-icons">lock_open</i></a>
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
                    <div class="page-section container page__container">
                        <div class="col-lg-10 p-0 mx-auto">
                            <div class="row">
                                <div class="col-md-12 mb-24pt mb-md-0">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="form-group">
                                            <label class="form-label" for="first_name">First name:</label>
                                            <input id="first_name" id="name" name="first_name" type="text" class="form-control" placeholder="Your first and last name ..." value="<?php echo $first_name; ?>">
                                            <span class="help-block text-warning" id="name-error"><?php echo $first_name_err; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="last_name">Last name:</label>
                                            <input id="last_name" name="last_name" type="text" class="form-control" placeholder="Your first and last name ..." value="<?php echo $last_name; ?>">
                                            <span class="help-block text-warning"><?php echo $last_name_err; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">Email:</label>
                                            <input id="email" name="email" type="email" class="form-control" placeholder="Your email address ..." value="<?php echo $email; ?>">
                                            <span class="help-block text-warning"><?php echo $email_err; ?></span>
                                        </div>
                                        <div class="form-group mb-24pt">
                                            <label class="form-label" for="password">Password:</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Your password ..." value="<?php echo $password; ?>">
                                            <span class="help-block text-warning"><?php echo $password_err; ?></span>
                                        </div>

                                        <div class="form-group mb-24pt">
                                            <label class="form-label" for="password">Confirm Password:</label>
                                            <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="Your password ..." value="<?php echo $confirm_password; ?>">
                                            <span class="help-block text-warning"><?php echo $confirm_password_err; ?></span>
                                        </div>
                                        <button type="submit" name="signup-btn" class="btn btn-primary">Create account</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
    <!--<script>
        const nameInput = document.getElementById("name");
        const nameErr = document.getElementById("name-error");
        nameInput.addEventListener("keyup", function(){
            if(!isValidName(this.value)){
                nameErr.textContent = "Name should COntain only alphabets";
            } else {
                nameErr.textContent = "";
            }
        });
        function isValidName(name) {
            const regex = /^[a-zA-Z]+$/;
            return regex.test(name);
        }
    </script> -->


                    <!-- Footer -->

                    <div class="bg-white border-top-2 mt-auto">
                        <div class="container page__container page-section d-flex flex-column">
                            <p class="text-70 brand mb-24pt">
                                <img class="brand-icon" src="./Public/images/logo/black-70%402x.png" width="30" alt="Luma"> Online Classroom
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
    <!-- Password check as user types -->
<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
   <!-- <label>Password</label>
    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,16}$">
    <span id="password-help" class="help-block text-warning"><?php echo $password_err; ?></span>-->
</div>

<script>
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordHelp = document.querySelector('#password-help');
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,16}$/;

    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        const errors = [];

        if (!passwordPattern.test(password)) {
            if (password.length < 8) {
                errors.push('Password must be at least 8 characters.');
            } else if (password.length > 16) {
                errors.push('Password must be no more than 16 characters.');
            }
            if (!/[a-z]/.test(password)) {
                errors.push('Password must contain at least one lowercase letter.');
            }
            if (!/[A-Z]/.test(password)) {
                errors.push('Password must contain at least one uppercase letter.');
            }
            if (!/[0-9]/.test(password)) {
                errors.push('Password must contain at least one number.');
            }
            if (!/[!@#$%^&*_=+-]/.test(password)) {
                errors.push('Password must contain at least one special character (!@#$%^&*_=+-).');
            }
        }

        if (errors.length > 0) {
            passwordHelp.textContent = errors.join(' ');
            passwordHelp.classList.add('text-danger');
        } else {
            passwordHelp.textContent = '';
            passwordHelp.classList.remove('text-danger');
        }
    });
</script>


<!-- Email checks as user types -->
<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
   <!-- <label>Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
    <span id="email-help" class="help-block text-warning"><?php echo $email_err; ?></span>-->
</div>

<script>
    const emailInput = document.querySelector('input[name="email"]');
    const emailHelp = document.querySelector('#email-help');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    emailInput.addEventListener('input', () => {
        const email = emailInput.value;

        if (!emailPattern.test(email)) {
            emailHelp.textContent = 'Please enter a valid email address.';
            emailHelp.classList.add('text-danger');
        } else {
            emailHelp.textContent = '';
            emailHelp.classList.remove('text-danger');
        }
    });
</script>

<!-- firstname Checks as user types -->
<div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
   <!-- <label>Firstnamename</label>
    <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
    <span id="firstname-help" class="help-block text-warning"><?php echo $firstname_err; ?></span>-->
</div>

<script>
    const firstnameInput = document.querySelector('input[name="firstname"]');
    const firstnameHelp = document.querySelector('#firstname-help');

    firstnameInput.addEventListener('input', () => {
        const firstname = firstnameInput.value;

        if (/\d/.test(firstname)) {
            firstnameHelp.textContent = 'firstname must not contain any numbers.';
            firstnameHelp.classList.add('text-danger');
        } else {
            firstnameHelp.textContent = '';
            firstnameHelp.classList.remove('text-danger');
        }
    });
</script>

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