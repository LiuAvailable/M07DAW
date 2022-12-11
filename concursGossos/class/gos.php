<?php
class Gos {
	private $nom;
	private $img;
	private $raca;
	private $amo;

	public function __construct($nom, $amo, $img, $raca){
		$this->nom = $nom;
		$this->amo = $amo;
		$this->img = $img;
		$this->raca = $raca;
	}

	public function saveDB(){
		global $conn;
		$sql = $conn->prepare("insert into gos(nom, amo, img, raca) values (?,?,?,?)");
		$sql->execute([$this->nom,$this->amo,$this->img,$this->raca]);
	}
	public function updateDB():bool{
		global $conn;
		$sql = $conn->prepare("update gos set amo=?,img=?,raca=? where nom = '{$this->nom}'");
		$sql->execute([$this->amo,$this->img,$this->raca]);
		if($sql->rowCount()==0){return False;}
		else{return True;}
	}
}
?>