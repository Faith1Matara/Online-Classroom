<?php
include './config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL);
    exit();
}
$email = $email_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email address
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        // Check if email address exists in database
        $email = $_POST['email'];
        $sql = "SELECT * FROM user WHERE email = '$email'";
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
                <p>Your reser code is <span style="color: blue">Your reset code is ' . $reset_code . '</span></p>
            </div>
        </div>';


            // Store reset code and timestamp in database
            $sql = "UPDATE user SET reset_code = '$reset_code', reset_timestamp = NOW() WHERE id = '{$user['id']}'";
            mysqli_query($conn, $sql);

            // Send email with reset code
            require './PHPMailer/src/PHPMailer.php';
            require './PHPMailer/src/SMTP.php';
            require './PHPMailer/src/Exception.php';

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);

            try {
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $email;
                $mail->Password   = 'xlgjtfeubzpmtgjp';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('aderomourice7@gmail.com', 'Megamind Library');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body    = $reset_message;

                $mail->send();

                // Redirect to reset password page
                header("Location: " . BASE_URL . "/inc/reset.php?email=" . $email);
                exit();
            } catch (Exception $e) {
                $email_err = "An error occurred while sending the email: " . $mail->ErrorInfo;
            }
        }
    }
}



include './header.php';
?>
<div class="container mt-3">
    <div class="row" style="min-height: 58vh;">
        <div class="col-md-6 d-none d-md-block" style="background-image: url('../images/cover1.jpg'); background-size: cover; background-position: center;"></div>
        <div class="col-md-6 p-5">
            <h2>Reset Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="help-block text-warning"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary m-2" value="Send Code">
                </div>
                <a href="password_reset.php">forgot password?</a>
                <p class="m-2">Back to Login <br> <a href="login.php" class="btn btn-primary">Login</a>.</p>
            </form>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>