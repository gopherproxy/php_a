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

// definer filter funktioner til user input (VIGTIG!!!)
$filter = array(
 "a"=> FILTER_VALIDATE_INT,
 "b"=> FILTER_VALIDATE_INT,
 "cmd"=> FILTER_SANITIZE_STRING
);
// samler ALLE form data som array
$formData = filter_input_array(INPUT_GET, $filter);
print_r($formData);
$a = $formData['a'];
$b = $formData['b'];
$cmd = $formData['cmd'];

/*
// input direkte fra formular felter
$a = filter_input(INPUT_GET, 'a');	
$b = filter_input(INPUT_GET, 'b');	
$cmd = filter_input(INPUT_GET, 'cmd');
*/	
	
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
	// SQL: Indsæt i tabellen calculations, 4 kolonner, 4 værdier
	$stmt = $con->prepare("INSERT INTO calculations (type, a, b, result) VALUES (?, ?, ?, ?)");
	// binde værdier til parameter (med datatype + variable)
	// datatyper: s=String, i=Integer, d=Double
	$stmt->bind_param("siid", $cmd, $a, $b, $result);
	// udføre SQL querien som prepared statement
	$stmt->execute();
	
	echo 'New result history added to database';
	
	// lukke forbindelsen
	$stmt->close();
	//$con->close();
	
}
	
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="get">
	<label for="a">A</label>
	<!-- sætter default værdi med Ternary operator'n og bevarer bruger input -->
	<input id="a" name="a" type="number" value="<?= $cmd ? $a : 0 ?>"><br />
	<label for="b">B</label>
	<input id="b" name="b" type="number" value="<?= $cmd ? $b : 0 ?>"><br />
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
<hr>
<?php 
	
//prepared statement for at kunne læse data fra en database
$stmt = $con->prepare("SELECT id, type, a, b, result FROM calculations");
// execute the statement
$stmt->execute();
// forberedelsen til data afhentning: prepared statement
$stmt->bind_result($id, $type, $a1, $b1, $res);
// Frontend layout som liste:
echo '<ol>';
// hente data 
// while loop: så længe jeg kan hente noget fra databasen
while($stmt->fetch()){
	// viser ALT som list item
	echo "<li>$id $a1 $type $b1 $res</li>";
}
echo '</ol>';

$stmt->close();
$con->close();
	

?>
</body>
</html>












