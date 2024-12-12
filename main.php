<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        include "actions/config.php";
        header("Refresh:". $refreshRate ."");
        
        if (isset($_POST["captcha"])) {
            if ($_POST["captcha"] !=  $_SESSION["captcha"]) {
                session_destroy();
                header("Location: index.php?err");
                die();
            } else {
                $_SESSION["username"] = $_POST["name"];
                $_SESSION["verify"] = true;
            }
        } elseif (isset($_SESSION["verify"])) {
            if ($_SESSION["verify"] != true) {
                session_destroy();
                header("Location: index.php?err");
                die();
            }
        } else {
            session_destroy();
            header("Location: index.php?err");
            die();
        }
    ?>

    <div class="area">
        <div class="top"><p>Welcome <b><?php echo $_SESSION["username"]; ?></b></p> <a href="actions/logout.php"><button class="button">Logout</button></a></div>
        
        <div class="container">
            <?php
                $db = new mysqli($dbServer, $dbLogin, $dbPassword, $dbName);

                if ($db->connect_error) {
                    session_destroy();
                    header("Location: index.php");
                    die();
                }
                
                $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $maxPosts";
                $data = $db->query($sql);
                $db->close();
                $toRender = "";

                if ($data->num_rows > 0) {
                    while($row = $data->fetch_assoc()) {
                        $toRender .= '
                        <div class="post">
                            <h1>'. $row["created_at"].'</h1>
                            <h2>'. $row["owner"].':</h2>
                            <p>'. $row["content"].'</p>
                        </div>
                        ';
                    }
                }

                echo $toRender;
            ?>
        </div>

        <div class="editor">
            <form action="actions/createPost.php" method="POST">
                <textarea class="textarea" name="chatInput" placeholder="Say something..."></textarea>
                <input type="submit" class="button">
            </form>
        </div>
    </div>
</body>
</html>