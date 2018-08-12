
<?php

//今回の掲示板のパスワードは「a」!!!!!



//3-1 データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//3-2 テーブル作成
$sql="CREATE TABLE test5"//テーブル名は「test」
."("
."id int auto_increment primary key,"//primary keyをつけたフィールド内では同じデータの値の重複を許さない
."name char(32),"
."comment TEXT,"
."time datetime,"//型が「date」だけだとSQL文上では日付だけしか表さないので「datetime」型にする
."password char(32)"
.");";
$stmt=$pdo->query($sql);







//php用の変数定義
$name=$_POST['name'];
$comment=$_POST['comment'];
$delete=$_POST['delete'];
$edit=$_POST['edit'];
$edit_hidden=$_POST['edit_hidden'];
$password_for_post=$_POST['password_for_post'];
$password_for_delete=$_POST['password_for_delete'];
$password_for_edit=$_POST['password_for_edit'];




//MySQLと連携する場合は、date('Y-m-d H:i:s')の形にする
$time=date('Y-m-d H:i:s');//現在時刻  




//データベース内の一個前の投稿のパスワードを取得
$sql = 'SELECT * FROM test5';//テーブル名
$results = $pdo -> query($sql);
foreach ($results as $row){
 //$rowの中にはテーブルのカラム(フィールド)名が入る
 $password_check=$row['password'];
}




//フォームのvalueの変数を使いたい時はそれよりも前に定義しなければならない
if((!empty($edit)&&!empty($password_for_edit))&&($password_for_edit==$password_check)){

	//3-6　データベース内のデータを取得
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			if($edit==$row['id']){
				//edit_hiddenフォームの中には$editの中身が入る（編集番号）フォームのvalueのところで設定済み
				$name_for_edit=$row['name'];
				$comment_for_edit=$row['comment'];
			}
		
		}


}



?>


<!-HTML部分-->
<!--mission_4-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_4</title>
<link rel="stylesheet" href="mission_2-3.css">
</head>
<body>
<form method="post" action="mission_4.php">
<input name="name" type="text" placeholder="名前を入力" style="width:300px" value="<?php echo $name_for_edit; ?>">
<br />
<input name="comment" type="text" placeholder="コメントを入力" style="width:300px" value="<?php echo $comment_for_edit; ?>">
<br />
<input name="password_for_post" type="text" placeholder="パスワードをを入力" style="width:300px">
<input name="edit_hidden" type="hidden" style="width:300px" value="<?php echo $_POST['edit']; ?>">
<input class="button" type="submit" value="送信">
<br />
<br />
<input name="delete" type="text" placeholder="投稿削除番号" style="width:300px">
<br />
<input name="password_for_delete" type="text" placeholder="パスワードをを入力" style="width:300px">
<input class="button" type="submit" value="削除">
<br />
<br />
<input name="edit" type="text" placeholder="編集対象番号" style="width:300px">
<br />
<input name="password_for_edit" type="text" placeholder="パスワードをを入力" style="width:300px">
<input class="button" type="submit" value="編集">

</form>









<?php












//↓こっから処理開始




//編集の処理を書け！！！






//編集番号を入力して編集作業に移るときに画面にもともとのデータを表示しておく

if((!empty($edit)&&!empty($password_for_edit))&&($password_for_edit==$password_check)){

//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}




//投稿を編集した後の表示に至るまでの処理

}elseif(!empty($edit_hidden)&&($password_for_post==$password_check)){

				
	//3-7
	$id = $edit_hidden;
	$nm = $name;
	$kome = $comment;
	$sql = "update test5 set name='$nm' , comment='$kome' where id = $id";
	$result = $pdo->query($sql);


	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}







//↓こっから投稿を削除するときの処理





//削除欄のパスワードだけ埋めて削除番号が空欄で削除ボタンを押した場合
}elseif(!empty($password_for_delete)&&empty($delete)){

		print'投稿削除番号とパスワードの両方をを入力した上で削除ボタンを押してください。';
		print"<br>";

	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}







//削除番号を記入したして削除ボタンを押したとき・・・
}elseif(!empty($delete)){
	//もし削除番号は記入されててもパスワードが記入されてなかったら・・・
	if(empty($password_for_delete)){

		print'投稿削除番号とパスワードの両方をを入力した上で削除ボタンを押してください。';
		print"<br>";

	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}



	//削除番号と削除用のパスワードを両方記入した場合
	}elseif($password_for_delete==$password_check){
		
	$sql = "delete from test5 where id=$delete"; //テーブル名あり
	$result = $pdo->query($sql);

//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}
	}






//↓ここから普通の投稿の処理


//空欄で投稿されるのを防止する
}elseif((empty($name)||empty($comment))||empty($password_for_post)){

	print'名前、コメント、パスワードを全て入力した上で送信ボタンを押して下さい。';
	print"<br>";

	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}




//初回投稿用（ここでパスワードを決める）
}elseif((!empty($name)&&!empty($comment))&&($password_check==null)){



	//3-5 　データベース内のレコードにデータを追加   テーブル名あり                                                     //nameとcommentはbindParamで設定              
	$sql=$pdo->prepare("INSERT INTO test5 (name,comment,time,password) VALUES (:name,:comment,:time,'$password_for_post')");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);          //変数を使うときは「'」で囲む。「.」はいらない
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':time',$time,PDO::PARAM_STR);
	$sql->execute();



	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}





//二回目以降の投稿（一回目で記入したパスワードと同じかここで判断して投稿を許可する）
}elseif((!empty($name)&&!empty($comment))&&($password_check==$password_for_post)){



	//3-5 　データベース内のレコードにデータを追加   テーブル名あり                                                     //nameとcommentはbindParamで設定              
	$sql=$pdo->prepare("INSERT INTO test5 (name,comment,time,password) VALUES (:name,:comment,:time,'$password_for_post')");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);          //変数を使うときは「'」で囲む。「.」はいらない
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':time',$time,PDO::PARAM_STR);
	$sql->execute();




	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}





//上記以外の空欄で送信された場合は、現段階でのデータを表示する（送信しても何も変わっていないように見える）
}else{

	//3-6　データベース内のデータを表示
	//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
	$sql = 'SELECT * FROM test5 order by id asc';//テーブル名あり  
	$results = $pdo -> query($sql);
	print"<br>";
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			echo $row['id'].' ';
			echo $row['name'].' ';
			echo $row['comment'].' ';
			echo $row['time'].' ';
			echo"<br>";
		}
}



?>

</body>
</html>



