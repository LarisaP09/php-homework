<?php
require_once "./register.php";
include 'd:\laragon\www\proiect php\navigation\navigation.php'
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
                <h2>Sign Up</h2>
                <p>Please fill this form to create an account.</p>
            <div class="contact-box">
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter username">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>  

                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter last name">
                        <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                    </div> 

                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter first name">
                        <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                    </div> 

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter email">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter password">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" class="btn btn-secondary" value="Submit">
                    </div>
                    <p>Already have an account? <a href="login_form.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'd:\laragon\www\proiect php\navigation\footer.php' ?>
