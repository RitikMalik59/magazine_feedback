<?php include "../config/db_connect.php"; ?>
<?php include "./layouts/admin_header.php"; ?>

<?php

$stored_username = 'admin';
$stored_password = password_hash('1234', PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username !== $stored_username) {
        $username_err = 'Please enter valid username !';
    }


    if ($username === $stored_username && password_verify($password, $stored_password)) {
        $_SESSION['username'] = $username;
        redirect('./index.php');
    } else {
        $password_err = "Invalid password !";
    }
}

?>

<h2 class="display-6 text-center mt-5">Admin Login Form</h2>


<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-3">
                <h2>login to your Account</h2>
                <p>Please fill this form to login with us</p>
                <form action="" method="post">

                    <div class="form-group mb-3">
                        <label class="form-label">Username : <sup>*</label>
                        <input type="text" name="username" class="form-control form-control-lg <?php echo $username_err ? 'is-invalid' : ''; ?>" value="<?php echo $username ?? ''; ?>" placeholder="Enter your username" required>
                        <span class="invalid-feedback"><?php echo $username_err ?? ''; ?> <br /></span>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Password : <sup>*</label>
                        <input type="password" name="password" class="form-control form-control-lg <?php echo $password_err ? 'is-invalid' : ''; ?>" placeholder="Enter your password" required>
                        <span class="invalid-feedback"><?php echo $password_err ?? ''; ?> <br /></span>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-grid gap-2">
                            <input type="submit" class="btn btn-success" name="login" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php include APPROOT . "/admin/layouts/admin_footer.php"; ?>