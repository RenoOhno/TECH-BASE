<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
  </head>
  <body>
    <?php
      $filename = "mission_3-5_1.txt";
      
      // 投稿機能

      if (!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['password'])) {
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $password = $_POST['password'];
        $postedAt = date("Y年m月d日 H:i:s");

        if (empty($_POST['editNO'])) {
          // 新規投稿
          if (file_exists($filename)) {
            $num = count(file($filename)) + 1;
          } else {
            $num = 1;
          }
          $newdata = $num . "<>" . $name . "<>" . $comment . "<>" . $postedAt. "<>" . $password;
          $fp = fopen($filename, "a");
          fwrite($fp, $newdata . "\n");
          fclose($fp);
        } 
        // 編集機能
        if (!empty($_POST['editNO']) && !empty($_POST['edit_password'])) {
            $editNO = $_POST['editNO'];
            $edit_password = $_POST['edit_password'];
            $edit_name = $_POST['name'];
            $edit_comment = $_POST['comment'];
        
            $ret_array = file($filename);
            $fp = fopen($filename, "w");
        
            foreach ($ret_array as $line) {
                $data = explode("<>", $line);
                if ($data[0] == $editNO && $data[4] == $edit_password) {
                    // 編集対象の行のみ修正して書き込み
                    fwrite($fp, $editNO . "<>" . $edit_name . "<>" . $edit_comment . "<>" . $data[3] . "<>" . $password. "\n");
                } else {
                    // そのまま書き込み
                    fwrite($fp, $line);
                }
            }
            fclose($fp);
        }

      }
      
      // 削除機能

      if (!empty($_POST['dnum']) && !empty($_POST['delete_password'])) {
        $delete = $_POST['dnum'];
        $delete_password = $_POST['delete_password'];

        $delCon = file($filename);
        $fp = fopen($filename, "w");

        foreach ($delCon as $line) {
          $deldata = explode("<>", $line);
          if ($delete !== $deldata[0] || $delete_password !== trim($deldata[4])) {
            fwrite($fp, $line);
          }
        }
        fclose($fp);
      }

      // 編集選択機能

if (!empty($_POST['edit']) && !empty($_POST['edit_password'])) {
    $edit = $_POST['edit'];
    $edit_password = $_POST['edit_password'];
    $editCon = file($filename);

    foreach ($editCon as $line) {
        $editdata = explode("<>", $line);
        if ($edit == $editdata[0] && $edit_password === trim($editdata[4])) {
            $editnumber = $editdata[0];
            $editname = $editdata[1];
            $editcomment = $editdata[2];
            break;
        }
    }
}


    ?>

    <form action="mission_3-5.php" method="post">
      <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname) && isset($_POST['edit'])) { echo $editname; } ?>"><br>
      <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment) && isset($_POST['edit'])) { echo $editcomment; } ?>"><br>
      <input type="hidden" name="editNO" value="<?php if(isset($editnumber)) { echo $editnumber; } ?>">
      <input type="text" name="password" placeholder="パスワード">
      <input type="submit" name="submit" value="送信">
    </form>

    <form action="mission_3-5.php" method="post">
      <input type="number" name="dnum" placeholder="削除対象番号">
      <input type="text" name="delete_password" placeholder="パスワード">
      <input type="submit" name="delete" value="削除">
    </form>

    <form action="mission_3-5.php" method="post">
      <input type="number" name="edit" placeholder="編集対象番号">
      <input type="text" name="edit_password" placeholder="パスワード">
      <input type="submit" value="編集">
    </form>

    <?php
      $filemei = "mission_3-5_1.txt";
      // 表示機能

      if (file_exists($filemei)) {
          $array = file($filemei);

          foreach ($array as $word) {
            $getdata = explode("<>", $word);
            echo $getdata[0] . " " . $getdata[1] . " " . $getdata[2] . " " . $getdata[3] . "<br>";
          }
      }
    ?>
  </body>
</html>