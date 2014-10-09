<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<title>Zedtown - Authenticate</title>

<link rel="stylesheet" href="/stylesheets/normalize.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/stylesheets/zedtown.css" type="text/css" media="screen" />

</head>
<body>

    <a href="/"><img src="images/logo.png"></a>

    <div id="message">
    <?php if ($message == 'failed') { ?>
        <p class="error">That password was not correct.</p>
    <?php } ?>
    </div>

    <div id="instructions">
        <h2>Authentication Required</h2>
        <p>Enter authentication password.</p>
    </div>

    <form action="/login" method="post" id="login">
        <input type="text" id="password" name="password">
        <input type="submit" value="Authenticate">

        <input type="hidden" name="redirect" value="<?php echo $redirect ?>">
    </form>

</body>
</html>