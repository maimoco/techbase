<!DOCTYPe html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_3-5</title>
    </head>
    <body>
        おすすめのコンビニごはん・スイーツ教えてください！
        <?php
            $newname = "";
            $newcomment = "";
            $edino = "";
            $newpass = "";
                if(!empty($_POST["editNo"]) && ($_POST["edipass"])){
                $editNo = $_POST["editNo"];
                $edipass = ($_POST["edipass"]);
                $filename = "mission_3-5.txt";
                    if(file_exists($filename)){
                        $lines = file($filename, FILE_IGNORE_NEW_LINES);
                         
                        foreach($lines as $line){
                            $edi = explode("<>", $line);
                            if($edi[0] == $editNo && $edi[3] == $edipass){//投稿番号が編集番号の時、名前とコメントを定義
                                //編集用フォームに元の内容を表示
                                $newname = $edi[1];
                                $newcomment = $edi[2];
                                $edino = $edi[0];
                                $newpass = $edi[3];
                                /*
                                $fp = fopen($filename, "a");
                                fwrite($fp, $line.PHP_EOL);
                                fclose($fp);
                                */
                            }
                        }
                    }
                }  
        ?>
        
        
        <form action = "" method = "post"><br>
                <input type = "hidden" name = "hensyuu" value = "<?php echo $edino; ?>">
            <label>入力フォーム</label><br>
                <input type = "text" name = "name" placeholder = "名前" value = "<?php echo $newname; ?>"><br>
                <input type = "text" name = "comment" placeholder = "コメント" value = "<?php echo $newcomment; ?>"><br>
                <input type = "text" name = "password" placeholder = "password" value = "<?php echo $newpass; ?>"><br>
                <input type = "submit" value = "送信"><br>
    <br>
            <label>削除フォーム</label><br>
                <input type = "text" name = "delete" placeholder = "削除対象番号"><br>
                <input type = "text" name = "delpass" placeholder = "password"><br>
                <input type = "submit" name = "delsubmit" value = "削除"><br>
    <br>
            <label>編集フォーム</label><br>
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
                $filename = "mission_3-5.txt";
                if(file_exists($filename)){
                    $lines = file($filename, FILE_IGNORE_NEW_LINES);
                    $fp = fopen($filename, "w");
                    fwrite($fp, "");
                    fclose($fp);

                    foreach($lines as $line){
                        $del = explode("<>", $line);
                        if($del[0] != $delete && $del[3] != $delpass){//削除したい項目と1つ目の項目が一致
                            //ファイルをひらく
                            $fp = fopen($filename, "a");
                            fwrite($fp, $line.PHP_EOL);
                            fclose($fp);
                            
                            list($num, $name, $com, $delpass, $date) = explode("<>", $line);
                            echo $num. $name. $com. $date."<br>";
                            
                            
                            //unset($file[$com]);//一致した行を消す
                            //file_put_contents("mission_3-3.txt", $lines);//更新する
    
                    
                        }
                    }
                }
            }
        ?>
        
        <?php
            $date=date("Y年m月d日 H時i分s秒");
            
            //編集対象番号を送信
            if(!empty($_POST["hensyuu"])){
                $filename = "mission_3-5.txt";

                
                    if(!empty($_POST["name"]) && ($_POST["comment"]) && ($_POST["hensyuu"]) && ($_POST["password"])){

                        $name = ($_POST["name"]);
                        $com = ($_POST["comment"]);
                        $editNo = ($_POST["hensyuu"]);
                        $pass = ($_POST["password"]);
                        
                        if(file_exists($filename)){
                            $lines = file($filename, FILE_IGNORE_NEW_LINES);
                            $fp = fopen($filename, "w");
                            fwrite($fp, "");
                            fclose($fp);
                        
                            foreach($lines as $line){
                                $edi = explode("<>", $line);
                                $fp = fopen($filename, "a");
                                if($edi[0] == $editNo && $edi[3] == $pass){
                                    //投稿番号と編集番号が一致した時上書き
                                    fwrite($fp, "$editNo<>$name<>$com<>$pass<>$date".PHP_EOL);
                                }else{
                                    fwrite($fp, $line.PHP_EOL);
                                }
                                fclose($fp);
                            }
                                    
                            $lines = file($filename, FILE_IGNORE_NEW_LINES);
                            foreach($lines as $line){
                                list($editNo, $name, $com, $pass, $date) = explode("<>", $line);
                                echo $editNo. $name. $com. $date."<br>";
                            }
                        }
                    }
            
            
            
            
            //入力フォームに書き込みがあるとき出力
            }elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
               $name = ($_POST["name"]);
               $com = ($_POST["comment"]);
               $password = ($_POST["password"]);
               $filename = "mission_3-5.txt";
               $fp = fopen($filename, "a");
               
               //ファイルの存在があるとき投稿数＋１、ないとき１を出力
                if(file_exists($filename) && count(file($filename)) >= 1 ){
                    $count = count(file($filename));
                        $lines = file($filename);
                        $lastline = $lines[count(file($filename)) -1];
                        $lists = explode("<>", $lastline);
                        $num = (int)$lists[0] +1;
                    
                }else{
                    $num = 1;
                }
                
               $str = $num."<>".$name."<>".$com."<>".$password."<>".$date;
               fwrite($fp, $str.PHP_EOL);
               fclose($fp);
              
               if(file_exists($filename)){
                   $lines = file($filename, FILE_IGNORE_NEW_LINES);
                   foreach($lines as $line){
                       list($num, $name, $com, $password, $date) = explode("<>", $line);
                       echo $num. $name. $com. $date."<br>";
                   }
               }
            }
        
            
        ?>            
        
    </body>
</html>