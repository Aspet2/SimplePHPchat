<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Chat</title>
</head>
<body>
    <div class="full">
        <form class="center" action="main.php" method="POST">
            <h1>Yep its a chat</h1>
            <label>Nickname</label>

            <input type="text" name="name">
            <img src="actions/captchaGen.php" alt="captcha">

            <label>Captcha</label>
            <input type="text" name="captcha">

            <div class="err">
                <?php
                    if (isset($_GET["err"])) {
                        echo "Wrong captcha or nickname, try again";
                    }
                ?>
            </div>

            <input type="submit">
        </form>
    </div>

</body>
</html>