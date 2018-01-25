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
        <div id="demo" class="column">
            <div class="ui segment">
            <?php

            require_once('config/database.php');
            $username = $_SESSION['username'];

            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
                $stmt->execute(array(':username' => $username));

                $results = $stmt->fetchAll();

                foreach($results as $row)
                {
                    if (isset($row['profilepic']))
                    {
                        echo "<img class='ui medium circular image' src='{$row["profilepic"]}'><br>";
                        echo "<button onclick='editPic()' class='ui positive button'><i class='image icon'></i>change profile picture</button>
                        <button onclick='showDivMan()' class='ui button'><i class='write icon'></i>edit profile</button>";
                    }
                    else
                    {
                        echo "<img class='ui medium circular image' src=''>";
                    }
                    echo "<br><br>
                    <div class='ui tag red label'>Username: <div class='detail'>{$row["user_name"]}</div></div><br>
                    <div class='ui tag blue label'>First Name: <div class='detail'>{$row["first_name"]}</div></div><br>
                    <div class='ui tag red label'>Last Name: <div class='detail'>{$row["last_name"]}</div></div><br>
                    <div class='ui tag blue label'>Email: <div class='detail'>{$row["email"]}</div></div><br><br>
                    <button onclick='interests()' class='ui black button'><i class='write icon'></i>edit interests</button>";
                    

                }
            }
            catch(PDOException $e)
            {
                header("Location: profile.php?server_error");
            }
            ?>

            </div>
        </div>
        <div class="column">
            <div class="ui segment">
                
            <div id="#summary">This text will be replaced when the onclick event (link is clicked) is triggered.</div>


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.js"></script>
    <script>
    function showDivMan()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("#summary").innerHTML =
            this.responseText;
          }
        };
        xhttp.open("GET", "divdata.php", true);
        xhttp.send();
    }

    function editPic()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("#summary").innerHTML =
            this.responseText;
          }
        };
        xhttp.open("GET", "editpic.php", true);
        xhttp.send();
    }
    </script>
</body>
</html>