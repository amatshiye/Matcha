<?php
    require_once('../config/database.php');
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
                    $stmt->execute(array(':interests' => $interests, ':username' => $username));
                                
                    header("Location: ../profile.php?interests=updated");
                    exit();
                }
                catch(PDOException $e)
                {
                    die($e);
                    header("Location: ../profile.php?server=error");
                    exit();
                }
            }
            else
            {
                try
                {
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("INSERT INTO interests (user_name, interests)
                    VALUES(:username, :interests)");                    
                    $stmt->execute(array(':username' => $username, ':interests' => $interests));
                    header("Location: ../profile.php?interests=updated");
                    exit();
                }
                catch(PDOException $e)
                {
                    header("Location: ../profile.php?server=error");
                    exit();
                }
            }
        }
        catch(PDOException $e)
        {
            header("Location: ../profile.php?server_error");
            exit();
        }
    }
    else
    {
        header("Location: ../profile.php?none");
        exit();
    }
?>