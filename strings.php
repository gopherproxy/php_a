<?php 
// en php variable typ STRING. Efter $ tegnet må jeg ikke bruge tal eller special characters
	$migSelv = "Marc";
	// typ nummer (numerisk)
	$minTal = 48;
// strings i PHP kan vises med doppelt " eller enkelt ' anføringstegn (doublequotes/singlequotes)
// \ er PHP's escape character
    $minBog = 'The Hitchhiker\'s Guide to the Galaxy';
// udgiv indhold af variablen tekst som <p> i grøn skrift (via class eller id) i <body> - UDEN inline styles!
	$tekst = "Marc's tricky question!";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Strings and variables</title>

<style type="text/css">
	.green {color: green;}
</style>
</head>

<body>
<?php 
	// i double quotes kan man udgive variabler + tekst
	// men som udgangspunkt bruger man single quotes, for at undgår HTML konflikter
	echo '<p class="green">';
	echo $tekst;
	echo '</p>';
	echo '<hr>';
	// i stedet for at udgive seperat, kan man bruge konkatenering (eng: concatenation)
	echo '<p class="green">' . $tekst . "</p>";
	
	// conditional code, betinget kode
	
	if($minTal == 38){
		echo $migSelv . " ser stadig rigtig ung ud!";
	} else if($minTal == 48) {
		echo 'Gud. Ham der ' . $migSelv . " er virkelig blevet slidt...";
	}
	
?>
</body>
</html>




