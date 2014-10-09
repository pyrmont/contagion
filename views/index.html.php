<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<title>Zedtown - Report Infected</title>

<link rel="stylesheet" href="/stylesheets/normalize.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/stylesheets/zedtown.css" type="text/css" media="screen" />

</head>
<body>

    <a href="http://www.zedtown.com"><img src="images/logo.png"></a>

    <div id="scoreboard">
        <div id="survivors">
            <h2>Survivors</h2>
            <h3><?php echo $num_survivors; ?></h3>
        </div>
        <div id="zombies">
            <h2>Zombies</h2>
            <h3><?php echo $num_zombies ?></h3>
        </div>
    </div>

    <div id="message">
    <?php if ($message == 'infected') { ?>
        <p class="success">Player has been infected and is now a zombie!</p>
    <?php } else if ($message == 'invalid') { ?>
        <p class="error">That wasn't a valid ID. Try again.</p>
    <?php } else if($message == 'already') { ?>
        <p class="error">This player has already been infected!</p>
    <?php } ?>
    </div>

    <div id="instructions">
        <h2>Infection Report</h2>
        <p>Enter the ID of the player who has been infected.</p>
    </div>

    <form action="/submit" method="post" id="report">
        <span><input type="text" id="player_id" name="player_id"></span>
        <input type="submit" value="Report">
    </form>

</body>
</html>