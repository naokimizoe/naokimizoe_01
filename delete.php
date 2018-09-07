<?php



print'<div class="link">';
print'<img src="'.'日本２.png'.'">';
print'<br>';
print'<font size="7"><strong>Japanese Culture For Everybody</strong></font>';
print'<br>';
print'<font size="7"><strong>Delete Page</strong></font>';
print'<br>';
print'</div>';





//動画アップデートのための入力フォーム
print'<div id="upload_forms">';
print'<br>';
print'<br>';
print'<form action="delete.php" method="post">';
print'Number of the post：';
print'<input name="number_for_delete" type="text" />';
print'<br>';
print'<br>';
print'Name of the poster：';
print'<input name="name_for_delete" type="text" />';
print'<br>';
print'<br>';
print'Title of the video：';
print'<input name="title_for_delete" type="text" />';
print'<br>';
print'<br>';
print'Password of the video：';
print'<input name="password_for_delete" type="text" />';
print'<br>';
print'(※ You got it when you uploaded the video)';
print'<br>';
print'<br>'; 
print'<br>';
//print'<br>';
print'<input type="submit" value="Delete" style="width:80px; height:50px" />';
print'<br>';
print'<br>';
print'<br>';
//print'<br>';
print'<a href="site.php"><font size=5><strong>Go back to the website</strong></font></a>';
print'<br>';
print'</form>';
print'</div>';






//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//投稿者名とその動画のタイトルとパスワードを取得するためのphp用の変数
$name_for_delete=$_POST['name_for_delete'];
$title_for_delete=$_POST['title_for_delete'];
$password_for_delete=$_POST['password_for_delete'];
$number_for_delete=$_POST['number_for_delete'];


//入力内容でHTMLタグなどを使えないようにする
$name_for_delete=htmlspecialchars($name_for_delete);
$title_for_delete=htmlspecialchars($title_for_delete);
$password_for_delete=htmlspecialchars($password_for_delete);
$number_for_delete=htmlspecialchars($number_for_delete);






//入力欄に空欄があるとき
if($name_for_delete==''||$title_for_delete==''||$password_for_delete==''||$number_for_delete==''){

}elseif(!empty($name_for_delete)&&!empty($title_for_delete)&&!empty($password_for_delete)&&!empty($number_for_delete)){
//3-6　動画削除のためにデータベース内の動画の投稿者名とタイトルを取得
//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの降順（descend）に直している
$sql = 'SELECT * FROM test34 order by id desc';//テーブル名あり  
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$id_check=$row['id'];
		$name_check=$row['name'];
		$title_check=$row['title'];
		$password_check=$row['password'];
			if(($name_for_delete==$name_check)&&($title_for_delete==$title_check)){
				if(($password_for_delete==$password_check)&&($id_check==$number_for_delete)){
					$a=$id_check;
					//パスワードは同じものが存在する場合があるのでやはり重複しないいidがいいい
					$sql = "delete from test34 where id=$a"; //テーブル名あり
					$result = $pdo->query($sql);
					print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
					print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
					print'&emsp;&emsp;';
					print'Your video was deleted!!';

					//その動画に対応するコメント
				}
			}
	}


}else{
	print'You failed to delete...';
}






?>


<!--HTML部分-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_6_for_delete</title>
<link rel="stylesheet" href="mission_6.css">
</head>
<body>
</body>
</html>





