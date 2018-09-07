
<?php



//3-1 データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//3-2 テーブル作成
$sql="CREATE TABLE test9"//テーブル名は「test」
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



//入力内容でHTMLタグなどを使えないようにする
$name=htmlspecialchars($name);
$comment=htmlspecialchars($comment);
$delete=htmlspecialchars($delete);
$edit=htmlspecialchars($edit);



//php用の変数定義
$edit_hidden=$_POST['edit_hidden'];
$password_for_post=$_POST['password_for_post'];
$password_for_delete=$_POST['password_for_delete'];
$password_for_edit=$_POST['password_for_edit'];



//入力内容でHTMLタグなどを使えないようにする
$name=htmlspecialchars($edit_hidden);
$comment=htmlspecialchars($password_for_post);
$delete=htmlspecialchars($password_for_delete);
$edit=htmlspecialchars($password_for_edit);



//MySQLと連携する場合は、date('Y-m-d H:i:s')の形にする
$time=date('Y-m-d H:i:s');//現在時刻  





//削除のためにデータベース内の投稿のパスワードを取得
if((!empty($password_for_delete)&&!empty($delete))&&isset($_POST['削除'])){

	$sql = 'SELECT * FROM test9';//テーブル名
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			
 			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			$id_check=$row['id'];

 			$password_check=$row['password'];

				if($id_check==$delete&&$password_check==$password_for_delete){

						$id_check_for_delete=$delete;
 						$password_check_for_delete=$password_for_delete;//ここで取得

				}
		}
}





//編集のためにデータベース内の投稿のパスワードを取得
if((!empty($password_for_edit)&&!empty($edit))&&isset($_POST['編集'])){

	$sql = 'SELECT * FROM test9';//テーブル名
	$results = $pdo -> query($sql);
		foreach ($results as $row){
			
 			//$rowの中にはテーブルのカラム(フィールド)名が入る
 			$id_check=$row['id'];
 			$password_check=$row['password'];

				if($id_check==$edit&&$password_check==$password_for_edit){

						$id_check_for_edit=$edit;
 						$password_check_for_edit=$password_for_edit;//ここで取得

				}
		}
}






//フォームのvalueの変数を使いたい時はそれよりも前に定義しなければならない
//編集する投稿を取得、表示
if(isset($_POST['編集'])){

	if((!empty($edit)&&!empty($password_for_edit))&&($password_for_edit==$password_check_for_edit&&$edit==$id_check_for_edit)){

		//3-6　データベース内のデータを取得
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
			foreach ($results as $row){

				if($edit==$row['id']){
				//edit_hiddenフォームの中には$editの中身が入る（編集番号）フォームのvalueのところで設定済み
				$name_for_edit=$row['name'];
				$comment_for_edit=$row['comment'];

				}
			}
		
	}


}



//デザイン
print'<div id="header">';
print'<font color size="8"><strong>オーストラリアを語るための掲示板!!!</strong></font>';
print'&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';//題名と国旗の間に空白を入れる
print'<img src="オーストラリア国旗3.png">';
print"<br>";
print'<font color="white" size="6"><strong>　　　　　　～A Forum For Australia!!!～</strong></font>';
print'</div>';


?>


<!-HTML部分-->
<!--mission_4-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>mission_4</title>
<link rel="stylesheet" href="mission_4.css">
</head>




<body>


<div id="form">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<form method="post" action="mission_4.php">
<font class="letters_for_forms"><strong>Post</strong></font>
<br />
<input name="name" type="text" placeholder="名前を入力" style="width:300px" value="<?php echo $name_for_edit; ?>">
<br />
<input name="comment" type="text" placeholder="コメントを入力" style="width:300px" value="<?php echo $comment_for_edit; ?>">
<br />
<input name="password_for_post" type="text" placeholder="パスワードをを入力" style="width:300px">
<input name="edit_hidden" type="hidden" style="width:300px" value="<?php echo $_POST['edit']; ?>">
<br />
<input class="button" type="submit" value="送信" name="送信" style="width:200px"><!--送信ボタンに名前を設定-->
<br />
<br />
<font class="letters_for_forms"><strong>Delete</strong></font>
<br />
<input name="delete" type="text" placeholder="投稿削除番号" style="width:300px">
<br />
<input name="password_for_delete" type="text" placeholder="パスワードをを入力" style="width:300px">
<br />
<input class="button" type="submit" value="削除" name="削除" style="width:200px"><!--削除ボタンに名前を設定-->
<br />
<br />
<font class="letters_for_forms"><strong>Edit</strong></font>
<br />
<input name="edit" type="text" placeholder="編集対象番号" style="width:300px">
<br />
<input name="password_for_edit" type="text" placeholder="パスワードをを入力" style="width:300px">
<br />
<input class="button" type="submit" value="編集" name="編集" style="width:200px"><!--編集ボタンに名前を設定-->
</form>

