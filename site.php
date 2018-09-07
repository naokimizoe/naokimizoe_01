

<!--HTML部分-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_6</title>
<link rel="stylesheet" href="mission_6.css">
<style>
 body {
  background-color: lightyellow
}
</style>
</head>
<body>
</body>
</html>


<?php

//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//3-2 テーブル作成
$sql="CREATE TABLE test34"//テーブル名は「test」
."("
."id int auto_increment primary key,"
."name char(32),"
."video TEXT,"
."password TEXT,"
."title char(32)"
.");";
$stmt=$pdo->query($sql);



//テーブルtest31にtimesというフィールドを追加
$sql='alter table test34 add times int;';
$stmt=$pdo->query($sql);



////テーブルtest31にdatetimeというフィールドを追加
$sql='alter table test34 add datetime datetime;';
$stmt=$pdo->query($sql);



////テーブルtest31にdatetimeというフィールドを追加 　　　　　　　//変えた
$sql='alter table test34 add photo TEXT;';
$stmt=$pdo->query($sql);



//timesフィールドに入れるための変数を用意
$times;





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

print'<div class="link">';
print'<img src="'.'日本２.png'.'">';
print'<br>';
print'<font size="7"><strong>Japanese Culture For Everybody</strong></font>';
print'<br>';
print'<br>';
print'<a href="upload.php">Click here to '.'<strong>'.'upload'.'</strong>'.' your video!!</a>';
print'<br>';
print'<br>';
print'<a href="delete.php">Click here to '.'<strong>'.'delete'.'</strong>'.' your video!!</a>';
print'<br>';
print'<br>';
print'<a href="site_for_old.php">Click here to '.'<strong>'.'get the oldest video '.'</strong>'.'to be in the first!!</a>';
print'<br>';
print'<br>';

print'</div>';


//3-6　データベース内のデータを表示
//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順(descend）に直している
$sql = 'SELECT * FROM test34 order by id desc';//テーブル名あり  
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$upload_image=$row['photo'];
		$upload_for_screen=$row['video'];
		$count_letters=mb_strlen($upload_for_screen);//count関数は配列の数を数える関数。なので文字数を数えるmb_strlen関数を使った。
			if($count_letters>20){
				print'<div id="bbb">';
				echo '<font size="7">No</font>'.' ';
				echo '<font size="7">'.$row['id'].'</font>'.' ';
				print' ';
				print'&emsp;';
				print'<span id="italic">';
				echo '<font size="7">'.$row['title'].'</font>'.' ';
				print'</span>';
				print'by';
				echo '<font color="red">'.$row['name'].'</font>';
				echo"<br>";
//<embed src="../images/htmq.swf" width="88" height="31"> 
//print'<embed src='.$upload_for_screen.' width="800" height="570" autostart="false">';
//print'<br>';
print '<a href='.$upload_for_screen.'>'.'<img src='.$upload_image.' width="800" height="570" />'.'</a>';
print'&emsp;';print'&emsp;';



				print'<span id="ttt">';
				print'<iframe src="comment.php" width="350" height="565"></iframe>';
				print'</span>';
				print'</div>';

				//アップロードされた日付
				print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';
				print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';
				print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';
				print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';
				print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';print'&emsp;';


				//アップロード日
				print'uploaded on ';
				print '<strong>'.$row['datetime'].'</strong>';

				//視聴回数の処理
				if($row['times']==null){
					$times=$row['times'];
					$times=0;
					//3-7 レコード編集
					$id = $row['id'];
					$sql = "update test34 set times='$times'  where id = $id";
					$result = $pdo->query($sql);
					$sql = 'SELECT * FROM test31 order by id desc';//テーブル名あり  
					$results = $pdo -> query($sql);
					print $row['times'];
					print'<br>';
				}elseif($row['times']>=0){
					$times=$row['times'];
					$times=$times+1;
					//3-7 レコード編集
					$id = $row['id'];
					$sql = "update test34 set times='$times'  where id = $id";
					$result = $pdo->query($sql);//レコードを更新した後は今まで取得した値を表示すればおｋ
					print'&emsp;&emsp;&emsp;&emsp;&emsp;';

					print '<font size=5>'.$row['times'].'</font>';
					print' ';
					print'views';
					print'<br>';
					echo"<br>";
					echo"<br>";
					echo"<br>";
				}
			}
	}






//手書きの絵をアプリでスキャンしてパソコンに画像としてメールで送って何枚もやって声つけて日本の電車の
//乗り換えの複雑さと混雑状況を解説

//CSSの勉強かつデザインで終わり。


?>