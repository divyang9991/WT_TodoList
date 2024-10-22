<?php require("connection.php");

session_start();
$query = "SELECT * FROM register_user";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>User -To_Do_List</title>
   </head>
   <body>
        <header><h2 style="color:black;">Welcome to To Do List Page</h2></header>
        <nav>
            <a href="#">HOME</a>
            <a href="#">BLOG</a>
            <a href="#">CONTANT</a>
            <a href="#">ABOUT</a>
        </nav>
        <div class="sign-in-up">
            <button type="button" class="sign-in-up" onclick="popup('login-popup')">LOGIN</button>
            <button type="button" class="sign-in-up" onclick="popup('register-popup')">REGISTER</button>
        </div>

        <!-- Login Popup -->
        <div class="popup-container" id="login-popup">
            <div class="popup">
                <form method="POST" action="login.php" onsubmit="return validateLoginForm()">
                    <h2>
                    <span>USER LOGIN</span>
                    <button type="reset" onclick="popup('login-popup')">X</button>
                    </h2>
                    <input type="text" placeholder="E-mail or Username" name="email_username" id="login_email">
                    <input type="password" placeholder="Password" name="password" id="login_password">
                    <button type="submit" class="login_btn" name="login">LOGIN</button>
                </form>
                <div class="forget-btn" style="text-align:right;">
                    <!-- Forgot Password Button -->
                    <button type="button" style="outline: none; border: none; background-color: transparent; font-weight:450;" onclick="showForgotPassword()">Forget Password?</button>
                </div>
            </div>
        </div>

        <!-- Register Popup -->
        <div class="popup-container" id="register-popup">
            <div class="register popup">
                <form method="POST" action="register.php" onsubmit="return validateRegisterForm()">
                    <h2>
                    <span>USER REGISTER</span>
                    <button type="reset" onclick="popup('register-popup')">X</button>
                    </h2>
                    <input type="text" placeholder="Full Name" name="full_name" id="full_name">
                    <input type="text" placeholder="Username" name="username" id="username">
                    <input type="email" placeholder="Email" name="email_username" id="register_email">
                    <input type="password" placeholder="Password" name="password" id="register_password">
                    <button type="submit" class="Register_btn" name="register">REGISTER</button>
                </form>
            </div>
        </div>

        <!-- Forgot Password Popup -->
        <div class="popup-container" id="forgot-popup">
            <div class="popup">
                <form method="POST" action="forgot_password.php" onsubmit="return validateForgotPasswordForm()">
                    <h2>
                    <span>FORGOT PASSWORD</span>
                    <button type="reset" onclick="popup('forgot-popup')">X</button>
                    </h2>
                    <input type="email" placeholder="Enter your registered email" name="email" id="forgot_email">
                   <button type="submit" class="forgot_btn" name="forgot_password" style="outline: none; border: none; background-color: transparent; font-weight:450;">SEND LINK</button>
                </form>
            </div>
        </div>

        <script>
            function popup(popup_name) {
                let get_popup = document.getElementById(popup_name);
                if (get_popup.style.display === "flex") {
                    get_popup.style.display = "none";
                } else {
                    get_popup.style.display = "flex";
                }
            }
            function showForgotPassword() {
                document.getElementById('login-popup').style.display = 'none';
                document.getElementById('forgot-popup').style.display = 'flex';
            }
            function validateRegisterForm() {
                var fullName = document.getElementById('full_name').value;
                var username = document.getElementById('username').value;
                var email = document.getElementById('register_email').value;
                var password = document.getElementById('register_password').value;

                if (fullName === "" || username === "" || email === "" || password === "") {
                    alert("Please fill in all fields.");
                    return false;
                }
                
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return false;
                }
            }

            function validateLoginForm(){
                var emailUsername = document.getElementById('login_email').value;
                var password = document.getElementById('login_password').value;

                if (emailUsername === "" || password === "") {
                    alert("Please enter both email/username and password.");
                    return false;
                }
                return true;
            }

            function validateForgotPasswordForm(){
                var email = document.getElementById('forgot_email').value;

                if (email === "") {
                    alert("Please enter your registered email.");
                    return false;
                }

                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return false;
                }

                return true;
            }

            <?php if (isset($_GET['message'])): ?>
                var message = "<?php echo $_GET['message']; ?>";
                if (message == "registered_successfully") {
                    alert("Registration successful!");
                } else if (message == "exists") {
                    alert("Username or Email already exists. Please try again with different credentials.");
                } else if (message == "error") {
                    alert("An error occurred during registration. Please try again.");
                } else if (message == "login_success") {
                    alert("Login successful!");
                } else if (message == "incorrect_password") {
                    alert("Incorrect password. Please try again.");
                } else if (message == "user_not_found") {
                    alert("User not found. Please check your credentials.");
                } else if (message == "logout_success") {
                    alert("You have logged out successfully.");
                } else if (message == "forgot_success") {
                    alert("Password reset link has been sent to your email.");
                }
            <?php endif; ?>
        </script>
    </body>
</html>