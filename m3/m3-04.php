<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-04</title>
</head>
<body>
    
    
    <?php
    //投稿フォーム
    
    //投稿番号と編集対象番号を比較して、等しい場合は、ファイルに書き込む内容を送信内容に差し替える
    //上記テキストボックス内が空かどうか確認する
    //空でないときは、テキストファイルの中身を取り出し、各行の投稿番号を比較
    if(!empty($_POST["edit-hiddennum"])){
      $filename="mission3-04.txt";
      
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
                $num=$pieces[0];
                $hiddennum=$_POST["edit-hiddennum"];
                
                    //投稿番号と編集対象番号が一致しない場合書き込む
                    if($num!=$hiddennum){
                       
                        $filename="mission3-04.txt";
                        
                        fwrite($fp2,$line.PHP_EOL); 
                    }
                    
                    //一致した時のみ、編集のフォームから送信された値と差し替える
                    elseif($num==$hiddennum){
                         $name=$_POST["name"];
                         $comment=$_POST["comment"];
                         $postdate=date("Y/m/d H:i:s");
                         
                         $connect=$hiddennum."<>".$name."<>".$comment."<>".$postdate;
                         
                         fwrite($fp2,$connect.PHP_EOL);
                         echo "編集成功<br>";
                    }
            }
        
        fclose($fp2);    
        }
    } 
    
    //空のときは、通常の新規投稿として扱われるようにする。
    elseif(empty($_POST["edit-hiddennum"])){
        if(!empty($_POST["name"]) && !empty($_POST["comment"])){
            $filename="mission3-04.txt";
            $fp=fopen($filename,"a");
        
            if(file_exists($filename)){
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $lastpostcount=count($lines);
            
     
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $postcount=$lastpostcount+1;
                    $postdate=date("Y/m/d H:i:s");
     
                    $connect=$postcount."<>".$name."<>".$comment."<>".$postdate;
    
                    fwrite($fp,$connect.PHP_EOL);
                    fclose($fp);
                    echo "書き込み成功<br>";
            }
        }
    }
    
    ?>
    
    
    
    <?php
    //削除フォーム
    if(!empty($_POST["deletenum"])){
        $filename="mission3-04.txt";
      
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
                        $filename="mission3-04.txt";
                        
                        fwrite($fp2,$line.PHP_EOL);
                    }
                    
            }
        //ファイルを閉じる
        fclose($fp2);
        }
    }
    ?>
    
    <?php
    //編集フォーム
    if(!empty($_POST["editnum"])){
        //POST送信で「編集対象番号」を送信
        $editnum=$_POST["editnum"];
        $filename="mission3-04.txt";
      
        if(file_exists($filename)){
        //ファイルの中身を一行一要素として配列に代入する
         $lines = file($filename,FILE_IGNORE_NEW_LINES);
           //ファイルを開く
         $fp=fopen($filename,"a");
           
            //ファイルの行数だけループさせる
            foreach($lines as $line){
                //区切り文字で分割してそれぞれの値を取得
                $pieces=explode("<>",$line);
            
                //投稿番号を取得
                $editnum1=$pieces[0];
                
                    //投稿番号と編集対象番号を比較
                    //イコールの場合はその投稿の「名前」と「コメント」を取得
                    if($editnum1==$editnum){
                        $editname=$pieces[1];
                        $editcomment=$pieces[2];
                    }
            }
        //ファイルを閉じる
        fclose($fp);
        }
                
    }
    ?>
   
    
     <form action="" method="post">
        <!-- 提出フォーム-->
        【投稿フォーム】<br>
        名前：　　
        <input type="text" name="name"　 value= "<?php if(!empty($editname)){echo $editname;}?>" ><br>
        コメント：
        <input type="text" name="comment"  value= "<?php if(!empty($editcomment)){echo $editcomment;}?>" ><br>
        <!--フォーム内に新しい項目（テキストボックス※）を用意して、そこに編集したい投稿番号が表示される状態にしておこう-->
        <input type="hidden" name="edit-hiddennum" value="<?php if(!empty($editnum)){echo $editnum;}?>" >
        <input type="submit" name="submit"><br>
       <!-- 削除フォーム-->
       【削除フォーム】<br>
       投稿番号：
        <input type="text" name="deletenum" ><br>
        <input type="submit" name="delete" ><br>
        <!--編集フォーム-->
        【編集フォーム】<br>
        投稿番号：
        <input type="text" name="editnum" ><br>
        <input type="submit" name="edit"><br>
        
    </form>
    
     _______________________________________________________________________<br>
    【投稿一覧】<br>
    
    <?php
    //投稿表示
    $filename="mission3-04.txt";
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