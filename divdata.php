<?php

if (isset($_POST['submit']))
{
    session_start();
    require_once('config/database.php');

    $username = $_POST['username'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $gender = $_POST['gender'];
    $s_pref = $_POST['s_pref'];
    $age = $_POST['age'];
    $email = $_POST['email'];

    if (!empty($age) && !is_numeric($age))
    {
        header("Location: profile.php?age=not_num");
        exit();
    }
    $db_username = $_SESSION['username'];
    //getting user creds
    try
    {
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = :username");
        $stmt->execute(array(':username' => $db_username));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($username))
        {
            $username = $row['user_name'];
            //updating the name of the user in interests table
            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt1 = $conn->prepare("UPDATE interests SET user_name = :username WHERE user_name = :user");
                $stmt1->execute(array(':username' => $username, ':user' => $db_username));
            }
            catch(PDOException $e)
            {
                header("Location: profile.php?server=error");
                exit();
            }
        }
        else
        {
            //updating the name of the user in interests table
            try
            {
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt1 = $conn->prepare("UPDATE interests SET user_name = :username WHERE user_name = :user");
                $stmt1->execute(array(':username' => $username, ':user' => $db_username));
            }
            catch(PDOException $e)
            {
                header("Location: profile.php?server=error");
                exit();
            }
        }
        if (empty($first))
        {
            $first = $row['first_name'];
        }
        if (empty($last))
        {
            $last = $row['last_name'];
        }
        if (empty($email))
        {
            $email = $row['email'];
        }
        if (empty($age))
        {
            $age = $row['age'];
        }
        if (empty($gender))
        {
            $gender = $row['gender'];
        }
        if (empty($s_pref))
        {
            $s_pref = $row['s_pref'];
        }

        try
        {
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!empty($row['profilepic']))
            {
                $exploded = explode("/",  $row['profilepic']);
                $new_pic = "pics/".$username."/".end($exploded);
            }

            $sql = "UPDATE users SET profilepic = :pic, user_name = :username, first_name = :first, last_name = :last,
            gender = :gender, s_pref = :s_pref, age = :age, email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(':pic' => $new_pic , ':username' => $username, ':first' => $first, ':last' => $last, 
            ':gender' => $gender, ':s_pref' => $s_pref, ':age' => $age, ':email' => $email));
            
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            

            $dir = "pics/".$db_username;
            if (file_exists($dir))
            {
                rename($dir, "pics/".$username);
            }
            $to = $_SESSION['email'];
            $subject = "Profile Updated";
            $msg = "Hey {$db_username}, your profile has been updated\n\n\n
            If this wasn't you. Call Deadshot 'cause someone needs to die for this. :)";
            $headers = 'From: noreply@matcha.com';
            mail($to, $subject, $msg, $headers);
            header("Location: profile.php?profile_updated");
            exit();
        }
        catch(PDOException $e)
        {
            die($e);
            header("Location: profile.php?server_error");
            exit();
        }
    }
    catch(PDOException $e)
    {
        header("Location: profile.php?server=error");
        exit();
    }
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
    <title>Document</title>
</head>
<body>
    <h3 class="ui header"><i class="settings icon"></i>edit profile</h3>
    <form method="POST" action="divdata.php" class="ui form">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="username">
        </div>
        <div class="field">
            <label>First Name</label>
            <input type="text" name="first" placeholder="First Name">
        </div>
        <div class="field">
        <label>Last Name</label>
            <input type="text" name="last" placeholder="Last Name">
        </div>
        <div class="field">
        <label>Email</label>
            <input type="email" name="email" placeholder="Email">
        </div>
        <div class="field">
            <select name="gender">
                <option name="none" value="">Gender</option>
                <option name="male" value="male">Male</option>
                <option name="female" value="female">Female</option>
                <option name="other" value="other">Other</option>
            </select>
        </div>
        <div class="field">
            <select name="s_pref">
                <option name="none" value="">Sexual Preference</option>
                <option name="male" value="men">Men</option>
                <option name="female" value="women">Women</option>
                <option name="other" value="other">Other</option>
            </select>
        </div>
        <div class="field">
            <label>Age</label>
            <input type="text" name="age" maxlength="2" placeholder="Your age">
        </div>
    <button class="ui primary button" name="submit" type="submit">Save changes</button>
    <button class="ui negative button" formaction="profile.php">Discard</button>
    </form>
</body>
</html>