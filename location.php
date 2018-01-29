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

        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
        $stmt->execute(array(':username' => $username));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (isset($_GET['addr']))
        {            
            $location = $_GET['addr'];
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
                        $stmt3 = $conn->prepare("UPDATE users SET location = :location WHERE user_name = :username");
                        $stmt3->execute(array(':location' => $location, ':username' => $username));
                        header("Location: profile.php");
                        exit();
                    }
                    else
                    {
                        $stmt3 = $conn->prepare("INSERT INTO users (location) VALUES(:location)");
                        $stmt3->execute(array(':location' => $location));
                        header("Location: profile.php");
                        exit();
                    }
                    header("Location: profile.php?location_updated");
                    exit();
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
        }
        else if (isset($row['location']) && empty($row['location']))
        {
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
        }
        if (isset($region) && !empty($region))
        {
            echo "<a class='ui label'><i class='map pin icon'></i>Province: {$region}</a><br>";
            echo "<a class='ui label'><i class='map pin icon'></i>City: {$city}</a><br><br>";
            echo "<button onclick='getLocation()' class='ui black button' ><i class='location arrow icon'></i>set location</button>";            
        }
        else
        {
            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt4 = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
                $stmt4->execute(array(':username' => $username));

                $res = $stmt4->fetch(PDO::FETCH_ASSOC);
                echo "<a class='ui label'><i class='map pin icon'></i>Location: {$res['location']}</a><br><br>";
                if (strpos($res['location'], "'") !== true)
                {
                    echo "<button onclick='getLocation()' class='ui black button' ><i class='location arrow icon'></i>set location</button>";
                }
                else
                {
                    die("Bitch");
                }
            }
            catch(PDOException $e)
            {
                header("Location: profile.php?server=error");
                exit();
            }
        }
        ?>
    </form>
    <p id="demo"></p>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.9/semantic.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        function getLocation()
        {
            if ("geolocation" in navigator)
            {
                /* geolocation is available */
                console.log("Found");
                navigator.geolocation.getCurrentPosition(function(position){
                    console.log(position.coords.latitude);
                    console.log(position.coords.longitude);
                    console.log("thamks");
                    axios.get("https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&key=AIzaSyB8UjfDMHZ7bCAg3vVsVQw0LyPvNj2WYU4", {
                    })
                    .then(function(response){
                        console.log("Responding");
                        var addr = response.data.results[2].formatted_address;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                });
                console.log("Getting data...");
            }
            else 
            {
                /* geolocation IS NOT available */
                console.log("You didn't allow the location service");
            }
        }
    </script>
    </body>
    
</html>