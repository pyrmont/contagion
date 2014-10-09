<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<title>Zedtown - List of Infected</title>

<link rel="stylesheet" href="/stylesheets/normalize.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/stylesheets/zedtown.css" type="text/css" media="screen" />

</head>
<body>

    <a href="/"><img src="images/logo.png"></a>

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

    <table id="list">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($players as $player) { ?>
            <tr class="<?php echo $player['status'] ?>">
                <td class"number"><?php echo $player['number'] ?></td>
                <td class="name"><?php echo $player['name'] ?></td>
                <td class="status"><?php echo $player['status'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>