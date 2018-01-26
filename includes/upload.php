<?php

session_start();
require_once('../config/database.php');

$upload_dir = "../pics/";
$username = $_SESSION['username'];

if (!file_exists($upload_dir))
{
    mkdir($upload_dir);
}
if (!file_exists($upload_dir.$username))
{
    mkdir($upload_dir.$username);
}

$target_file = $upload_dir.$username."/".basename($_FILES["fileToUpload"]["name"]);
$pic = "pics/".$username."/".basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST['submit']))
{
    $img_size = getimagesize($_FILES["fileToUpload"]['tmp_name']);
    if ($img_size == false)
    {
        //header()
        //exit()
    }
}

if (file_exists($target_file))
{
    //header file exists
    //exit();
}

//checking image size
if ($_FILES["fileToUpload"]["size"] > 500000)
{
    //header file too large
    //exit()
}

//allowing certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
{
    //file type not allowed
    //exit()
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
{
    //upload to database 

    //check if the user hasn't reached 5 pics
    try
    {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("SELECT * FROM pictures WHERE user = :username");
        $stmt->execute(array(':username' => $username));

        $results = $stmt->fetchAll();
        if (count($results) < 5 || count($results) != 5)
        {
            try
            {
                
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("UPDATE users SET profilepic = :pic WHERE user_name = :username");
                $stmt->execute(array(':pic' => $pic, ':username' => $username));

                //uploading pic to pictures table
                try
                {
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $stmt = $conn->prepare("INSERT INTO pictures (name, user)
                    VALUES(:name, :user)");
                    $stmt->execute(array(':name' => $pic, ':user' => $username));
                }
                catch(PDOException $e)
                {
                    header("Location: ../profile.php?server=error");
                    exit();
                }
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
            header("Location: ../profile.php?limit_reached");
            exit();
        }
    }
    catch(PDOException $e)
    {
        header("Location: ../profile.php?server=error");
    }

    header("Location: ../profile.php?upload=success");
    exit();
}

?>