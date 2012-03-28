<?php
include("./Test.php");

class Simple extends Test{
	
	public function testOne(){
		for($ax=1;$ax<100;$ax++)
			$this->assertTrue($ax>0);
	}
	
	public function testTwo(){
		$notNull = ':)';
		$this->assertNotNull($notNull);
	}
	
}
$simple = new Simple();
$simple->start();
?>