<?php
	function mysql_getTable($query, $pdo) {
		//returns a table wih the content of the query. ICE : returns NULL
		$statement = $pdo->query($query);
		if (!$pdo || !$statement) { 
			echo 'function <strong>mysql_getTable</strong> : query failed.<br>';
			return NULL;
		}
		$table = [];
		while ($t = $statement->fetch(PDO::FETCH_ASSOC)) {
			$table[] = $t;
		}
		return $table;
	}

	function createUser($id, $pdo) {
		$table = mysql_getTable('SELECT * FROM cmg_users WHERE id =' . $id, $pdo);
		$user = new User ($table[0], $pdo);
		return $user;
	}

	function createPhoto($id, $pdo) {
		$table = mysql_getTable('SELECT * FROM cmg_photos WHERE id =' . $id, $pdo);
		$user = new Photo ($table[0]);
		return $user;
	}

	function build_tags($tag_list, $max) {
			$retval = "";
			for ($j=0; $j < $max; $j++) {
				$amax = count($tag_list) - 1;
				$offset = rand(0, $amax);
				$retval .= $tag_list[$offset] . ", ";
				array_splice($tag_list, $offset, 1);
			}
			$retval = substr($retval, 0, -2);
			return $retval;
	}

	function db_fill_users($n, $genders, $tag_list, $pdo) {
			echo "Filling user table : ";

		for ($i=1; $i <= $n ; $i++) {
			echo ".";
			$pseudo = "chat" . $i; 
			$mail = $pseudo . "@mia.ou";
			$mdp = hash("sha256", "Jambon01" . $pseudo);
			$age = rand(7, 120);
			$rds = rand(10, 99);
			$sexe = $genders[rand(0, count($genders) - 1)];
			$attraction = build_tags($genders, rand(1,5));
			$tags = build_tags($tag_list, rand(1,10));
			$description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus rutrum dapibus sagittis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed id mattis leo. Morbi viverra bibendum nibh, maximus rhoncus ligula condimentum sed. Nunc ut dui vitae arcu egestas placerat eu sed massa. Proin cursus sapien sed velit placerat tincidunt ac vitae eros. Pellentesque massa ex, vehicula vitae erat quis, mattis accumsan ipsum. Phasellus eget laoreet nulla, quis facilisis diam. Pellentesque imperdiet bibendum purus, in dignissim arcu pulvinar vitae. Nunc vitae tortor urna. Aliquam fermentum porta diam, in luctus turpis tincidunt non. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut auctor erat a est iaculis convallis. Vestibulum quis egestas velit, a pellentesque arcu.";

		    $registerquery = $pdo->prepare("
            INSERT INTO users (username,password,mail,age,gender,attraction,tags,rds,description,photoP,photoA,photoB,photoC,photoD) 
            VALUES(:username,:password,:mail,:age,:gender,:attraction,:tags,:rds,:description,:photoP,:photoA,:photoB,:photoC,:photoD)
            ");
            
            $registervalues = array(
                ':username' => $pseudo,
                ':password' => $mdp,
                ':mail' => $mail,
                ':age' => $age,
                ':gender' => $sexe,
                ':attraction' => $attraction,
                ':tags' => $tags,
                ':rds' => $rds,
                ':description' => htmlspecialchars($description),
                ':photoP' => "temp",
                ':photoA' => "shadow.jpg",
                ':photoB' => "shadow.jpg",
                ':photoC' => "shadow.jpg",
                ':photoD' => "shadow.jpg"
                );

            $registerquery->execute($registervalues);
            $user = User::find("id", "username", $pseudo, $pdo);
            $photoname = $user[0]["id"] . "_P.jpg";
            $pdo->query("UPDATE users SET photoP = '" . $photoname . "' WHERE id = " . intval($user[0]['id']));
        }
        echo "<br>";
	}

	function db_create_views($n, $pdo) {
		echo "Filling visit table : ";
		$today = time();
		$aday = 86400;
		for ($i=0; $i < $n ; $i++) { 
			echo ".";
			$time = $today - (rand(0,7) * $aday);
			$time = date("Y-m-d", $time);
			$visitor = rand(0, 50);
			$target = rand(0, 50);
			while ($visitor == $target) { $target = rand(0, 50); }
			$query = $pdo->prepare(	"INSERT INTO visites (date, visitor_id, target_id) 
									 VALUES(:date, :visitor, :target)");
			$qvalues = [':date' => $time, ':visitor' => $visitor, ':target' => $target];
			$query->execute($qvalues);
		}
			echo "<br>";
	}

	function db_create_likes($n, $pdo) {
		//create x likes
		//do not create if x already likes y, reroll y instead
		echo "Filling likes table : ";
		$today = time();
		$aday = 86400;
		for ($i=1; $i < $n+1 ; $i++) { 
			echo ".";
			$j = 0;
			while ($j < 50) {
                $j += rand(1, 20);

                if ($j > 50) {
                    continue ;
                }

                $time = $today - (rand(0,7) * $aday);
				$time = date("Y-m-d", $time);
				$query = $pdo->prepare(	"INSERT INTO likes (date, user_id, target_id) 
									 VALUES(:date, :user, :target)");
				$qvalues = [':date' => $time, ':user' => $i, ':target' => $j];
				$query->execute($qvalues);
			}
		}
			echo "<br>";
	}
?>