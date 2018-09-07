
<!--HTML部分-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_6_for_upload</title>
<link rel="stylesheet" href="mission_6.css">
</head>
<body>


<?php

//ページのデザイン
print'<div class="link">';
print'<img src="'.'日本２.png'.'">';
print'<br>';
print'<font size="7"><strong>Japanese Culture For Everybody</strong></font>';
print'<br>';
print'<font size="7"><strong>Upload Page</strong></font>';
print'<br>';
print'</div>';


//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');


//アップデートする画像のファイル名は日本語ではダメ！！！！
//ファイル名は必ず半角小文字英数字でなければならない

//動画アップデートのための入力フォーム
print'<div id="upload_forms">';

print'<form method="post" action="upload.php" enctype="multipart/form-data">';

print'<br>';
print'Name of the poster：';
print'<input name="name_for_upload" type="text" />';
print'<br>';
print'(※ it doesn\'t have to be your username)';
print'<br>';
print'<br>';

print'Title：';
print'<input name="title_for_upload" type="text" />';
print'<br>';
print'<br>';

print'Password：';
print'<input name="password_for_upload" type="text" />';
print'<br>';
print'(※ You\'ll need this when you delete the video)';
print'<br>';
print'<br>';

print'Select your file for upload：';
print'<input name="file_upload" type="file" accept="video/*" />';
print'<br>';
print'<br>';


print'Select your image for upload：';
print'<input name="image" type="file" accept="image/*" />'; //変えた
print'<br>';
print'<br>';


print'<input type="submit" value="Upload" style="width:80px; height:50px" />';
print'<br>';
print'<br>';

print'</form>';

print'<a href="site.php"><font size=5><strong>Go back to the website</strong></font></a>';

print'</div>';



//アップロードのためのphp用変数
$name_for_upload=$_POST['name_for_upload'];
$title_for_upload=$_POST['title_for_upload'];
$password_for_upload=$_POST['password_for_upload'];


//入力内容でHTMLタグなどを使えないようにする
$name_for_upload=htmlspecialchars($name_for_upload);
$title_for_upload=htmlspecialchars($title_for_upload);
$password_for_upload=htmlspecialchars($password_for_upload);







//何も入力されていない時に本サイトに戻る段階で更新され日付、idなどだけがデータベースにinsertされ
//投稿番号がずれるのを防ぐためのif文
if((!$name_for_upload==''&&!$title_for_upload=='')&&!$password_for_upload==''){


	//MySQLと連携する場合は、date('Y-m-d H:i:s')の形にしたdatetimeフィールドに入れるための変数
	$datetime=date('Y-m-d H:i:s');//現在時刻 


	//ここでファイルをアップロードする処理　　　　　　　　(動画用)
	//元ファイル名の先頭にアップロード日時を加える
	$newfilename=date("YmdHis")."-".$_FILES['file_upload']['name'];

	//ファイルの保存先
	$upload='./'.$newfilename;




	//ここでファイルをアップロードする処理　　　　　　　　(サムネ用)
	//元ファイル名の先頭にアップロード日時を加える
	$newfilename_for_image=date("YmdHis")."-".$_FILES['image']['name'];

	//ファイルの保存先
	$upload_for_image='./'.$newfilename_for_image;






//アップロードが正しく完了したかチェック

//最初に何も表示されないようにするための処理
if($name_for_upload==''||$title_for_upload==''||$password_for_upload==''){
print'<br>';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;';
//空欄があった時の処理
print'<br>';

//ファイルを移動できた時
}elseif(move_uploaded_file($_FILES['file_upload']['tmp_name'],$upload)&&move_uploaded_file($_FILES['image']['tmp_name'],$upload_for_image)){
print'<br>';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;';
print'Your upload was succeeded!!';
print'<br>';

//ファイルの移動ができなかった時
}else{
print'<br>';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
print'&emsp;&emsp;';
print'You failed to upload...';
print'<br>';
}



//移動したファイルを代入
$video_for_upload=$upload;//この変数の位置が大事
$imagefile=$upload_for_image;



//視聴回数のtimes変数のための最初の回数
$times=0;



//3-5 　データベース内のレコードにデータを追加   テーブル名あり
$sql=$pdo->prepare("INSERT INTO test34 (name,video,password,title,datetime,times,photo) VALUES (:name,:video,:password,:title,:datetime,'$times',:photo)");
$sql->bindParam(':name',$name_for_upload,PDO::PARAM_STR);          //変数を使うときは「'」で囲む。「.」はいらない
$sql->bindParam(':video',$video_for_upload,PDO::PARAM_STR);
$sql->bindParam(':password',$password_for_upload,PDO::PARAM_STR);
$sql->bindParam(':title',$title_for_upload,PDO::PARAM_STR);
$sql->bindParam(':datetime',$datetime,PDO::PARAM_STR);
$sql->bindParam(':photo',$imagefile,PDO::PARAM_STR);
//timesフィールドは変数で直接入れてる
$sql->execute();















//◎ここで同じ内容のもう一つのテーブルから動画の投稿番号を取り出し、それ専用のコメント用テーブルを作る

$sql = 'SELECT * FROM test34 order by id desc';//テーブル名あり  
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$upload_for_screen=$row['video'];
		$count_letters=mb_strlen($upload_for_screen);//count関数は配列の数を数える関数。なので文字数を数えるmb_strlen関数を使った。
			if($count_letters>20){
//print $row['photo'];
				//◎ここで動画ごとのコメント専用テーブル製作
				$id_comment=$row['id'];
				//3-2 テーブル作成
				$sql="CREATE TABLE comment_x"."$id_comment".""//テーブル名は「test」
				."("
				."id int auto_increment primary key,"
				."name char(32),"
				."comment TEXT"
				.");";
				$stmt=$pdo->query($sql);


			}
	}




}//ここに「 } 」あります


//サムネ画像を投稿させて（動画同様アップロード日付日付）それをデータベースに保存からのそれをリンクタグ＋中にそのサムネ画像でリンク先は動画








?>