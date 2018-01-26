<?php

if (isset($_POST['submit']))
{
    $username = $_POST['username'];
    $first = $_POST['first'];
    $last = $_POST['last'];

    
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
            <select>
                <option value="">Gender</option>
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>
        </div>
        <div class="field">
            <select>
                <option value="">Sexual Preference</option>
                <option value="1">Males</option>
                <option value="0">Females</option>
                <option value="2">Other</option>
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