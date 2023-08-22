<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-02</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="comment" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
   
    <?php
    if(!empty($_POST["name"]) && !empty($_POST["comment"])){
        
     $filename="mission3-02.txt";
     
     if(file_exists($filename)){
             $lines = file($filename,FILE_IGNORE_NEW_LINES);
             $lastpostcount=count($lines);
     }
     
     $name=$_POST["name"];
     $comment=$_POST["comment"];
     $postcount=$lastpostcount+1;
     $postdate=date("Ymd H:i:s");
     
     $connect=$postcount."<>".$name."<>".$comment."<>".$postdate;
    
    $filename="mission3-02.txt";
    $fp=fopen($filename,"a");
    fwrite($fp,$connect.PHP_EOL);
    fclose($fp);
    
    if(file_exists($filename)){
         $lines = file($filename,FILE_IGNORE_NEW_LINES);
        foreach($lines as $line){
            $pieces=explode("<>",$line);
             echo $pieces[0].$pieces[1].$pieces[2].$pieces[3]."<br>";
    
        }
    }
    }
    ?>
</body>
</html>