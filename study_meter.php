<!--HTML部分-->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Naoki's Study-Time-Record-Site</title>
<link rel="stylesheet" href="mission_6.css">
<style>
 body {
  background-color: orange
}
</style>
</head>
<body>



<form method="post" action="study_meter.php" />
<br>
<h1>Naoki's Study-Time-Record-Site</h1>
<br>
&emsp;&emsp;&emsp;
<font>Item：</font>
<input type="text" name="item" style="width:70px" />
<br />
&emsp;&emsp;&emsp;
<font>Time：</font>
<input type="text" name="time" style="width:70px" />

<input type="submit" name="submit" value="submit" style="width:55px; height:22px" />

</form>

</body>
</html>



<?php
print'<br>';
print'<br>';
print'<br>';

//3-1 データベース接続
$dsn='mysql:dbname=tt_152_99sv_coco_com;host=localhost';
$user='tt-152.99sv-coco.com';
$password='Kx6tDi2v';
$pdo=new PDO($dsn,$user,$password);//$pdoは「データベース」のこと、ここでデータベースに接続している
$pdo->query('SET NAMES UTF8');



//3-2 テーブル作成
$sql="CREATE TABLE spi02"//テーブル名は「spi」
."("
."id int auto_increment primary key,"
."time_for_spi INT"
.");";
$stmt=$pdo->query($sql);



//3-2 テーブル作成
$sql="CREATE TABLE paper02"//テーブル名は「paper」
."("
."id int auto_increment primary key,"
."time_for_paper INT"
.");";
$stmt=$pdo->query($sql);



//3-2 テーブル作成
$sql="CREATE TABLE research02"//テーブル名は「research」
."("
."id int auto_increment primary key,"
."time_for_research INT"
.");";
$stmt=$pdo->query($sql);



$item=$_POST['item'];
$time=$_POST['time'];


//何もない時
if(empty($time)||empty($item)){

}



if(!empty($time)&&!empty($item)){

	//SPIの時
	if($item==SPI){
		//まずここですでに記録があるか確認
		$sql = 'SELECT * FROM spi02';
		$results = $pdo -> query($sql);

			foreach ($results as $row){
				$time_for_spi=$row['time_for_spi'];
				$time_plus=$row['time_for_spi']+$time;
			}

				//すでに記録があったら時間を足して更新
				if(!empty($time_for_spi)){
					//3-7
					$sql = "update spi02 set time_for_spi='$time_plus' where id=1 ";
					$result = $pdo->query($sql);
				}else{
					//3-5
					$sql=$pdo->prepare("INSERT INTO spi02 (time_for_spi) VALUES ('$time')");
					$sql->execute();
				}
	}



	//新聞の時
	if($item==Newspaper){

		//まずここですでに記録があるか確認
		$sql = 'SELECT * FROM paper02';
		$results = $pdo -> query($sql);

			foreach ($results as $row){
				$time_for_paper=$row['time_for_paper'];
				$time_plus=$row['time_for_paper']+$time;
			}

				//すでに記録があったら時間を足して更新
				if(!empty($time_for_paper)){
					//3-7
					$sql = "update paper02 set time_for_paper='$time_plus' where id=1";
					$result = $pdo->query($sql);

				}else{
					//3-5
					$sql=$pdo->prepare("INSERT INTO paper02 (time_for_paper) VALUES ('$time')");
					$sql->execute();
				}
	}



	//researchの時
	if($item==Research){
		//まずここですでに記録があるか確認
		$sql = 'SELECT * FROM research02';
		$results = $pdo -> query($sql);

			foreach ($results as $row){
				$time_for_research=$row['time_for_research'];
				$time_plus=$row['time_for_research']+$time;
			}

				//すでに記録があったら時間を足して更新
				if(!empty($time_for_research)){
					//3-7
					$sql = "update research02 set time_for_research='$time_plus' where id=1 ";
					$result = $pdo->query($sql);
				}else{
					//3-5
					$sql=$pdo->prepare("INSERT INTO research02 (time_for_research) VALUES ('$time')");
					$sql->execute();
				}
	}



}



//表示専門地域



//research
$sql = 'SELECT * FROM research02';
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$time_for_research=$row['time_for_research'];
	}
			print'<br>';
			print'<font size=5 color="black">Research</font>';
			print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
				for($i=0; $i<$time_for_research; $i++){
					if($i==70){
						print'<br>';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
					}
					print'■';
				}
					print'<br>';
					print'<br>';
					print'Research '.$time_for_research.'<font size=2>h(s)</font>';
					print'<br>';
					print'<br>';




//spi
$sql = 'SELECT * FROM spi02';
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$time_for_spi=$row['time_for_spi'];
	}
			print'<br>';
			print'<font size=5>SPI</font>';
			print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
				for($i=0; $i<$time_for_spi; $i++){
					if($i==70){
						print'<br>';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';					}
					print'■';
				}
					print'<br>';
					print'<br>';
					print'SPI '.$time_for_spi.'<font size=2>h(s)</font>';
					print'<br>';
					print'<br>';



//paper
$sql = 'SELECT * FROM paper02';
$results = $pdo -> query($sql);
	foreach ($results as $row){
		$time_for_paper=$row['time_for_paper'];
	}
			print'<br>';
			print'<font size=5>Newspaper</font>';
				for($i=0; $i<$time_for_paper; $i++){
					if($i==70){
						print'<br>';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
						print'&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;';
					}
					print'■';
				}
					print'<br>';
					print'<br>';
					print'Newspaper '.$time_for_paper.'<font size=2>h(s)</font>';
					print'<br>';
					print'<br>';







?>