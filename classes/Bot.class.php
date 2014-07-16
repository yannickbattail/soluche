<?php
class bot extends Player {

	private static $filieres = array('rose','ingé','droit','Sciences'
	);

	private static $villes = array('Annecy','Grenoble','Lyon','Monpeul','Valence','Aix','Marseilles','Dijon'
	);

	public static function createRandom($nom, $factor = 1) {
		$bot = new bot();
		$bot->defaultValues();
		
		$this->setNom($nom);
		$this->setLieu('camping');
		$this->setPoints(0);
		$this->setNotoriete(floor(rand(4, 10) * $factor));
		$this->setAlcoolemie_optimum(floor(rand(5, 9) * $factor));
		$this->setAlcoolemie_max(floor(rand(9, 12) * $factor));
		$this->setAlcoolemie(floor(rand(2, 7) * $factor));
		$this->setFatigue_max(floor(rand(7, 10) * $factor));
		$this->setFatigue(floor(rand(1, 10) * $factor));
		$this->setSex_appeal(floor(rand(5, 10) * $factor));
		$this->pls = 0;
		$this->debut_de_pls = 0;
		$this->setSex(rand(0, 1));
		$this->setPhoto($this->sex ? 'images/tete_faluche_grise.jpg' : 'images/tete_faluche_blanc.jpg');
		$this->setPnj(1);
		$this->create();
	}

	public static function createMultiples($number, $factor = 1) {
		$i = 0;
		foreach (self::$filieres as $filiere) {
			foreach (self::$villes as $ville) {
				self::createRandom($ville . ' ' . $filiere, $factor);
				$i++;
				if ($number == $i) {
					break;
				}
			}
		}
	}
}
