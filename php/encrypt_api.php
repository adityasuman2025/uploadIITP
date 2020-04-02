<?php
    include_once 'encrypt.php';

    if(isset($_POST['text']) && isset($_POST['action']))
    {
        $text = $_POST['text'];
        $action = $_POST['action'];

        if($action == "decrypt" || $action == "encrypt")
            echo encrypt_decrypt($action, $text);
        else
            echo 0;
    }
    else
    {
        echo 0;
    }
?>
