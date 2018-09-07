<?php



//3-1 データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');






//php用の変数定義
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];


//ここで消毒(HTMLタグなどを入力されるのを防ぐ)
$name=htmlspecialchars($name);
$email=htmlspecialchars($email);
$password=htmlspecialchars($password);


?>


<!--HTML部分-->
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
</div>


<?php

//入力欄に空欄があるとき
if($name==''||$email==''||$password==''){

	print"<br>";print"<br>";print"<br>";print"<br>";print"<br>";print"<br>";
	print'<div id="form">';
	print"Please fill in all the blanks and press the button.";
	print"<br>";print"<br>";
	print'<form>';
	print'<input type="button" onclick="history.back()" value="Back" style="width: 70px; height: 30px">';
	print'</form>';
	print'</div>';


//入力欄がすべて埋まっている時
}else{

	print"<br>";print"<br>";print"<br>";print"<br>";
	print'<span id="name_margin">';
	print'Your username';
	print'</span>';

	print'&emsp;';print'&emsp;';
	print $name;

	print'&emsp;';print'&emsp;';
	print'';
	
	print"<br>";print"<br>";print"<br>";
	print'<span id="email_margin">';
	print'Your mail adress';
	print'</span>';

	print'&emsp;';print'&emsp;';
	print $email;

	print"<br>";print"<br>";print"<br>";
	print'<span id="password_margin">';
	print'Your password';
	print'</span>';

	print'&emsp;';print'&emsp;';
	print $password;

	print"<br>";print"<br>";print"<br>";
	print"<br>";print"<br>";
	print'<div id="ok_or_back">';
	print'Please press OK if everything is correct';
	print'</div>';



	//隠して入力内容をmission_6_thanks.phpに送る
	print"<br>";
	print'<div id="two_buttons">';
	print'<form method="post" action="registration_form_03.php">';
	print'<input name="name" type="hidden" value="'.$name.'">';
	print'<input name="email" type="hidden" value="'.$email.'">';
	print'<input name="password" type="hidden" value="'.$password.'">';
	print'<input type="button" onclick="history.back()" value="Back" style="width: 70px; height: 30px">';
	print'&emsp;';	
	print'<input class="ok" name="ok" type="submit" value="OK" style="width: 70px; height: 30px">';
	print'</form>';
	print'</div>';



	//ここでユーザー名とパスワードをデータベースに追加
		
		//3-5 　データベース内のレコードにデータを追加   テーブル名あり                                             
		$sql=$pdo->prepare("INSERT INTO test12 (name,password) VALUES ('$name','$password')");
									//変数を使うときは「'」で囲む。「.」はいらない
		$sql->execute();

	


	//データベース内のユーザー名とパスワードを取得して表示

	$sql = 'SELECT * FROM test12';//テーブル名[test12]
	$results = $pdo -> query($sql);
		foreach ($results as $row){

			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			$name_check=$row['name'];
			$password_check=$row['password'];

				if($name_check==$name&&$password_check==$password){

					$name_check_for_login=$name;//取得したユーザーネーム
 					$password_check_for_login=$password;//取得したパスワード
					//print'<br>';
					//echo $name_check_for_login;
					//print'<br>';
					//echo $password_check_for_login;

				}
		}



}

?>


</body>
</html>







