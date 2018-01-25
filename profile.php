<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Profile</title>
</head>
<body>
    <!--Menu-->
    <div class="ui massive secondary pointing menu">
        <a class="item" href="index.php">
            <i class="home icon"></i> Home
        </a>
        <a class="item active" href="profile.php">
            <i class="user icon"></i> Profile
        </a>
        <a class="item">
            <i class="mail icon"></i> Messages
        </a>

        <div class="right menu">
            <?php
            session_start();
            if (isset($_SESSION['username']))
            {
                echo "
                <a class='ui item'>
                    <i class='alarm icon'></i>Notification
                </a>
                <a class='ui item'>
                    <i class='user icon'></i>".$_SESSION['username']."
                </a>
                <a href='index.php?logout' class='ui item'>
                    <i class='power icon'></i>Logout
                </a>
                ";
            }
            ?>
        </div>
    </div>

    <!--body... for real-->
    <div class="ui three column grid">
        <div class="column">
            <div class="ui segment">

            </div>
        </div>
        <div class="column">
            <div class="ui segment">
                
            </div>
        </div>
        <div class="column">
            <div class="ui segment">
                <div class="ui fluid category search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search...">
                        <i class="search icon"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</body>
</html>