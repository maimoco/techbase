<!DOCTYPe html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <span style="font-size: 20px;">この夏にしたいことは何ですか？？</span><br>
        <span style="font-size: 20px;">わたしはグランピングしたい！</span>
        <?php
        
        echo "<hr><br>";
        
            //DB接続設定
            $dsn = 'データベース名';
            $user = 'ユーザー名';
            $password = 'パスワード';
            $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            
            $sql = "CREATE TABLE IF NOT EXISTS mission5_1"
            ."("
            ."id INT AUTO_INCREMENT PRIMARY KEY,"
            ."name char(32),"
            ."comment TEXT,"
            ."date char(32),"
            ."password TEXT"
            .");";
            $stmt = $pdo->query($sql);
            
            $newname = "";
            $newcomment = "";
            $edino = "";
            
            if(!empty($_POST["editNo"]) && ($_POST["edipass"])){
                $editNo = $_POST["editNo"];
                $edipass = $_POST["edipass"];
                $id = $editNo;
                
                $sql = 'SELECT * FROM mission5_1 WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $results = $stmt -> fetchAll();
                
                foreach ($results as $row){
                    if($row['id'] == $editNo && $row['password'] == $edipass){
                        $newname = $row['name'];
                        $newcomment = $row['comment'];
                        $edino = $editNo;
                    }
                }
            }
        ?>

        <form action = "" method = "post"><br>
                <input type = "hidden" name = "hensyuu" value = "<?php echo $edino; ?>">
            <label><span style="color:mediumvioletred">入力フォーム</span></label><br>
                <input type = "text" name = "name" placeholder = "名前" value = "<?php echo $newname; ?>"><br>
                <input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $newcomment; ?>"><br>
                <input type = "text" name = "password" placeholder = "password"><br>
                <input type = "submit" value = "送信"><br>
    <br>
            <label><span style="color:deepskyblue">削除フォーム</span></label><br>
                <input type = "text" name = "delete" placeholder = "削除対象番号"><br>
                <input type = "text" name = "delpass" placeholder = "password"><br>
                <input type = "submit" name = "delsubmit" value = "削除"><br>
    <br>
            <label><span style="color:limegreen">編集フォーム</span></label><br>
                <input type = "text" name = "editNo" placeholder = "編集対象番号" ><br>
                <input type = "text" name = "edipass" placeholder = "password"><br>
                <input type = "submit" name = "edisubmit" value = "編集"><br>
    <br>
        </form>
        
    <?php
        $date=date("Y年m月d日 H時i分s秒");
        
        //変数が削除フォームにセットされているとき実行
        if(!empty($_POST["delete"]) && !empty($_POST["delpass"])){
            $delete = $_POST["delete"];
            $delpass = $_POST["delpass"];
            $id = $delete;
            $sql = 'SELECT * FROM mission5_1 WHERE id=:id';
            $stmt = $pdo ->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt -> fetchAll();
            foreach($results as $row){
                if($row['id'] == $delete  && $row['password'] == $delpass){
                    $sql = 'delete from mission5_1 WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            $sql = 'SELECT * FROM mission5_1';
            $stmt = $pdo ->query($sql);
            $results = $stmt -> fetchAll();
            foreach($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            echo "<hr>";
            }
        
            
            //編集対象番号を送信
        }elseif(!empty($_POST["hensyuu"]) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
                $name = ($_POST["name"]);
                $com = ($_POST["comment"]);
                $editNo = ($_POST["hensyuu"]);
                $pass = ($_POST["password"]);
                $date=date("Y年m月d日 H時i分s秒");
                //変更したい登録番号
                $id = $editNo;
                $sql = 'UPDATE mission5_1 SET name=:name,comment=:comment, date=:date, password=:password WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $com, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
                $stmt->execute();
                $sql = 'SELECT * FROM mission5_1';
                $stmt = $pdo ->query($sql);
                $results = $stmt -> fetchAll();
                foreach($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['date'].'<br>';
                echo "<hr>";
                }
        
         //入力フォームに書き込みがあるとき出力
        }elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
            $sql = $pdo -> prepare("INSERT INTO mission5_1(name, comment, password, date) VALUES(:name, :comment, :password, :date)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindparam(':comment', $com, PDO::PARAM_STR);
            $sql -> bindparam(':password', $password, PDO::PARAM_STR);
            $sql -> bindparam(':date', $date, PDO::PARAM_STR);
            $name = ($_POST["name"]);
            $com = ($_POST["comment"]);
            $password = ($_POST["password"]);
            $date = date("Y年m月d日 H時i分s秒");
            $sql->execute();
            $sql = 'SELECT * FROM mission5_1';
            $stmt = $pdo ->query($sql);
            $results = $stmt -> fetchAll();
            foreach($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            echo "<hr>";
            }
            
        }else{
            $sql = 'SELECT * FROM mission5_1';
            $stmt = $pdo ->query($sql);
            $results = $stmt -> fetchAll();
            foreach($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            }
        }
        
        
    ?>
        
    </body>
</html>