<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Calculator med forbindelse til database</title>
</head>

<body>
<?php

// inkluderer alt inhold fra filen db_con.php i denne fil
require_once('db_con.php');
	
$a = filter_input(INPUT_GET, 'a');	
$b = filter_input(INPUT_GET, 'b');	
$cmd = filter_input(INPUT_GET, 'cmd');	
	
/*
echo 'parameteren a indeholder værdien '.$a.'<br>'.PHP_EOL;
echo 'b='.$b.'<br>'.PHP_EOL;
echo 'cmd='.$cmd.'<br>'.PHP_EOL;
*/
	
function addNumbers($n1, $n2){
	//$res = $n1+$n2;
	//return $res;
	return $n1+$n2;
}	
function subNumbers($n1, $n2){
	return $n1-$n2;
}
function mulNumbers($n1, $n2){
	return $n1*$n2;
}
function divNumbers($n1, $n2){
	return $n1/$n2;
}
	
switch ($cmd) {
	case 'add':
		$result = addNumbers($a,$b);
		$output = 'Adding ' . $a . ' to ' . $b . ' yields ' . $result;
		break;
	case 'sub':
		$result = subNumbers($a,$b);
		$output = 'Subtracting ' . $b . ' from ' . $a . ' gives ' . $result;
		break;
	case 'mul':
		$result = mulNumbers($a,$b);
		$output = 'Multiplying ' . $a . ' and ' . $b . ' gives ' . $result;
		break;
	case 'div':
		$result = round(divNumbers($a,$b), 2);
		$output = 'Dividing ' . $b . ' from ' . $a . ' gives ' . $result;
		break;
	default:
		$output = '...';
}
	
if($cmd){
	// prepared statement for at skrive i en database
	// $con indeholder mysqli objektet (samt forbindelsen)!
	// SQL: Indsat i tabellen calculations, spalte result et værdi
	$stmt = $con->prepare("INSERT INTO calculations (result) VALUES (?)");
	// binde værdier til parameter (med datatype + værdi)
	$stmt->bind_param("d", $result);
	// udføre SQL querien som prepared statement
	$stmt->execute();
	
	echo 'New result added to database';
	
	// lukke forbindelsen
	$stmt->close();
	$con->close();
	
}
	
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="get">
	<label for="a">A</label>
	<input id="a" name="a" type="number" value="<?=$a?>"><br />
	<label for="b">B</label>
	<input id="b" name="b" type="number" value="<?=$b?>"><br />
	<input type="submit" name="cmd" value="add">
	<input type="submit" name="cmd" value="sub">
	<input type="submit" name="cmd" value="mul">
	<input type="submit" name="cmd" value="div">	
</form>
<hr>
<p>
	Result:<br>
	<?= $output ?>
</p>
</body>
</html>