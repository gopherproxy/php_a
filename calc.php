<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
	
$a = filter_input(INPUT_GET, 'a');	
$b = filter_input(INPUT_GET, 'b');	
$cmd = filter_input(INPUT_GET, 'cmd');	
/*
echo 'parameteren a indeholder værdien '.$a.'<br>'.PHP_EOL;
echo 'b='.$b.'<br>'.PHP_EOL;
echo 'cmd='.$cmd.'<br>'.PHP_EOL;
*/
	
function addNumbers($n1, $n2){
	$res = $n1+$n2;
	return $res;
}	

function subNumbers($n1, $n2){
	return $n1-$n2;
}	
	
switch ($cmd) {
	case 'add':
		$result = 'adding '.$a.' with '.$b.' yields '.addNumbers($a,$b);
		break;
	case 'sub':
		$result = 'subtracting '.$b.' from '.$a.' give '.subNumbers($a,$b);
		break;
	default:
		$result = 'Unknown command: '.$cmd;
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
	<?=$result?>
</p>
</body>
</html>