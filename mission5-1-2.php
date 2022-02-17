<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <?php
        
        error_reporting(0);
                    $dsn = 'mysql:dbname=***********;host=localhost';
                    $user = '***********';
                    $password = '***********';
                    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
                    $sql = "CREATE TABLE IF NOT EXISTS tbkeijiban1"
                            ." ("
                            . "id INT AUTO_INCREMENT PRIMARY KEY,"
                            . "name char(32),"
                            . "comment TEXT,"
                            ."pass TEXT,"
                            ."comtime TEXT"
                            .");";
                    $stmt = $pdo->query($sql);
    
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $pass = $_POST["pass"];
                    $date=date("Y年m月d日H時i分s秒");
        
        if( isset( $name )  and isset ( $comment ) and $pass != "" and empty( $_POST["hid"]))
                {
                    $sql = $pdo -> prepare("INSERT INTO tbkeijiban1 (name, comment, pass, comtime) VALUES (:name, :comment, :pass, :comtime)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                    $sql -> bindParam(':comtime', $date, PDO::PARAM_STR);
                    $sql -> execute();
                                echo "弾幕は火力だ‼"."<br>"."<br>";
                    
                    if(empty( $name ) or empty( $comment ) or empty( $pass ))
                        {//エラー対策のための条件分岐

                        }
                    elseif($name != "" && $comment != "" && $pass != "")
                        {//条件分岐 (フォーム"str" "name"が空欄=false 投稿削除処理を行った際、この分岐がなければ空欄の行が追加されてしまう)
                            echo $comment." を受け付けました。<br><br>";
                        }
                }
                
            //削除フォーム    
            elseif( isset( $_POST["dnumber"] ) && isset( $_POST["dpass"] ) )
                {
                            $dnumber = $_POST["dnumber"];
                            $dpass = $_POST["dpass"];
                            
                            $sql = 'SELECT * FROM tbkeijiban1';
                            $stmt = $pdo->query($sql);
                            $results = $stmt->fetchAll();

                             foreach ($results as $row)
                                {
                                        if( $row[0] == $dnumber && $row[3] == $dpass )
                                        {
                                        
                                            $id = $dnumber;
                                            $sql = "delete from tbkeijiban1 where id=:id";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                            $stmt->execute();
                                        }
                                        else
                                             {
                                             }

                                }

                }
            //編集フォーム    
            elseif( isset( $_POST["enumber"] ) && isset( $_POST["epass"] ) )
                {
                    echo "編集可能";
                    $enumber = $_POST["enumber"]; 
                    $epass = $_POST["epass"];
                    
                    $sql = 'SELECT * FROM tbkeijiban1';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
                        foreach($results as $row)
                            {
                                    if(  $row[0] == $enumber && $row[3] == $epass )
                                        {
                                          
                                                    $newname = $row[1];
                                                    $newcom = $row[2];
                                                    echo "wer";
                                        }
                                    else
                                    {
                                    
                                    }
                            }
                            
                }
                
            elseif(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["hid"]) && isset($_POST["pass"]))
                {
                    $num2 = $_POST["hid"];
                    $newpass = $_POST["pass"];
                    
                    $sql = 'SELECT * FROM tbkeijiban1';
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
            
                foreach ($results as $row)
                    {
                         if($row[0] == $num2 &&$row[3] = $newpass)
                        {
                            echo "tus";
                            $id = $num2; 
                            $newname2 = $_POST["name"];
                            $newcom2 = $_POST["comment"];
                            $newpass = $_POST["pass"];
                            $sql = 'UPDATE tbkeijiban1 SET name=:name,comment=:comment, pass = :pass, comtime = :comtime WHERE id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':name', $newname2, PDO::PARAM_STR);
                            $stmt->bindParam(':comment', $newcom2, PDO::PARAM_STR);
                            $stmt->bindParam(':pass', $newpass, PDO::PARAM_STR);
                            $stmt->bindParam(':comtime', $date, PDO::PARAM_STR);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    else
                        {
                            
                        }
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
            $sql = 'SELECT * FROM tbkeijiban1';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            
                foreach ($results as $row)
                    {
        //$rowの中にはテーブルのカラム名が入る
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].",";
                    echo $row["pass"].",";
                    echo $row["comtime"].'<br>';
                    echo "<hr>";
                    }
        ?>    
    </body>
</html>
