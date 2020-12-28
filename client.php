<?php 
include_once "operation.php";
include_once "Database.php";
ob_start();
// session_start();
class client extends Database implements operation {
	var $clientID;
	var $name;
	// var $type;
	var $email;
	var $password;
	var $username;
	var $gender;
	var $address;
	var $phone;
	var $img;

	public function getClid(){

		return $this->clientID;
	}
	public function setClid($id){
		$this->clientID=$id;
	}
	public function getname(){
		return $this->name;
	}
	public function setname($name){
		$this->name=$name;
	}
	// public function gettype(){
	// 	return $this->type;
	// }
	// public function settype($type){
	// 	$this->type=$type;
	// }
	public function getemail(){
		return $this->email;
	}
	public function setemail($mail){
		$this->email=$mail;
	}
	public function getpass(){
		return $this->password;
	}
	public function setpass($pass){
		$this->password=$pass;
	}
	public function getusername(){
		return $this->username;
	}
	public function setusername($name){
		$this->username=$name;
	}
	public function getgender(){
		return $this->gender;
	}
	public function setgender($gender){
		$this->gender=$gender;
	}
	public function getaddress(){
		return $this->address;
	}
	public function setaddress($address){
		$this->address=$address;
	}
	public function getphone(){
		return $this->phone;
	}
	public function setphone($phone){
		$this->phone=$phone;
	}
	public function getimg(){
		return $this->img;
	}
	public function setimg($img){
		$this->img=$img;
	}
	public function Add(){
		return parent::RunDML("insert into client values(Default,'".$this->getname()."','".$this->getemail()."','".$this->getpass()."','".$this->getusername()."','".$this->getgender()."','".$this->getphone()."','".$this->getaddress()."',Default)");
	}
	public function Update(){		
		return parent::RunDML("update client set name='".$this->getname()."', email='".$this->getemail()."', password='".$this->getpass()."',username='".$this->getusername()."',gender='".$this->getgender()."', phone='".$this->getphone()."', address='".$this->getaddress()."', img='".$this->getimg()."' where ClientID='".$_SESSION['id']."'");
	}
	public function Delete(){
		return parent::RunDML("delete from client where ClientID='".$_SESSION['id']."'");
	}
	public function GetAll(){
		$rs= parent::GetData("select * from client ");
		return $rs;

	}
	public function login(){
		$rs= parent::GetData("select * from client where (email='".$this->getemail()."' or phone='".$this->getphone()."')  and password='".$this->getpass()."'");
		return $rs;
	}
	public function getById(){
		$rs= parent::GetData("select * from client where ClientID='".$_SESSION['id']."'");
		return $rs;
	}
	public function getByEmail(){
		$rs= parent::GetData("select * from client where email='".$this->getemail()."'");
		return $rs;
	}
	public function UpdatePW(){
		return parent::RunDML("update client set password='".$this->getpass()."' where ClientID='".$_GET["id"]."'");
	}

}
?>