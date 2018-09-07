<?php



//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');







//ログイン画面からのデータの引き継ぎ ここは変更するな！！
//php用の変数
$name=$_POST['name'];
$password=$_POST['password'];
$code=$_POST['code'];
$code_check='LeighLaraDylanFelix';


//ここで消毒(HTMLタグなどを入力されるのを防ぐ)
$name=htmlspecialchars($name);
$code=htmlspecialchars($code);
$password=htmlspecialchars($password);






//ここのデータベースは別！！　いじるな！！
//ログインのためにデータベース内のユーザー名とパスワードを取得
if((!empty($name)&&!empty($password))&&($code==LeighLaraDylanFelix)){
	$sql = 'SELECT * FROM test12';//テーブル名[test12] ここだけユーザー登録をした時のテーブルを選択
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			$name_check=$row['name'];
			$password_check=$row['password'];
				if($name_check==$name&&$password_check==$password){
					$name_check_for_login=$name;//取得したユーザーネーム
 					$password_check_for_login=$password;//取得したパスワード
				}
		}
}



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

</body>
</html>






<?php



//入力内容が全てあっている場合  ここは消すな！！！
if($name==$name_check_for_login&&$password==$password_check_for_login&&$code==$code_check){


print'<div id="form">';
print'<img src="オーストラリア国旗3.png">';
print'<img src="日本２.png">';
print'<br>';
print'<img src="welcome2.png">';
print'</div>';

print'<div class="link">';
print'<br>';
print'<br>';
print'<br>';
print'<br>';
print'<br>';
print'<br>';
print'<br>';
print'<font size=5>'.'Click below!'.'</font>';
print'<br>';
print'<a href="site.php">'.'<font size=5>'.'<strong>'.'Let\'s go to the websete!!'.'</strong>'.'</font>'.'</a>';
print'<br>';
print'<div>';



//入力欄に空欄があった時
}elseif($name==''||$password==''||$code==''){

	print'<div id="form">';
	print'<img src="failed to log in4.png">';
	print'<br>';print'<br>';print'<br>';
	print'ユーザー登録画面で入力したユーザー名、パスワードとメールに記載されていた認証コードを全て入力した上でログインボタンを押してください。';
	print"<br>";print"<br>";
	print'<form>';
	print'<input type="button" onclick="history.back()" value="戻る">';
	print'</form>';
	print'</div>';

}



//ここに書いてある動画アップロードのプログラムは別ページにリンクでいってからのアップロード専用ページにする
//本ページはデータベースの中のやつを降順（新しい順）に表示する


?>