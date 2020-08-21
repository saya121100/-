<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission_5-1</title>
</head>
<body>
        <!--mission_1-20を使う　数値を扱うのでtype="text"からnumberへ-->
        <form action="" method="post">
            <input type="string"   name="name"  placeholder="Name"><br>
            <input type="string"   name="comment" placeholder="Comment">
            <input type="password" name="pass1"  placeholder="password">
            <input type="submit"   name="submit"> <br><br>
            <input type="number"  name="estep" placeholder="Edit Number">
            <input type="password" name="pass2"  placeholder="password">
            <button type="submit" name="eflag" value=1>編集</button><br><br>
            
            <input type="number"  name="dstep"  placeholder="Delete Number">
            <input type="password" name="pass3"  placeholder="password">
            <button type="submit" name="dflag"  value=1>削除</button>
            

            
        </form>
<?php  
// 【サンプル】
	// ・データベース名：tb220315db
	// ・ユーザー名：tb-220315
	// ・パスワード：Wxvss3guTK
	// の学生の場合：

	// DB接続設定
$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS tb51"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "submitDate datetime,"
//3-5のsql版で利用
. "password int"
.");";
	$stmt = $pdo->query($sql);
  
        //新規投稿関係 
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $submitDate = date("Y/m/d/ H:i:s");
        //削除関係
            $step = $_POST["dstep"];
            $flag = $_POST["dflag"];
        //編集関係
            $step = $_POST["estep"];
            $flag = $_POST["eflag"];
        //パスワード
        $pass1 = $_POST["pass1"];//新規投稿
        $pass2 = $_POST["pass2"];//編集
        $pass3 = $_POST["pass3"];//削除
        
        
        //削除
            if($flag == 1 && !empty($pass3)){
                $sql = $pdo -> prepare("DELETE FROM tb51 WHERE id = :id");
	            $sql->bindParam(':id', $step);
                $sql -> execute();
       //編集
            }elseif($flag == 1 && !empty($name && $comment && $pass2)){
	            $id = $step; //変更する投稿番号
	            $sql = 'UPDATE tb51 SET name=:name,comment=:comment WHERE id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	            $stmt->bindParam(':id', $step);
	            $stmt->execute();
            }else{
        //データ入力
            if(!empty($name && $comment && $pass1)){
	            $sql = $pdo -> prepare("INSERT INTO tb51 (name, comment, submitDate) VALUES (:name, :comment, :submitDate)");
	            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $sql -> bindParam(':submitDate', $submitDate);
	            $sql -> execute();
                }
            }
        //表示
        echo "表示中"."<br>";
        $sql  =  'SELECT * FROM tb51';
        $stmt =  $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['comment'].',';
		    echo $row['submitDate'].'<br>';
	        echo "<hr>";
	    }
        ?>
</body>
</html>
