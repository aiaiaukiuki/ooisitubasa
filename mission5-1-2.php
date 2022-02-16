<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <?php
        
        error_reporting(0);
                    $dsn = 'mysql:dbname=tb2*****db;host=localhost';
                    $user = 'tb-2****5';
                    $password = 'password';
                    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
                    $sql = "CREATE TABLE IF NOT EXISTS tbkeijiban"
                            ." ("
                            . "id INT AUTO_INCREMENT PRIMARY KEY,"
                            . "name char(32),"
                            . "comment TEXT"
                            ."pass TEXT,"
                            ."date"
                            .");";
                    $stmt = $pdo->query($sql);
    
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $pass = $_POST["pass"];
                    $date=date("Y年m月d日H時i分s秒");
        
        if( isset( $name )  and isset ( $comment ) and $pass != "" and empty( $_POST["hid"]))
                {
                    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                    $sql -> execute();
                                echo "弾幕は火力だ‼"."<br>"."<br>";
                }
                
            //削除フォーム    
            elseif( isset( $_POST["dnumber"] ) && isset( $_POST["dpass"] ) )
                {
                            $dnumber = $_POST["dnumber"];
                            $dpass = $_POST["dpass"];
                    if($dnumber = $row[0] && $dpass = $row[3])
                    {
                            $id = $dnumber;
                            $sql = 'delete from tbkeijiban where id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                    }
                }
            //編集フォーム    
            elseif( isset( $_POST["enumber"] ) && isset( $_POST["epass"] ) )
                {
                    echo "aaa";
                    $enumber = $_POST["enumber"]; 
                    $epass = $_POST["epass"];
                    
                        foreach($results as $row)
                            {
                                $liner2=explode("<>",$liner1);
                            
                                
                                    if(  $row[0] == $enumber && $row[3] == $epass )
                                        {
                                          
                                                    $newname = $row[1];
                                                    $newcom = $row[2];
                                        }
                                    else
                                    {
                                    
                                    }
                            }
                            
                }
                
            elseif(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["hid"]) && isset($_POST["pass"]))
                {
                    $newname1 = $_POST["name"];
                    $newcom1 = $_POST["comment"];
                    $newpass = $_POST["pass"];
                    $num2 = $_POST["hid"];
                    
                    if($row[0] = $num2)
                    {
                        $id = $hid; //変更する投稿番号
                        $name = $_POST["name"];
                        $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
                        $sql = 'UPDATE tbkeijiban SET name=:name,comment=:comment WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $newname1, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $newcom1, PDO::PARAM_STR);
                        $stmt->bindParam(':pass', $newpasspass, PDO::PARAM_STR);
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }  
            
        ?>
        文字の打ち込み<br>
        <form action="" method="post">
            
            <input type="text" name="name" placeholder="名前" value="<?php echo $newname ; ?>"><br>
            <input type="text" name="comment" placeholder="コメント" value="<?php echo $newcom ; ?>"><br>
            <input type="text" name="pass" placeholder="Enter the password" value=""><br>
            <input type="hidden" name="hid" value="<?php echo $enumber ; ?>">
            <input type="submit" name="submit" value = "送信"><br><br>
        </form>
            
        <form action="" method="post">
            <input type="number" name="dnumber" placeholder="削除する番号"><br>
            <input type="text" name="dpass" placeholder="Enter the password" value=""><br>
            <input type="submit" name="submit" value = "削除"><br><br>
        </form>
            
        <form action="" method="post">
            <input type="number" name="enumber" placeholder="編集番号指定"><br>
            <input type="text" name="epass" placeholder="Enter the password" value=""><br>
            <input type="submit" name="submit" value = "編集"><br><br>
        </form>
        
        <?php
            $sql = 'SELECT * FROM tbkeijiban';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            
                foreach ($results as $row)
                    {
        //$rowの中にはテーブルのカラム名が入る
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].",";
                    echo $row["pass"].",";
                    echo $row["date"].'<br>';
                    echo "<hr>";
                    }
        ?>    
    </body>
</html>
