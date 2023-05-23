<?php

include("../models/register.php");

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.13/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.13/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.13/dist/js/uikit-icons.min.js"></script>
    <title>Register</title>
</head>

<body>
    <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade" uk-height-viewport>
        <div class="uk-width-1-1">
            <div class="uk-container">
                <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                    <div class="uk-width-1-1@m">
                        <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                            <h2 class="uk-card-title uk-text-center">Sign Up</h2>
                            <?php if (!empty($register_err)) {
                                echo '<div class="uk-alert uk-alert-danger">Fill in all the required fields please.</div>';
                            }
                            if (!empty($username_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $username_err . '</div>';
                            }
                            if (!empty($email_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $email_err . '</div>';
                            }
                            if (!empty($password_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $password_err . '</div>';
                            }
                            if (!empty($confirm_password_err)) {
                                echo '<div class="uk-alert uk-alert-danger">' . $confirm_password_err . '</div>';
                            }
                            ?>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                                        <input type="text" name="username" class="uk-input uk-form-large uk-text-default <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Username">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                        <input type="email" name="email" class="uk-input uk-form-large uk-text-default <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Email">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                        <input type="password" name="password" class="uk-input uk-form-large uk-text-default <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-inline uk-width-1-1">
                                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                        <input type="password" name="confirm_password" class="uk-input uk-form-large uk-text-default <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm password">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <input type="submit" class="uk-button uk-button-primary uk-button-large uk-width-1-1" value="Register">
                                </div>
                                <div class="uk-text-small uk-text-center">
                                    Already have an account? <a href="login_page.php">Login here</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>