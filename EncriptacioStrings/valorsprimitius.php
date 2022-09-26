<?php
$i = 12;
$x = 2.5;
$y = true;
$z = ['gat','gos','jordi'];
$tipus_de_i = gettype( $i );
$tipus_de_x = gettype( $x );
$tipus_de_y = gettype( $y );
$tipus_de_z = gettype( $z );
echo "La variable \$i 
      conté el valor $i 
	  i és del tipus $tipus_de_i<br>";

echo "La variable \$x
      conté el valor $x 
	  i és del tipus $tipus_de_x<br>";

echo "La variable \$y 
      conté el valor $y 
	  i és del tipus $tipus_de_y<br>";

echo "La variable \$z conté els valors [ ";
$c = 0;
while($c < count($z)){
	echo $z[$c]." ";
	$c++;
} 
echo "] i és del tipus $tipus_de_z";
?>