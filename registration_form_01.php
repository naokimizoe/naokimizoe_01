
<!--HTML部分-->
<!--mission_4-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_6</title>
<link rel="stylesheet" href="mission_6.css">
</head>


<body>

<div id="form">

<img src="オーストラリア国旗3.png">
<img src="日本２.png">
<br>
<img src="welcome2.png">

<form method="post" action="mission_6_02.php">
<br /><br />
<font size="5">Registration Form</font>
<br /><br /><br />
<font size="2">Register your username</font>
<br />
<input name="name" type="text" placeholder="Put your username" style="width:300px">
<br /><br /><br />
<font size="2">Register your mail adress</font>
<br />
<input name="email" type="text" placeholder="Put your mail adress" style="width:300px">
<br /><br /><br />
<font size="2">Register your password</font>
<br />
<input name="password" type="text" placeholder="Put your password" style="width:300px">
<br /><br /><br />
<input class="" type="submit" value="Register" style="width:100px; height:50px">
</form>

</div>


<?php


//3-1 データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//3-2 テーブル作成
$sql="CREATE TABLE test12"//テーブル名は「test12」
."("
."id int auto_increment primary key,"//primary keyをつけたフィールド内では同じデータの値の重複を許さない
."name char(32),"
."password char(32)"
.");";
$stmt=$pdo->query($sql);


?>




</body>
</html>







