<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_2-4</title>
    </head>
    <body>
        <form action = "" method = "post">
            <input type = "text" name = "str" placeholder = "コメント">
            <input type = "submit" name = "submit" value = "送信">
        </form>
        <?php
          if(!empty($_POST["str"])){
              $str = $_POST["str"];
              $filename = "mission_2-4.txt";
              $fp = fopen($filename, "a");
              fwrite($fp, $str.PHP_EOL);
              fclose($fp);
              
              if(file_exists($filename)){
                  $lines = file($filename, FILE_IGNORE_NEW_LINES);
                  foreach($lines as $line){
                      echo $line."<br>";
                  }
              }
          }
        ?>
    </body>
</html>