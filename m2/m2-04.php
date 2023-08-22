<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-04</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str" placeholder="完成を祝ってください！">
        <input type="submit" name="submit">
    </form>
    <?php
    if(!empty($_POST["str"])){
     $str=$_POST["str"];
    echo $str."を受け付けました<br><br>";
    $filename="mission2-04.txt";
    $fp=fopen($filename,"a");
    fwrite($fp,$str.PHP_EOL);
    fclose($fp);
    if($str=="完成しました"){
        echo"おめでとう！<br><br>";
    }
    else{
        echo"書き込み成功！<br><br>";
    }
    
         if(file_exists($filename)){
             $lines = file($filename,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
             foreach($lines as $line){
                echo $line . "<br>";
            }
         }
    }
    ?>
</body>
</html>