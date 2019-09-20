<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "utf-8">
<title>test</title>
</head>
<body>

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); //テーブルの作成
$sql = "CREATE TABLE IF NOT EXISTS mission"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "time TEXT,"
	. "pass TEXT"
	.");";
	$stmt = $pdo->query($sql);

if(!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['pass'])){
	$name = $_POST['name'];
        $comment = $_POST['comment'];
	$time=date("Y/m/d H:i:s");
	$pass=$_POST["pass"];
	$sql = $pdo -> prepare("INSERT INTO mission (name, comment ,time ,pass) VALUES (:name, :comment, :time, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql -> execute();
	}

if(!empty($_POST['editsend']) && !empty($_POST['editNO']) && !empty($_POST['editpass'])){
	$edit=$_POST['editNO'];
	$editpass=$_POST['editpass'];
	$id =$edit;
	$pass = $editpass;
	//受け取った数字とパスワードを代入
	$name=$_POST['editname'];
	$comment=$_POST['editcomment'];
	$time=date("Y/m/d H:i:s");
	$sql = 'update mission set name=:name,comment=:comment,time=:time where id=:id AND pass = :pass';
	//idとpassが一致したものを編集
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':time', $time, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->execute();
}

if(!empty($_POST['deletesend'])&& !empty($_POST['deleteNO']) && !empty($_POST['deletepass'])){
	$delete = $_POST['deleteNO'];
	$deletepass = $_POST['deletepass'];
	$id = $delete;
	$pass = $deletepass;
	$sql = 'delete from mission where id=:id AND pass=:pass';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->execute();
}
?>

<h1>フォームデータの送信</h1>

<form action = "mission_5-1.php" method = "post">
<label for="name">名前</label>
<input type = "text"  id = "name" name ="name" ><br/>
<label for="comment">コメント</label>
<input type = "text"  id = "comment" name ="comment"><br/>
<label for="pass">パスワード</label>
<input type = "password"  id = "pass" name ="pass"><br/>
<input type = "submit" name="send" value ="送信する"><br/>
<br/>
</form>

<h1>削除番号指定フォーム</h1>
<form action="mission_5-1.php" method="post">
<label for="deleteNO">削除対象番号</label>
<input type="text" id="deleteNO" name="deleteNO"></br>
<label for="deletepass">パスワード</label>
<input type = "password"  id = "deletepass" name ="deletepass"><br/>
<input type="submit" name="deletesend" value="削除する">
</form>
<br>

<h1>編集番号指定フォーム</h1>
<form action="mission_5-1.php" method="post">
<label for="editNO">編集対象番号</label>
<input type="text" id="editNO" name="editNO"></br>
<label for="editname">名前</label>
<input type = "text"  id = "editname" name ="editname" ><br/>
<label for="editcomment">コメント</label>
<input type = "text"  id = "editcomment" name ="editcomment"><br/>
<label for="editpass">パスワード</label>
<input type = "password"  id = "editpass" name ="editpass"><br/>
<input type="submit" name="editsend" value="編集する">
</form>
<br>



<?php
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = 'SELECT * FROM mission';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['time'].'<br>';
		echo "<hr>";
	}
?>
	