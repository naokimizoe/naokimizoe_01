
<!--HTML部分-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_6</title>
<link rel="stylesheet" href="mission_6.css">
<style>
 body {
  background-color: papayawhip
}
</style>
</head>
<body>
</body>
</html>


<?php


//iframe（ｐｈｐファイル）のなかで投稿番号を入力させ、comment.投稿番号.で指定したテーブル（テーブル作成時に
//commentフィールドをTEXT属性で指定済み）にinsertし、
//同じくcomment.入力された投稿番号.でテーブルを表示させる

//新着順はリンクで違うサイトに飛ばして同じテーブルを降順で表示させる



//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



print'<form action="comment.php" method="post">';
print'<br>';
print'Number of video：';
print'<input name="number" type="text">';
print'<br>';
print'<br>';
print'Your name：';
print'<input name="name" type="text">';
print'<br>';
print'<br>';
print'Comment：';
print'<input name="comment" type="text">';
print'<br>';
print'<br>';
print'<input type="submit" value="submit" style="width: 70px; height: 30px">';
print'<br>';
print'<br>';




$number=$_POST['number'];
$name=$_POST['name'];
$comment=$_POST['comment'];







//何も入力されていない状態だとデータベース表示のテーブル指定のところで変数にまだ値がはいっていないため
//warningが出てしまうので空欄の時は違う文字列を表示するようにする

if(($number==''&&$name=='')&&$comment==''){

	print'Let\'s put your comment !!';
	print'<br>';
	print'<br>';
	print'If you just wanna see commnets, put the number and click the button !!';

//番号だけが入力されている場合
}elseif((!$number==''&&$name=='')&&$comment==''){


	//◎SELECT文の中に変数名を入れるときは「.」で区切らず「"」で全体を囲う
	$sql = "SELECT * FROM comment_x$number order by id desc";//テーブル名あり  
	$results = $pdo -> query($sql);




	//データベースの中で動画があるレコードのidを取得
	$sql = 'SELECT * FROM test34 order by id desc';//ここのテーブル名は変えるな！！！（ここは動画のあるテーブル）
	$r02 = $pdo -> query($sql);

	//$r02は動画のあるテーブルから来たもの
	foreach ($r02 as $row){
		$upload_for_screen=$row['video'];
		$count_letters=mb_strlen($upload_for_screen);//count関数は配列の数を数える関数。なので文字数を数えるmb_strlen関数を使った。
			if($count_letters>20){
				//動画のあるidを取得
				$video_id=$row['id'];

				//もし動画のあるidと入力された投稿番号が一緒なら打ち込まれたコメントを表示
					if($video_id==$number){

						//送信ボタンと投稿を離すための処理
	
							//$resultsはコメントのためのテーブルから来たもの
							foreach ($results as $row){
								print'<br>';
								//print $row['id'];
								//print' ';
								print $row['name'];
								print' ';
								print'<br>';
								$str= $row['comment'];
								$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
								echo $str;//コメントを表示
								print'<br>';
							}

					}

			}


	}


//全ての欄が入力されている時
}elseif(!$number==''||!$name==''||!$comment==''){



//3-5 　データベース内のレコードにデータを追加   テーブル名あり
$sql=$pdo->prepare("INSERT INTO comment_x"."$number"."(name,comment) VALUES (:name,:comment)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);          //変数を使うときは「'」で囲む。「.」はいらない
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->execute();




//◎SELECT文の中に変数名を入れるときは「.」で区切らず「"」で全体を囲う
$sql = "SELECT * FROM comment_x$number order by id desc";//テーブル名あり  
$results = $pdo -> query($sql);




//データベースの中で動画があるレコードのidを取得
$sql = 'SELECT * FROM test34 order by id desc';//ここのテーブル名は変えるな！！！（ここは動画のあるテーブル）
$r02 = $pdo -> query($sql);
	//$r02は動画のあるテーブルから来たもの
	foreach ($r02 as $row){
		$upload_for_screen=$row['video'];
		$count_letters=mb_strlen($upload_for_screen);//count関数は配列の数を数える関数。なので文字数を数えるmb_strlen関数を使った。
			if($count_letters>20){
				//動画のあるidを取得
				$video_id=$row['id'];

				//もし動画のあるidと入力された投稿番号が一緒なら打ち込まれたコメントを表示
					if($video_id==$number){

						//送信ボタンと投稿を離すための処理
	
							//$resultsはコメントのためのテーブルから来たもの
							foreach ($results as $row){
								print'<br>';
								//print $row['id'];
								//print' ';
								print $row['name'];
								print' ';
								print'<br>';
								$str= $row['comment'];
								$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
								echo $str;//コメントを表示
								print'<br>';
							}

					}

			}


	}
}else{

	print'You failed to comment...';
}





?>