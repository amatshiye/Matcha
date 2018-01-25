<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Home</title>
</head>
<body>
    <div class="ui massive secondary pointing menu">
        <a class="item active">
            <i class="home icon"></i> Home
        </a>
        <a class="item" href="profile.php">
            <i class="user icon"></i> Profile
        </a>
        <a class="item">
            <i class="mail icon"></i> Messages
        </a>

        <div class="right menu">
            <a class="ui item">
                <i class="alarm icon"></i> Notification
            </a>
        </div>
    </div>

    <div id="test" onload="hideThis()" class="ui three column grid">
            <div class="column">
                <?php
                if (isset($_GET['verify']) && $_GET['verify'] == 0)
                {
                    echo "
                    <div id='pmsg' class='ui positive message'>
                        <i onclick='closeMsg()' class='close icon'></i>
                        <div class='header'>
                            A varification link has been sent to your account
                        </div>
                    </div>
                    ";
                }
                else if (isset($_GET['signup'])){
                    if ($_GET['signup'] == 'email')
                    {
                        echo "
                        <div id='pmsg' class='ui negative message'>
                            <i onclick='closeMsg()' class='close icon'></i>
                            <div class='header'>
                                This email is already registered.<br>
                                Use a different email or login.
                            </div>
                        </div>
                        ";
                    }
                    else if ($_GET['signup'] == 'username')
                    {
                        echo "
                        <div id='pmsg' class='ui negative message'>
                            <i onclick='closeMsg()' class='close icon'></i>
                            <div class='header'>
                                Username is not available. Try a different one.
                            </div>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
            <div class="column">
                <h3>Sign up</h3>
              <div class="ui segment">

                <form id="form1" class="ui form" action="includes/signup.php" method="post">
                     <div class="field">
                         <label>Username</label>
                         <input  type="text" name="user_name" placeholder="Username">
                     </div>
                     <div class="field">
                        <label>First Name</label>
                        <input  type="text" name="first" placeholder="First Name">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input  type="text" name="last" placeholder="Last Name">
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <input  type="email" name="email" placeholder="Email">
                    </div>
                    <div class="field">
                        <label>Last Name</label>
                        <input  type="password" name="passwd" placeholder="Password">
                    </div>
                    <button name="submit" type="submit" id="button1" class="ui negative button">Sign up</button>
                </form>
            </div>
        </div>
        <div class="column">

        <!--Login part -->
            <h3>Login</h3>
            <div class="ui segment">
            <form id="form2" class="ui form" action="" method="post">
                <div class="field">
                    <label>Username or Email</label>
                    <input type="text" name="login" placeholder="Username/Email">
                </div>
                <div class="field">
                    <label>Last Name</label>
                    <input  type="password" name="passwd" placeholder="Password">
                </div>
                <button formaction="includes/login.inc.php" name="submit" class="ui primary button">Login</button> <button formaction="#" id="forgot" type="popup" class="ui negative button">Forgot password?</button>
            </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="src/styles.js">
    </script>
</body>
</html>