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
    <form class="ui form" action="includes/interests.back.php" method="POST">    
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
        <br><br><button name="submit" class="ui black button">save interests</button>
    </form>
    
</body>
</html>