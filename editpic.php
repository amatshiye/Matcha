<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3 class="ui header"><i class="image icon"></i>Edit Profile Picture</h3>
    <form class="ui form" action="includes/upload.php" method="POST" enctype="multipart/form-data">
        <img id="pic" class="ui medium circular image" src="">
        <div class="ui input">
            <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
        </div>
        <br><br>
        <button onclick="newPic()" class="ui black button">make profile picture</button>
    </form>
</body>
</html>