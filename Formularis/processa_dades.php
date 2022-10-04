<?php
echo $_REQUEST['mytext']."<br>";
echo $_REQUEST['myradio']."<br>";
for ($i=0; $i < sizeof($_REQUEST['mycheckbox']); $i++) { 
	echo "Array position {$i}: ".$_REQUEST['mycheckbox'][$i]."<br>";
}
echo $_REQUEST['myselect']."<br>";
echo $_REQUEST['mytextarea']."<br>";
?>


