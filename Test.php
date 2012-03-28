<?php
class Test{
	public $errors = 0, $passed = 0 , $errorFunctions = array(), $totalTestNum = 0;

	public function assertNotNull($val){
		if(!isset($val)||val==null){
			$this->_assertError();
		}else{
			$this->passed++;
		}
	}

	public function assertTrue($val){
		if($val===true){
			$this->passed++;
		}else{
			$this->_assertError();
		}
	}

	private function _assertError(){
		$this->errors++;
		$trace=debug_backtrace();
		$caller = $trace[2];
		if(!$caller['function'])
		die('assert found caller function error!');
		if(!isset($this->errorFunctions[$caller['function']]))
		$this->errorFunctions[$caller['function']] = 0;
		$this->errorFunctions[$caller['function']]++;
	}

	public function msg($msg){
		echo '<div style="color:#009;">'.$msg.'</div>';
	}

	public function start(){
		$className = get_class($this);
		echo '<div style="background:#FFF; margin:30px auto; width:800px; border:1px #CCC solid; padding:10px;">';
		$this->totalTestNum = 0;
		foreach(get_class_methods($className) as $name){
			if(substr($name, 0,4)=='test'){
				$this->totalTestNum++;
				$this->msg('test case &raquo; '.$name);
				$startT=gettimeofday();
				$this->$name();
				$endT=gettimeofday();
				$endT=intval($endT['usec']-$startT['usec'])/1000;
				$this->msg('&nbsp;&nbsp;&nbsp;&nbsp;Done. '.$endT.' Millisecond');
			}
		}
		$this->outputResult();
		echo '</div>';
		die();
	}

	private function outputResult(){
		$totalAssert = $this->errors + $this->passed;
		echo <<< EOF
<h1>Total Test Function: {$this->totalTestNum}</h1>
all test asserts : $totalAssert <br />
EOF;
		if($this->errors>0){
			$this->_outputNotPassed();
		}else{
			$this->_outputPassed();
		}
		
	}
	
	private function _outputPassed(){
		echo <<< EOF
<div style="background:#0A0;font-size:2em; padding:10px; margin:10px;">
	All test assert: {$this->passed} Pass :)
</div>
EOF;
	}

	private function _outputNotPassed(){
		echo <<<EOF
<div style="background:#A00;font-size:2em; padding:10px; margin:10px;">
	Not Pass, error assert: {$this->errors} :(
</div>
<div style="color:#666;">
	<h2>List error assert at name:</h2>
EOF;
			foreach ($this->errorFunctions as $name=>$value) {
				echo 'test name: <span style="font-size:1.2em; color:#000;" >'.$name.'</span> ( not pass '.$value.')<br />';
			}
echo '</div>';
	}
}
?>