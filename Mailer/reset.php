<?php
include './config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL);
    exit();
}

$reset_code = $password = $confirm_password = '';
$reset_code_err = $password_err = $confirm_password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate reset code
    if (empty(trim($_POST["reset_code"]))) {
        $reset_code_err = "Please enter the reset code.";
    } else {
        $reset_code = trim($_POST["reset_code"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
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

    // Check input errors before resetting password
    if (empty($reset_code_err) && empty($password_err) && empty($confirm_password_err)) {
        // Check if reset code exists in database
        $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE reset_code = ?");
        mysqli_stmt_bind_param($stmt, "s", $reset_code);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            $reset_code_err = "Invalid reset code.";
        } else {
            // Update user's password and reset code
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "UPDATE user SET password = ?, reset_code = NULL, reset_timestamp = NULL WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user['id']);
            mysqli_stmt_execute($stmt);

            // Redirect to login page
            header("location: " . BASE_URL . "/inc/login.php");
            exit();
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
                <div class="form-group <?php echo (!empty($reset_code_err)) ? 'has-error' : ''; ?>">
                    <label>Reset Code</label>
                    <input type="text" name="reset_code" class="form-control" value="<?php echo $reset_code; ?>">
                    <span class="help-block text-warning"><?php echo $reset_code_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block text-warning"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block text-warning"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary m-2" value="Reset Password">
                </div>
            </form>
        </div>
    </div>
</div>
<?php include './footer.php'; ?>