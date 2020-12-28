<?php 
include_once "../operation.php";
include_once "../Database.php";
ob_start();
// session_start();
class admin extends Database implements operation {
	var $admin_id;
	var $username;
	var $email;
	var $password;

	public function getid(){
		return $this->admin_id;
	}
	public function setid($id){
		$this->admin_id=$id;
	}
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
	public function Add(){
		return parent::RunDML("insert into admin values(Default,'".$this->getusername()."','".$this->getemail()."','".$this->getpass()."') ");
	}
	public function Update(){		
	}
	public function Delete(){
	}
	public function GetAll(){

	}
	public function login(){
		$rs= parent::GetData("select * from admin where ( email='".$this->getemail()."' or username='".$this->getusername()."') and password='".$this->getpass()."'");
		return $rs;
	}

}
?>