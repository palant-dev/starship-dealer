<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <?php flash('register_success'); ?>
                    <form action="<?php echo URLROOT; ?>/auth/login" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo URLROOT; ?>/auth/register" class="btn btn-light w-100">No account? Register</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
