<?php
	function getPageName() {
		$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$name = substr($url, strpos($url, '/') + 1, -4);
		return $name;
	}

	function quoteText($string, $pdo) {
		$nstr = $pdo->quote($string);
		$nstr = substr($nstr, 1, -1);
		return $nstr;
	}

	function quoteArray($array, $pdo) {
		$new_array = [];
		foreach ($array as $key => $value) {
			$type = gettype($value);
			if (!strcmp($type, "array")) {
				$new_array[$key] = quoteArray($value, $pdo);
			} else {
				$new_array[$key] = quoteText($value, $pdo);
			}
		}
		return $new_array;
	}

	function toTag($array) {
		$string = "";
		foreach ($array as $key => $value) {
			$string .= $value . ",";
		}
		return substr($string, 0, -1);
	}

	function print_array($array, $header = false, $inside = false) {
		if (!$inside) {
			echo '<table class="table table-hover"><tr>';
			if (is_array($header)) {
				echo '<thead><tr>';
				foreach ($header as $key => $value) {
					echo '<th>' . $key . '</th>';
				}
				echo '</thead></tr>';
			}
		}

		foreach ($array as $key => $value) {
			if (is_array($value)) {
				echo "<tr>";
				print_array($value, $header, true);
				echo "</tr>";
			}
			else {
				if ($header) 	{ echo '<td>' . $value . '</td>'; 					}
				else 			{ echo '<td>' . $key . ' :: ' . $value . '</td>';	}
			}
		}

		if (!$inside) {
			echo "</tr></table>";
		}
	}

	function getWeekData($table, $target, $pdo) {
		$array = ["labels" => [], "data" => []];
		 $time = time() - 604800 + 86400;
		for ($i=0; $i < 7 ; $i++) {
			$array["labels"][] = date("d/m", $time);
			$day = date("Y-m-d", $time);
			$dayf = date("Y-m-d", $time + 86400);
			$query = "SELECT count(*) as count FROM " . $table . " WHERE date >= '" . $day . "' AND date < '" . $dayf . "' AND target_id=" . $target;
			$num = mysql_getTable($query, $pdo);
			$array["data"][] = intval($num[0]["count"]);
			$time += 86400; //adding a day
		}
		return $array;
	}
?>