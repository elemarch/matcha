<?php

class User {

	//VARIABLESS
	//	bools
	private $online, $connected = false,	$gender;
	
	//	ints
	private $id,			$rds,			$age	;

	//	strings
	private $name,			$description,	$mail,		$tags	;

	//	tables
	private $photos,	$attraction	;

	//constructor
	function __construct($id, $pdo, $current = false) {
		if ($id) {
			if (is_string($id)) {
				if (strpos($id , "@" )) {
					$query = "SELECT * FROM users WHERE mail = '" . $id . "'";
				} else {
					$query = "SELECT * FROM users WHERE username = '" . $id . "'";
				}
			}
			else {
				$query = "SELECT * FROM users WHERE id = " . $id;
			}
			$table = mysql_getTable($query, $pdo);
			$row = $table[0];

			//variable filling
			$this->gender = $row["gender"];
			$this->id = $row["id"];
			$this->rds = $row["rds"];
			$this->name = $row["username"];
			$this->age = $row["age"];
			$this->mail = $row["mail"];
			$this->description = $row["description"];
			$this->photo = [
				"profile" => $row["photoP"],
				"A" => $row["photoA"],
				"B" => $row["photoB"],
				"C" => $row["photoC"],
				"D" => $row["photoD"]
			];
			$this->attraction = explode(',', $row["attraction"]);
			$this->tags = explode(',', $row["tags"]);
			
			$this->online = $row["online"];
			if ($current) {
				$this->connected = true;
			}
		}
	}

	//getters
	function 	   isOnline() { return $this->online;	 	}
	function    isConnected() { return $this->connected;	}
	
	function 	  getGender() { return $this->gender;	 	}
	function 		  getId() { return $this->id;	 		}
	function 		 getRds() { return $this->rds;	 		}
	function 		getName() { return $this->name;	 		}
	function 		getMail() { return $this->mail;	 		}
	function 		 getAge() { return $this->age;	 		}
	function getDescription() { return $this->description;	}
	function  getAttraction() { return $this->attraction;	}
	function 		getTags() {	return $this->tags;			}

	function 	  getPhotos($key = -1) {
		if (is_string($key)) {
			return $this->photo[$key];
		}
		else { return $this->photo;	}
	}

	//setters
	function 	  setOnline($b = true) {	$this->online = $b;	 	}
	function   setConnected($b = true) {	$this->connected = $b;	}

	//static functions
	static function getUserLink($id) {
		echo '<a href="user.php?id=' . $id . '" class="btn btn-primary" role="button"><i class="fa fa-search fa-fw" aria-hidden="true"></i>Profil</a>';
	}

	static function find($target, $col, $value, $pdo) {
		$query = "SELECT " . $target . " FROM users WHERE " . $col . " = '" . $value . "'";
		$table = mysql_getTable($query, $pdo);
		return $table;
	}

	//other functions
	function printCard($header = false) {
		echo '<div class="col-sm-3 user-card"><div class="panel panel-default">';

		if ($header) {
			echo '<div class="panel-heading">' . $header . '</div>';
		}
		echo '<div class="panel-body">';
		if (is_null($this->getId())) {
            echo '<img src="medias/photos/shadow.jpg">';
            echo '<h2>Pas d\'utilisateur</h2>';
        }
        else {
            echo '<img src="medias/photos/' . $this->getPhotos("profile") . '">';
            echo '<h2>' . $this->getName() . '</h2>';
            echo '<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:' . $this->getRds() . '%">';
            echo '<span class="sr-only">' . $this->getRds() . '%</span></div></div><ul>';
            echo '<li>' . $this->getGender() . '</li>';
            echo '<li>' . $this->getAge() . ' mois</li>';
            echo '</ul>';
            echo User::getUserLink($this->getId());
        }
		echo '</div></div></div>';
	}

	function profileCard($current = false) {

    }

	function save() {
		$tag_list = "";
		foreach ($this->tags as $key => $value) {
			$tag_list .= $value . ", ";
		}
		$tag_list = substr($tag_list, 0, -1);

		$query =	"UPDATE users SET ";
		$query .=	"online=" . $this->online . ", ";
		$query .=	"gender=" . $this->gender . ", ";
		$query .=	"rds=" . $this->rds . ", ";
		$query .=	"name='" . $this->name . "', ";
		$query .=	"age='" . $this->age . "', ";
		$query .=	"description='" . $this->description . "', ";
		$query .=	"photoP='" . $this->photo["profile"] . "', ";
		$query .=	"photoA='" . $this->photo["A"] . "', ";
		$query .=	"photoB='" . $this->photo["B"] . "', ";
		$query .=	"photoC='" . $this->photo["C"] . "', ";
		$query .=	"photoD='" . $this->photo["D"] . "', ";
		$query .=	"attractionM=" . $this->attraction["males"] . ", ";
		$query .=	"attractionF=" . $this->attraction["females"] . ", ";
		$query .=	"tags='" . $tag_list . "' ";
		$query .=	"WHERE id=" . $this->id;

		if (!$pdo->query($query)) {
			//if query failed
			echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
			echo '<strong>Un problème est survenu :</strong> Vos données n\'ont pu être sauvegardées.</div>';
		}
	}


}


?>