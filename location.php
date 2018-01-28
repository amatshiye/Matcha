<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Location</title>
</head>
<body>
    <h3 class="ui header"><i class="street view icon"></i>location settings</h3>
    <form class="ui form" action="location.php" method="POST">
        <?php
        require_once('config/database.php');
        session_start();

        $username = $_SESSION['username'];

        $see = file_get_contents("http://whatstheirip.com");
        $yeah = explode("=", serialize($see));
        $ip = substr($yeah[28], 0, 13);
        $location = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip)), true);
        
        $exploded = explode(",", $location);
        
        foreach($exploded as $key => $value)
        {
            $check = explode("=>", $value);
            foreach($check as $key1)
            {
                $check1 = explode("'", $key1);
                foreach($check1 as $some)
                {
                    if (in_array("geoplugin_city", $check1))
                    {
                        $city = $check[1];
                    }
                    if (in_array("geoplugin_region", $check1))
                    {
                        $region = $check[1];
                    }
                }
            }
        }
        $location = $region.", ".$city;
        try
        {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
            $stmt->execute(array(':username' => $username));
            $results = $stmt->fetchAll();

            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (count($results))
                {
                    $stmt1 = $conn->prepare("UPDATE users SET location = :location WHERE user_name = :username");
                    $stmt1->execute(array(':location' => $location, ':username' => $username));
                }
                else
                {
                    $stmt1 = $conn->prepare("INSERT INTO users (location) VALUES(:location)");
                    $stmt1->execute(array(':location' => $location));
                }
            }
            catch(PDOException $e)
            {
                header("Location: profile.php?server=error");
                exit();
            }
        }
        catch(PDOException $e)
        {
            header("Location: profile.php?server=error");
            exit();
        }
        echo "<a class='ui label'><i class='map pin icon'></i>Province: {$region}</a><br>";
        echo "<a class='ui label'><i class='map pin icon'></i>City: {$city}</a><br><br>";
        ?>
        <button onclick="getLocation()" class="ui purple button" ><i class="location arrow icon"></i>set location</button>
    </form>
    <p id="demo"></p>
    <script>
        alert(0);
        if ("geolocation" in navigator)
        {
            /* geolocation is available */
            console.log("Found");
            navigator.geolocation.getCurrentPosition(function(position){
                console.log(position);
            });
        } 
        else 
        {
            /* geolocation IS NOT available */
            console.log("Fucked");
        }
        function getLocation() 
        {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
        function showPosition(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            console.log(lat);
        }
    </script>
    </body>
    
</html>