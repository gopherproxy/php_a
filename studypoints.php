<?php 

//////////////////////////////////
// et set af globale variabler //
////////////////////////////////

// vore elskede study points
$studypoints = 45;
// beregning af manglende studypoints
$rest = 80 - $studypoints;
// variabler til HTML output
$pGreen = '<p class="green">';
$pRed = '<p class="red">';
$pSlut = '</p>';
// variabler til tekst output, en "double quoted" string kan tage variabler direkte ind
$spMinus = "$studypoints study points er ikke nok!";
$spOk = "Super, med $studypoints study points kan du gå op til din eksamen!";
$spPlus = "$studypoints study points? Du har formodentlig snydt!";
$rest = " Du mangler $rest study points."
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Print your studypoints</title>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Roboto');
	body {font-family: 'Roboto', sans-serif;}
	.red {color: red;}
	.green {color: green;}
</style>
</head>

<body>
<!-- Output afhængig af antallet af study points-->
<!-- Når study points er under 80 skal der vises en rød tekst med advarsel: 'Kun [antallet af study points] er ikke nok! -->
<!-- Når study points er lige med eller over 80 en grøn tekst: Super, du kan gå op til din eksamen-->
<!-- Når study points er over 100 rød tekst: [antallet af study points]? Du har formodentlig snydt... -->
<!-- NO INLINE STYLES PLEAAAASE !-->
<h2>Klassisk if/else statement</h2>
<?php 
	// mindre end 80
	if($studypoints<80){
		echo $pRed . $spMinus . $rest . $pSlut;
		// mindre eller lige med 100. think simple, en if statement bliver bearbejdet linje for linje ;-)
	} else if ($studypoints<=100){
		// alternativ kan bruges: else if ($studypoints>=80 && $studypoints<=100) - med && kan man sætte 2 eller flere betingelser, her inkluderer den ALLE tal mellem 80 og 100
		echo $pGreen . $spOk . $pSlut;
		// mere end 100 study points
	} else if ($studypoints>100){
		echo $pRed . $spPlus . $pSlut;
	}
	
	echo '<hr>';
?>
<h2>Switch statement med "return" value</h2>
<?php
	
/*
Nu det samme som switch statement:
Switches bruges egentlig kun til at tjekke simple overenstemmelser (fx "... er lige med"), for lidt mere komplekse sammenligninger er man derfor tvunget til at arbejde med return value'n true eller false ;-)
Se mere om switch statement: http://php.net/manual/en/control-structures.switch.php (eller spørg Tue ;-))
*/
	
	// if en "case" returnerer "true":
	switch (true) {
    case ($studypoints<80):
        echo $pRed . $spMinus . $rest . $pSlut;
        break;
    case ($studypoints<=100):
        echo $pGreen . $spOk . $pSlut;
        break;
    case ($studypoints>100):
        echo $pRed . $spPlus . $pSlut;
        break;
	}
?>
</body>
</html>