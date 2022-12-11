<?php
 
class Fase {
	public $gossosInscrits = [];
	public $vots;
	public $numFase;
	public $inici;
	public $fi;

	public function __construct($numFase, $inici, $fi){
		$this->numFase = $numFase;
		$this->inici = $inici;
		$this->fi = $fi;
		$this->vots = 0;
	}


	public function getGossosInscrits(){
		global $conn;
		$sql = $conn->prepare("select gos_name from gossos_fase where num_fase = ?");
		$sql->execute([$this->numFase]);
		$result = $sql->fetch();
		if ($result == null){
			if($this->numFase == 1){$this->setInscrivedGos($this->numFase);}
			else{$this->selfAutoGenerateInscrivedGos($this->numFase);}
		}
	}

	public function setInscrivedGos($numFase){
		global $conn;
		$sql = "select count(nom) from gos";
		$result = $conn->query($sql);
		$num = $result->fetch();
		if ($num == 9) {
		$sql = "select nom from gos";
			$result = $conn->query($sql);
			while($row = $result->fetch()){
				array_push($this->gossosInscrits, $row['nom']);
			}
			$this->saveDBInscrivedGos();
		}
	}
	 
	public function selfAutoGenerateInscrivedGos($numFase){
		global $conn;
		# Busquem el total de gossos de l'anterior fase
		$sql = "select count(gos_name) as num from gossos_fase where num_fase = {intval($numFase) - 1}";
	    $result = $conn->query($sql);
	    $num = $result->fetch();
		$num = $num['num'];

		# Copiem l'array de gossos de l'anterior fase a excepció del gos amb menys bots
		$sql = "select gos_name from gossos_fase where num_fase = ".strval(intval($numFase)-1)." order by vots DESC LIMIT ".strval(intval($num) - 1);
		$result = $conn->query($sql);
	    while($row = $result->fetch()){
	    	array_push($this->gossosInscrits, $row['gos_name']);
	    }
		$this->saveDBInscrivedGos();
	}
	private function saveDBInscrivedGos(){
		global $conn;
		$sql = $conn->prepare("insert into gossos_fase(num_fase, gos_name) values(?,?)");
		foreach($this->gossosInscrits as $gos){
			$sql->execute([$this->numFase, $gos]);
		}
	}
	public function saveDB(){
		global $conn;
		$sql = $conn->prepare("update fase set inici = ?, fi= ? where num_fase =?");
		$sql->execute([$this->inici,$this->fi,$this->numFase]);
	}
}
?>