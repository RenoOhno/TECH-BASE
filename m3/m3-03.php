<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-03</title>
</head>
<body>
    <form action="" method="post">
        <!-- 提出フォーム-->
        【投稿フォーム】<br>
        名前：　　
        <input type="text" name="name" placeholder="名前"><br>
        コメント：
        <input type="text" name="comment" placeholder="コメント"><br>
        
        <input type="submit" name="submit"><br>
       <!-- 削除フォーム-->
       【削除フォーム】<br>
       投稿番号：
        <input type="text" name="deletenum" placeholder="削除対象番号"><br>
        <input type="submit" name="delete" value="削除"><br>
        
    </form>
   
    <?php
    if(!empty($_POST["name"]) && !empty($_POST["comment"])){
        $filename="mission3-03.txt";
        $fp=fopen($filename,"a");
        
        if(file_exists($filename)){
             $lines = file($filename,FILE_IGNORE_NEW_LINES);
             $lastpostcount=count($lines);
        }
     
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $postcount=$lastpostcount+1;
        $postdate=date("Y/m/d H:i:s");
     
        $connect=$postcount."<>".$name."<>".$comment."<>".$postdate;
    
        fwrite($fp,$connect.PHP_EOL);
        fclose($fp);
        echo "書き込み成功<br>";
    
    }
    ?>
    
    
    _______________________________________________________________________<br>
    【投稿一覧】<br>
    
    <?php
    if(!empty($_POST["deletenum"])){
        $filename="mission3-03.txt";
       
        
        if(file_exists($filename)){
        //ファイルの中身を一行一要素として配列に代入する
         $lines = file($filename,FILE_IGNORE_NEW_LINES);

         //ファイルを開く
         $fp2=fopen($filename,"w");
            
            //ファイルの行数だけループさせる
            foreach($lines as $line){
                //区切り文字で分割してそれぞれの値を取得
                $pieces=explode("<>",$line);
            
                //投稿番号を取得
                $deletenum1=$pieces[0];
                $deletenum=$_POST["deletenum"];
                
                    //投稿番号と削除対象番号が一致しない場合書き込む
                    if($deletenum1!=$deletenum){
                        //$connect2=$pieces[0]."<>".$pieces[1]."<>".$pieces[2]."<>".$pieces[3];
                        $filename="mission3-03.txt";
                        
                        fwrite($fp2,$line.PHP_EOL);
                    }
                    
            }
        }
        //ファイルを閉じる
        fclose($fp2);
    }
    
    $filename="mission3-03.txt";
    if(file_exists($filename)){
         $lines = file($filename,FILE_IGNORE_NEW_LINES);
        foreach($lines as $line){
            $pieces=explode("<>",$line);
            echo $pieces[0].". ".$pieces[1]." "."[".$pieces[2]."]"." ".$pieces[3]."<br>";
    
        }
    }
    ?>
</body>
</html>