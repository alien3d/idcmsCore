<?php
/**
 * Mengira luas bulatan guna setter dan getter..Bukan magic yee
 * @author hafizan
 *
 */
class roundCalculationModel {
	/**
	 * Diameter Luas Bulatan
	 * @var numeric $diameter
	 */
	public $diameter;
	/**
	 * Jumlah luas diameter
	 * @var numeric $result
	 */
	public $result;
	/**
	 * nilai PI
	 * @var cont PI
	 */
	const PI='3.142';
	/**
	 * Jalankan constructor
	 * @param numeric $diameter
	 */
	public function __construct($diameter){
		$this->diameter = $diameter;
		$this->setCalculation();
	}
		
	/**
	 * Yang ini private sebab tak perlu pengiraan tunjuk kat semua orang
	 */
	private function setCalculation(){
		$this->result = pow($this->diameter / 2,2)  * self::PI;
		
	}
	
	/**
	 * Yang ini give output... So programmer lain tak akan tahu apa API process kat belakang
	 * @return number
	 */ 
	public function getCalculation() {
		return $this->result;
	}
}
$diameter=16;
$calculation = new roundCalculationModel($diameter);
$value=$calculation->getCalculation();
echo "Luas Bulatan ialah : ".$value;
?>
