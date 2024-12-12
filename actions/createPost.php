<?php
    session_start();
    if ($_SESSION["verify"] == true) {
        if(isset($_POST["chatInput"]) && $_POST["chatInput"]) {
            include "config.php";

            $postOwner = $_SESSION["username"];
            $postContent = $_POST["chatInput"];

            $regex = '/https?\:\/\/[^\" ]+/i';
            preg_match_all($regex, $postContent, $matches);
        
            for ($i=0; $i < count($matches[0]); $i++) { 
                $founded = $matches[0][$i];
                $parsed = parse_url($founded);
        
                $readyUrl =  ' <a target="_blank" href="'. $founded .'">'. $parsed['host'] . $parsed['path'] . '</a> ';
                $postContent = str_replace($founded, $readyUrl, $postContent);
            }
        

            $db = new mysqli($dbServer, $dbLogin, $dbPassword, $dbName);

            if ($db->connect_error) {
                session_destroy();
                header("Location: ../index.php");
                die();
            }
            
            $sql = "INSERT INTO posts (owner, content)
                    VALUES ('$postOwner', '$postContent')";

            if ($db->query($sql) === TRUE) {
                $db->close();
                header("Location: ../main.php");
            } else {
                session_destroy();
                header("Location: ../index.php");
                die();
            }
        } else {
            header("Location: ../main.php");
            die();
        }
        
    } else {
        session_destroy();
        header("Location: ../index.php");
        die();
    }
?>