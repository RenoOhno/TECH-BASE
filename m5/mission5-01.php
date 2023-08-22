<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
    
    
    <?php
    //データベース名・ユーザー名・パスワード
    $dsn = 'mysql:dbname=データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    //MySQLのデータベース接続・PDOのエラーレポートを表示
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest_2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    . "password char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
   
    //投稿フォーム
    
    //投稿番号と編集対象番号を比較して、等しい場合は、ファイルに書き込む内容を送信内容に差し替える
    //上記テキストボックス内が空かどうか確認する
    //空でないときは、テキストファイルの中身を取り出し、各行の投稿番号を比較
    if(!empty($_POST["edit-hidden_num"])){
       if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){

            $id = $_POST["edit-hidden_num"]; //変更する投稿番号
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date=date("Y-m-d H:i:s");
            $password=$_POST["password"];
                    
                     
           $sql = 'UPDATE tbtest_2 SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':name', $name, PDO::PARAM_STR);
           $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
           $stmt->bindParam(':date', $date, PDO::PARAM_STR);
           $stmt->bindParam(':password', $password, PDO::PARAM_STR);
           $stmt->bindParam(':id', $id, PDO::PARAM_INT);
           $stmt->execute();
       }
    } 
    
    //空のときは、通常の新規投稿として扱われるようにする。
    elseif(empty($_POST["edit-hidden_num"])){
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
                    
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $date=date("Y-m-d H:i:s");
                    $password=$_POST["password"];
                    
                    echo $name.$comment.$date.$password;
                    //投稿内容をデータベースに書き込む
                     $sql = "INSERT INTO tbtest_2 (name, comment, date, password) VALUES (:name, :comment, :date, :password)";
                     $stmt = $pdo->prepare($sql);
                     $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                     $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                     $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                     $stmt->bindParam(':password' , $password, PDO::PARAM_STR);
                     $stmt->execute();
                   
    
                    echo "書き込み成功<br>";
            
        }
    }
    
    ?>
    
    
    
    <?php
    //削除フォーム
    if(!empty($_POST["delete_num"])&& !empty($_POST["delete_password"])){
        
        //削除対象の投稿のパスワードを取得
        $id = $_POST["delete_num"];
        $sql = 'SELECT * FROM tbtest_2 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        $password=$row['password'];
        }
        
        //パスワードが一致しているかを確認する
        if($password==$_POST["delete_password"]){
            echo "削除を実行します";
        //削除対象の投稿を削除
        $id = $_POST["delete_num"];
        $sql = 'delete from tbtest_2 where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        }
    }
    ?>
    
    <?php
    //編集フォーム
    if(!empty($_POST["edit_num"])&&!empty($_POST["edit_password"])){
      
        //編集対象の投稿のパスワードを取得
        $id = $_POST["edit_num"];
        $sql = 'SELECT * FROM tbtest_2 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        $name=$row['name'];
        $comment=$row['comment'];
        $edit_password=$row['password'];
        }
        
        if($edit_password==$_POST["edit_password"]){
            $edit_name=$name;
            $edit_comment=$comment;
            $edit_num=$id;
            
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
        <input type="password" name="password" ><br>
        <!--フォーム内に新しい項目（テキストボックス※）を用意して、そこに編集したい投稿番号が表示される状態にしておこう-->
        <input type="hidden" name="edit-hidden_num" value="<?php if(!empty($edit_num)){echo $edit_num;}?>" >
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
    $sql2 = 'SELECT * FROM tbtest_2';
    $stmt2 = $pdo->query($sql2);
    $results = $stmt2->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
    }
    ?>
    
</body>
</html>