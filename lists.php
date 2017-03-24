<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	$namelist = array('Ivan', 'Marc', 'kirsten', 'Morten', 'Merete');	
?>

	<table border="2">
		<tr><th>Name</th></tr>
<?php
		foreach($namelist as $name){
			echo '<tr><td>'.$name.'</td></tr>'.PHP_EOL;
		}
?>
	</table>

<?php
	


	
	
	echo '<hr>';
	
	$alist = array('hans' => 34, 'peter' => 45);

	echo $alist['peter'].'<br>'.PHP_EOL;
	
	foreach($alist as $a){
		echo $a.' is in the list<br>'.PHP_EOL;
	}

	foreach($alist as $na => $age){
		echo $na.' is '.$age.' years<br>'.PHP_EOL;
	}
	
	
	
	
?>
	

</body>
</html>