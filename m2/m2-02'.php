<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>m2</title>
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="str" placeholder="コメント">
            <input type="submit" name="submit">
        </form>
        <?php
        if(!empty($_POST["str"])){
            $str = $_POST["str"];
            $filename="m2-2.txt";
            $fp=fopen($filename,"a");
            fwrite($fp,$str.PHP_EOL);
            fclose($fp);
            echo $str."を受け付けました。<br>";
        }
        ?>
    </body>
</html>