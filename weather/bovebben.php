<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!empty($_POST["napok"])){
	if($_POST['napok'] == 'none') {
		echo "-";
	} else {
		$connect = mysqli_connect("localhost","----","-----")or die(mysqli_error());
		$db = "----";
		$a = mysqli_query($connect, "SELECT * FROM $db.`RaspberryPiWeatherLog` WHERE `Datum` LIKE '".$_POST['napok']."%'");
		if (!$a) {
			printf("Error: %s\n", mysqli_error($connect));
			exit();
		}
		echo "<table align='center' width='100%' border='1'><tr><td>Hőmérséklet</td><td>Páratartalom</td><td>Harmatpont</td><td>Idő</td><td>Kép</td></tr>";
		while($b = mysqli_fetch_array($a)) {
			echo '<tr>';
			echo '<td>'.$b['Homerseklet'].' °C</td>';
			echo '<td>'.$b['Paratartalom'].'%</td>';
			echo '<td>'.$b['Harmatpont'].' °C</td>';
			echo '<td>'.$b['Datum'].'</td>';
			echo '<td>';
			$mikor = $b['Datum'];
			$mikor = str_replace(":", "_", $mikor);
			$mikor = str_replace(" ", "__", $mikor);
			$mikor = str_replace("-", "_", $mikor);
			if(file_exists("assets/images/kepek/".substr($mikor, 0,17).".png")) echo '<a target="_blank" href="assets/images/kepek/'.substr($mikor, 0,17).'.png">Kép</a>';
			echo '</td>';
			echo '</tr>';
		}
		echo "</table>";
	}
}
?>