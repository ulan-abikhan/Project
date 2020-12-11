<?php

	$mysqli = new mysqli('127.0.0.1', "root", "root",'burgerwebproject');
	$myArray = array();
	if ($a = $mysqli->query("SELECT * FROM orders")) {
	    while($row = $a->fetch_array(MYSQLI_ASSOC)) {
	        $myArray[] = $row;
	    }
	    $arr = json_encode($myArray);
	    echo $arr;
	}
?>