</div>








<?php












//↓こっから処理開始




//編集の処理を書け！！！







if(isset($_POST['編集'])){

	//編集番号を入力して編集作業に移るときに画面にもともとのデータを表示しておく
	if((!empty($edit)&&!empty($password_for_edit))&&($password_for_edit==$password_check_for_edit&&$edit==$id_check_for_edit)){

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';

				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}







	//上記以外の場合で編集ボタンが押されたときはもともとのデータを表示する（何も起こっていないように見える）
	}else{

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

	}







//↓こっから投稿を削除するときの処理







//削除ボタンを押したとき・・・
}elseif(isset($_POST['削除'])){


	//if(!empty($delete)){
		//もし削除番号は記入されててもパスワードが記入されてなかったら・・・
		if(empty($password_for_delete)&&!empty($delete)){

			print'投稿削除番号とパスワードの両方をを入力した上で削除ボタンを押してください。';
			print"<br>";

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}



	//削除番号と削除用のパスワードを両方記入した場合
	}elseif(!empty($password_for_delete)&&!empty($delete)){

		if(($password_for_delete==$password_check_for_delete)&&($delete==$id_check_for_delete)){
		
			$sql = "delete from test9 where id=$delete"; //テーブル名あり
			$result = $pdo->query($sql);

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

		}else{

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}
		}


	//上記以外の場合は今までのデータを表示する（何も起こっていないように見える）
	}else{

		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

		}










//↓ここから普通の投稿の処理




//送信ボタンを押したとき  (普通の投稿処理と編集後の投稿処理)
}elseif(isset($_POST['送信'])){




	//投稿を編集した後の表示に至るまでの処理
	if(!empty($edit_hidden)){

				
		//3-7
		$id = $edit_hidden;
		$nm = $name;
		$kome = $comment;
		$pass = $password_for_post;
		$sql = "update test9 set name='$nm' , comment='$kome' , password='$pass' where id = $id";
		$result = $pdo->query($sql);


		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}



	//投稿用の処理（パスワードは何でもいい）
	}elseif((!empty($name)&&!empty($comment))&&!empty($password_for_post)){


		//3-5 　データベース内のレコードにデータを追加   テーブル名あり                                                     //nameとcommentはbindParamで設定              
		$sql=$pdo->prepare("INSERT INTO test9 (name,comment,time,password) VALUES (:name,:comment,:time,'$password_for_post')");
		$sql->bindParam(':name',$name,PDO::PARAM_STR);          //変数を使うときは「'」で囲む。「.」はいらない
		$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
		$sql->bindParam(':time',$time,PDO::PARAM_STR);
		$sql->execute();



		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

	}else{


		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

	}

//上記以外の空欄で送信された場合は、現段階でのデータを表示する（送信しても何も変わっていないように見える）
}else{
		//3-6　データベース内のデータを表示
		//order byによって削除後に削除された場所に埋め込まれたidのずれたデータをidの昇順（ascend）に直している
		$sql = 'SELECT * FROM test9 order by id asc';//テーブル名あり  
		$results = $pdo -> query($sql);
		print"<br>";
			foreach ($results as $row){
 				echo $row['id'].': ';
				echo '<font color="red">'.$row['name'].' '.'</font>';
				print'&emsp;';
				print'&emsp;';
				echo $row['time'].' ';
				echo"<br>";
				echo"<br>";
				print'&emsp;';
				$str= $row['comment'];
				$str= str_replace("\'", "'", $str);//HMTLとphpでの文字表記の違いを関数で修正
				echo $str;//コメントを表示
				echo"<br>";
				echo"<br>";
				echo"<br>";
				echo"<br>";
				
			}

}




?>

</body>
</html>



