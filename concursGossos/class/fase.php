<?php
 
class Fase {
	public $gossosInscrits;
	public $vots;
	public $numFase;
	public $inici;
	public $fi;


	private function getGossosInscrits(){
		$sql = $conn->prepare("select gos_name from gossos_fase where num_fase = ?");
		$sql->execute([$this->numFase]);
		$result = $sql->fetch();
		if ($result == null){
			if($this->numFase == 1){setInscrivedGos($this->numFase);}
			else{selfAutoGenerateInscrivedGos($this->numFase);}
		}else{
			foreach( $result as $row){
				array_push($this->gossosInscrits, $row['gos_name']);
			}
		}
	}

	

	public function __construct($numFase, $inici, $fi){
		$this->numFase = $numFase;
		$this->inici = $inici;
		$this->fi = $fi;
		$this->vots = 0;
		hola();
	}
	public function hola(){echo "AAA";}


	public function setInscrivedGos($numFase){
		$sql = "select count(nom) from gos";
		$result = $conn->query($sql);
		$num = $result->fetch();
		if ($num == 9) {
			$sql = "select * from gos";
			$result = $conn->query($sql);
			while($row = $result->fetch()){
				array_push($this->gossosInscrits, $row['gos_name']);
			}
		}else{header('Location: ../admin.php?fase_error=few_gossos', true, 303);}
	}
	 
	public function selfAutoGenerateInscrivedGos($numFase){
		# Busquem el total de gossos de l'anterior fase
		$sql = "select count(gos_name) from gossos_fase where num_fase = {intval($numFase) - 1}";
	    $result = $conn->query($sql);
	    $num = $result->fetch();

		# Copiem l'array de gossos de l'anterior fase a excepció del gos amb menys bots
		$sql = "select gos_name from gossos_fase where num_fase = {intval($numFase)-1} order by vots DESC LIMIT {intval($num) - 1} ";
		$result = $conn->query($sql);
	    while($row = $result->fetch()){
	    	array_push($this->gossosInscrits, $row['gos_name']);
	    }
	}
	private function saveDBInscrivedGos(){
		$sql = $conn->prepare("insert into gossos_fase(num_fase, gos_name) values(?,?)");
		foreach($this->gossosInscrits as $gos){
			$sql->execute([$this->numFase, $gos]);
		}
		$sql->execute([$this->inici,$this->fi,$this->numFase]);
	}
	public function saveDB($conn){
		$sql = $conn->prepare("update fase set inici = ?, fi= ? where num_fase =?");
		$sql->execute([$this->inici,$this->fi,$this->numFase]);
	}
}
?>