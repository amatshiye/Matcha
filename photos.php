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
    
    <h3 class="ui header"><i class="photo icon"></i>my pictures</h3>
    <?php
    session_start();
    $username = $_SESSION['username'];
    $files = glob("pics/".$username."/*.*");

    for ($i = 0; $i < count($files); $i++)
    {
        $num = $files[$i];
        echo "<img class='ui medium image' src='{$files[$i]}'><br><br>";
    }
?>

</body>
</html>