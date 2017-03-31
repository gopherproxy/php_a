<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
/*
1) SignUp -> gem email og dato/tid i db
- oprette en "newsletter" tabel i en database
- lav SQL til at indsætte testdata
- ny php fil "newsletter.php" med formular
- in php: get email parameter
- connect to db
- form prepared statement
- bind email param
- execute
- test!!!

2) Husk serverside validation
3) Deploy til webhost
4) SignOut -> slet email fra db
5) Deploy til webhost
6) Lav side der viser emails fra db i html tabel (sorter nyeste først)
7) Deploy til webhost
8) Implement clientside validation  
9) Deploy til webhost
*/	

	
	$cmd   = filter_input(INPUT_POST, 'cmd');
	$name  = filter_input(INPUT_POST, 'name');
	$email = filter_input(INPUT_POST, 'email');
	
	if(empty($cmd)){
		?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<fieldset>
		<legend>Nyhedsbrev aka. SPAM!!!</legend>
		<input type="text" name="name" placeholder="Navn"><br>
		<input type="email" name="email" placeholder="E-mail"><br>
		<input type="submit" name="cmd" value="Tilmeld">
		<input type="submit" name="cmd" value="Afmeld">
	</fieldset>
</form>		
		<?php
	}
	else {
		if($cmd == 'Tilmeld') {
			require_once('db_con.php');
			$sql = 'INSERT INTO newsletter (email, name) VALUES (?, ?)';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ss', $email, $name);
			$stmt->execute();
			
			if ($stmt->affected_rows > 0){
				echo 'Du er nu tilføjet til SPAM-listen...';
			}
			else {
				echo $email.' var allerede på listen';
			}
		}

		if($cmd == 'Afmeld') {
			require_once('db_con.php');
			$sql = 'DELETE FROM newsletter WHERE email=?';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			
			if ($stmt->affected_rows > 0){
				echo 'Du er nu fjernet fra SPAM-listen :-((';
			}
			else {
				echo $email.' var ikke på listen?!?!';
			}
		}

		echo '<hr><a href="newsletter.php"> Tilbage</a>';
	}
	
?>

</body>
</html>