<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-05</title>
</head>
<body>
    
    
    <?php
    //投稿フォーム
    
    //投稿番号と編集対象番号を比較して、等しい場合は、ファイルに書き込む内容を送信内容に差し替える
    //上記テキストボックス内が空かどうか確認する
    //空でないときは、テキストファイルの中身を取り出し、各行の投稿番号を比較
    if(!empty($_POST["edit-hidden_num"])){
        $filename_front="mission3-05_front.txt";
        $filename_back="mission3-05_back.txt";
        
        //filename_front
        if(file_exists($filename_front)){
        //ファイルの中身を一行一要素として配列に代入する
         $lines_front = file($filename_front,FILE_IGNORE_NEW_LINES);

         //ファイルを開く
         $fp_front_w=fopen($filename_front,"w");
         
            //ファイルの行数だけループさせる
            foreach($lines_front as $line_front){
                //区切り文字で分割してそれぞれの値を取得
                $pieces=explode("<>",$line_front);
            
                //投稿番号を取得
                $num=$pieces[0];
                $edit_hidden_num=$_POST["edit-hidden_num"];
                $password=$pieces[4];
                $edit_hidden_password=$_POST["edit-hidden_password"];
                
                
                    //投稿番号と編集対象番号が一致しない場合書き込む
                    if($num!=$edit_hidden_num){
                       
                        $filename_front="mission3-05_front.txt";
                        
                        fwrite($fp_front_w,$line_front.PHP_EOL); 
                      
                    }
                    
                    //一致した時のみ、編集のフォームから送信された値と差し替える
                    elseif($num==$edit_hidden_num&&$password==$edit_hidden_password){
                         $post_name=$_POST["name"];
                         $post_comment=$_POST["comment"];
                         $post_date=date("Y/m/d H:i:s");
                         
                         $connect=$edit_hidden_num."<>".$post_name."<>".$post_comment."<>".$post_date."<>".$edit_hidden_password;
                         
                         fwrite($fp_front_w,$connect.PHP_EOL);
                         echo "編集成功<br>";
                    }
            }
        
            fclose($fp_front_w);    
        }
        
        //filename_back
        if(file_exists($filename_back)){
        //ファイルの中身を一行一要素として配列に代入する
         $lines_back = file($filename_back,FILE_IGNORE_NEW_LINES);

         //ファイルを開く
         $fp_back_w=fopen($filename_back,"w");
            
            //ファイルの行数だけループさせる
            foreach($lines_back as $line_back){
                //区切り文字で分割してそれぞれの値を取得
                $pieces=explode("<>",$line_back);
            
                //投稿番号を取得
                $num=$pieces[0];
                $edit_hidden_num=$_POST["edit-hidden_num"];
                $password=$pieces[4];
                $edit_hidden_password=$_POST["edit-hidden_password"];
                
                
                    //投稿番号と編集対象番号が一致しない場合書き込む
                    if($num!=$edit_hidden_num){
                       
                        $filename_back="mission3-05_back.txt";
                        
                        fwrite($fp_back_w,$line_back.PHP_EOL); 
                    }
                    
                    //一致した時のみ、編集のフォームから送信された値と差し替える
                    elseif($num==$edit_hidden_num&&$password==$edit_hidden_password){
                         $post_name=$_POST["name"];
                         $post_comment=$_POST["comment"];
                         $post_date=date("Y/m/d H:i:s");
                         
                         $connect=$edit_hidden_num."<>".$post_name."<>".$post_comment."<>".$post_date."<>".$edit_hidden_password;
                         
                         fwrite($fp_back_w,$connect.PHP_EOL);
                        
                    }
            }
        
            fclose($fp_back_w);    
        } 
    } 
    
    //空のときは、通常の新規投稿として扱われるようにする。
    elseif(empty($_POST["edit-hidden_num"])){
        if(!empty($_POST["name"]) && !empty($_POST["comment"])){
            $filename_front="mission3-05_front.txt";
            $filename_back="mission3-05_back.txt";
            $fp_front_a=fopen($filename_front,"a");
            $fp_back_a=fopen($filename_back,"a");
        
            if(file_exists($filename_back)){
                $lines_back = file($filename_back,FILE_IGNORE_NEW_LINES);
                $last_postcount=count($lines_back);
            }
            
     
            $post_name=$_POST["name"];
            $post_comment=$_POST["comment"];
            $post_count=$last_postcount+1;
            $post_date=date("Y/m/d H:i:s");
            $post_password=$_POST["post_password"];
                    
                    //新規投稿時にパスワードを保存するように改修する
             $connect=$post_count."<>".$post_name."<>".$post_comment."<>".$post_date."<>".$post_password;
    
            fwrite($fp_front_a,$connect.PHP_EOL);
            fclose($fp_front_a);
           
            fwrite($fp_back_a,$connect.PHP_EOL);
            fclose($fp_back_a);
            echo "投稿成功<br>";
            
        }
       

    }
    
    ?>
    
    
    
    <?php
    //削除フォーム
    if(!empty($_POST["delete_num"])){
        $filename_front="mission3-05_front.txt";
      
        if(file_exists($filename_front)){
        //ファイルの中身を一行一要素として配列に代入する
         $lines_front = file($filename_front,FILE_IGNORE_NEW_LINES);

         //ファイルを開く
         $fp_front_w=fopen($filename_front,"w");
            
            //ファイルの行数だけループさせる
            foreach($lines_front as $line_front){
                //区切り文字で分割してそれぞれの値を取得
                $pieces=explode("<>",$line_front);
            
                //投稿番号を取得
                $num=$pieces[0];
                $delete_num=$_POST["delete_num"];
                $password=$pieces[4];
                $delete_password=$_POST["delete_password"];
                
                    //投稿番号と削除対象番号が一致しない場合書き込む
                    if($num!=$delete_num){
                        //$connect2=$pieces[0]."<>".$pieces[1]."<>".$pieces[2]."<>".$pieces[3];
                        $filename_front="mission3-05_front.txt";
                        
                        fwrite($fp_front_w,$line_front.PHP_EOL);
                    }
                    elseif($num==$delete_num && $password!=$delete_password){
                        $filename_front="mission3-05_front.txt";
                        
                        fwrite($fp_front_w,$line_front.PHP_EOL);
                        echo "削除成功<br>";
                    }
                    
            }
        //ファイルを閉じる
        fclose($fp_front_w);
        }
    }
    ?>
    
    <?php
    //編集フォーム
    if(!empty($_POST["edit_num"])&&!empty($_POST["edit_password"])){
        $filename_front="mission3-05_front.txt";
       
        
        //POST送信で「編集対象番号」を送信
        $edit_num=$_POST["edit_num"];
        $edit_password=$_POST["edit_password"];
        
      
        if(file_exists($filename_front)){
           //ファイルの中身を一行一要素として配列に代入する
            $lines_front = file($filename_front,FILE_IGNORE_NEW_LINES);
           //ファイルを開く
            $fp_front_a=fopen($filename_front,"a");
           
                //ファイルの行数だけループさせる
                foreach($lines_front as $line_front){
                    //区切り文字で分割してそれぞれの値を取得
                    $pieces=explode("<>",$line_front);
            
                    //投稿番号を取得
                    $num=$pieces[0];
                
                       //投稿番号と編集対象番号を比較
                       //イコールの場合はその投稿の「名前」と「コメント」を取得
                        if($num==$edit_num){
                            $edit_name=$pieces[1];
                            $edit_comment=$pieces[2];
                            $message="パスワードは入力しないでください";
                        }
                }
            
            //ファイルを閉じる
            fclose($fp_front_a);
        
        }
              
    }
    ?>
   
   
     <form action="" method="post">
        <!-- 提出フォーム-->
        【投稿フォーム】<br>
        名前：　　
        <input type="text" name="name"　 value= "<?php if(!empty($edit_name)){echo $edit_name;}?>" ><br>
        コメント：
        <input type="text" name="comment"  value= "<?php if(!empty($edit_comment)){echo $edit_comment;}?>" ><br>
         <!--新規投稿フォームに「パスワード」の入力欄を追加-->
        パスワード：
        <input type="password" name="post_password" ><br>
        <?php if(!empty($message)){echo $message."<br>";} ?>
        <!--フォーム内に新しい項目（テキストボックス※）を用意して、そこに編集したい投稿番号が表示される状態にしておこう-->
        <input type="hidden" name="edit-hidden_num" value="<?php if(!empty($edit_num)){echo $edit_num;}?>" >
        <input type="hidden" name="edit-hidden_password" value="<?php if(!empty($edit_password)){echo $edit_password;}?>">
        <input type="submit" name="submit"><br>
       <!-- 削除フォーム-->
       【削除フォーム】<br>
       投稿番号：
        <input type="text" name="delete_num" ><br>
        <!--削除フォームに「パスワード」の入力欄を追加する-->
       パスワード：
        <input type="password" name="delete_password" ><br>
        <input type="submit" name="delete" ><br>
        <!--編集フォーム-->
        【編集フォーム】<br>
        投稿番号：
        <input type="text" name="edit_num" ><br>
        <!--削除フォームと編集フォームにも「パスワード」の入力欄を追加する-->
        パスワード：
        <input type="password" name="edit_password" ><br>
        <input type="submit" name="edit"><br>
        
    </form>
    
     _______________________________________________________________________<br>
    【投稿一覧】<br>
    
    <?php
    //投稿表示
    $filename_front="mission3-05_front.txt";
    if(file_exists($filename_front)){
         $lines_front = file($filename_front,FILE_IGNORE_NEW_LINES);
        foreach($lines_front as $line_front){
            $pieces=explode("<>",$line_front);
            echo $pieces[0].". ".$pieces[1]." "."[".$pieces[2]."]"." ".$pieces[3]."<br>";
    
        }
    }
    ?>
    
</body>
</html>