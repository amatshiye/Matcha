<?php


    require_once('config/database.php');
    session_start();

    $interests = serialize($_POST);

    if (!empty($interests))
    {
        $username = $_SESSION['username'];
        try
        {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM interests WHERE user_name = :username");
            $stmt->execute(array(':username' => $username));
            $results = $stmt->fetchAll();

            if (count($results) >= 1)
            {
                try
                {
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("UPDATE interests SET interests = :interests WHERE user_name = :username");
                    $stmt->execute(array(':interests' => $interests));
                                
                    header("Location: profile.php?interests=updated");
                    exit();
                }
                catch(PDOException $e)
                {
                    
                    header("Location: profile.php?server=error");
                    exit();
                }
            }
            else
            {
                die("It diead here");
                try
                {
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("INSERT INTO interests (user_name, interests)
                    VALUES(:username, :interests)");                    
                    $stmt->execute(array(':username' => $username, ':interests' => $interests));
                    header("Location: profile.php?interests=updated");
                    exit();
                }
                catch(PDOException $e)
                {
                    header("Location: profile.php?server=error");
                    exit();
                }
            }
        }
        catch(PDOException $e)
        {
            header("Location: profile.php?server_error");
            exit();
        }
    }
    else
    {
        header("Location: profile.php?none");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>interests</title>
</head>
<body>
    <h3><i class="heart icon"></i>your interests</h3>
    <div class="ui message">
        <div class="header">
            Note
        </div>
        <p>
            Updating your interests will erase all of your current interests.
            If there are interests you'd like to keep, just re-check them.
        </p>
    </div>
    <form class="ui form" action="interests.php" method="POST">    
        <div class="ui checkbox">
            <input name="tech" value="tech" type="checkbox">
            <label>tech </label>
        </div>
        <div class="ui checkbox">
            <input name="traveling" value="traveling" type="checkbox">
            <label>traveling</label>
        </div><div class="ui checkbox">
            <input name="partying" value="partying" type="checkbox">
            <label>partying</label>
        </div><br>
        <div class="ui checkbox">
            <input name="sports" value="sports" type="checkbox">
            <label>sports</label>
        </div>
        <div class="ui checkbox">
            <input name="books" value="books" type="checkbox">
            <label>books</label>
        </div>
        <div class="ui checkbox">
            <input name="painting" value="painting" type="checkbox">
            <label>painting</label>
        </div><br>
        <div class="ui checkbox">
            <input name="dancing" value="dancing" type="checkbox">
            <label>dancing</label>
        </div>
        <div class="ui checkbox">
            <input name="writting" value="writting" type="checkbox">
            <label>writting</label>
        </div>
        <div class="ui checkbox">
            <input name="gardening" value="gardening" type="checkbox">
            <label>gardening</label>
        </div><br>
        <div class="ui checkbox">
            <input name="animals" value="animals" type="checkbox">
            <label>animals</label>
        </div>
        <br><br><button name="submit" class="ui pink button">save interests</button>
    </form>
    
</body>
</html>