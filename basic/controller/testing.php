<?php namespace syarikatChang;
class chang{
	public function nama1(){
		return "change";
	}
}
class softique{
	public function nama2(){
		return "change";
	}
}
class test{
	public function nama3(){
		return "change";
	}
}
use syarikatChang as syarikat;
$x= new syarikat\chang;
$x-> nama1();
$y = new syarikat\softique();
$y-> nama2();
$z = new syarikat\test();
$z-> nama3();
?>