

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
<img src="Thanks.png">
</div>




<?php

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];


//ここで消毒(HTMLタグなどを入力されるのを防ぐ)
$name=htmlspecialchars($name);
$email=htmlspecialchars($email);
$password=htmlspecialchars($password);





print"<br>";print"<br>";print"<br>";print"<br>";print"<br>";print"<br>";



print'<div id="host">';
print'Hello';
print' ';	
print $name;
print'！';


print'<br>';
print'<br>';

print'Thank you for your register！';


print"<br>";print"<br>";

print'We\'ve just send an e-mail to ';
print $email;
print'！';


print'<br>';print'<br>';print'<br>';print'<br>';


print'<a href="mission_6_04.php"><font size="5"><strong>Click here to log in</font></strong></a>';

print'</div>';



$mail_sub='We recieved your register！';
$mail_body="Hello ".$name."!\nThank you for your register！\nPlease put the code below into a blank for code on log-in form.\n\n||Code||\nLeighLaraDylanFelix\n\nHere's the URL of log-in form\nhttp://tt-152.99sv-coco.com/mission_6_real_work.php";
$mail_body=html_entity_decode($mail_body,ENT_QUOTES,"UTF-8");
$mail_head='From:Noakky@mission_6.co.jp';
mb_language('Japanese');
mb_internal_encoding("UTF-8");
mb_send_mail($email,$mail_sub,$mail_body,$mail_head);


print'<form method="post" action="mission_6_04.php">';
print'<input name="name" type="hidden" value="'.$name.'">';
print'<input name="email" type="hidden" value="'.$email.'">';
print'<input name="password" type="hidden" value="'.$password.'">';
print'</form>';





?>


</body>
</html>



