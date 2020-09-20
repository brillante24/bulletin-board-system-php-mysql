<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
  <title>mission5-1</title>
 </head>
 <body>
 <form action="#" method="post">
     <input type="text" name="name" placeholder="名前"><br>
     <input type="text" name="comment" placeholder="コメント">
     <!-パスワード入力フォーム->
     <input type="text" name="passwordo" placeholder="パスワード(8文字以内）">
     <p><input type="submit" name="send" value="送信"></p>
     <!-編集番号指定用フォーム」->
     <input type="text" name="editno" placeholder="編集対象番号">
     <!-パスワード入力フォーム->
     <input type="text" name="password2" placeholder="パスワード">
     <!-「編集」ボタン->
     <p><input type="submit" name="edit" value="編集"></p>
     <!-「削除対象番号」の入力フォーム->
     <input type="text" name="deleteno" placeholder="削除対象番号">
     <!-パスワード入力フォーム->
     <input type="text" name="password3" placeholder="パスワード">
     <!-「削除」ボタン->
     <p><input type="submit" name="delete" value="削除"></p>
    </form>
 <?php
// DB接続設定
$dsn='データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    . "passwordo char(8)"
	.");";
    $stmt = $pdo->query($sql);
    //データを入力
    $sql = $pdo -> prepare("INSERT INTO tbtest (name,comment,date,passwordo) VALUES (:name, :comment,:date,:passwordo)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':passwordo', $passwordo, PDO::PARAM_STR);

    if(isset($_POST["send"])){
    $name =$_POST["name"];
    $comment = $_POST["comment"];
    $date=date("Y/m/d H:i:s");
    $passwordo =$_POST["passwordo"];
    $sql -> execute();
    //データの取得・表示
    $sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
		echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo $row['passwordo'].'<br>';
	echo "<hr>";
    }
}  
//削除機能 
if (isset($_POST["delete"])){
    if($id=$_POST["deleteno"]){
    $sql = 'delete from tbtest where id=:id';
    $stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); 
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
		echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo $row['passwordo'].'<br>';
	echo "<hr>";
            
        } 
    }          
 }  
 
//編集機能 
if(isset($_POST["edit"])){
    if($id=$_POST["editno"]){
    $id =$_POST["editno"]; //変更する投稿番号
	$name =$_POST["name"];
    $comment =$_POST["comment"]; 
    $date=date("Y/m/d H:i:s");
    $passwordo=$_POST["password2"];
	$sql = 'UPDATE tbtest SET name=:name,comment=:comment,date=:date,passwordo=:passwordo WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':passwordo', $passwordo, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
        echo $row['id'].',';
		echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo $row['passwordo'].'<br>';
    echo "<hr>";
    }
}
}

?>
 </body>
</html> 