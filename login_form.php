<?php
require_once "../php-connection/login.in.php";
include 'd:\laragon\www\proiect php\navigation\navigation.php'
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="input_row">
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>

                <?php if(!empty($login_err)): ?>
                    <div class="alert alert-danger"><?php echo $login_err; ?></div>
                <?php endif; ?>
                <div class="contact-box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" action="../php-connection/log.in.php">
                    
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter username">
                            <?php if(!empty($username_err)): ?>
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            <?php endif; ?>
                        </div>    
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> "placeholder="Enter password">
                            <?php if(!empty($password_err)): ?>
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-secondary" value="Login">
                        </div>
                        <p>Don't have an account? <a href="indexlog.php">Sign up now</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'd:\laragon\www\proiect php\navigation\footer.php' ?>
