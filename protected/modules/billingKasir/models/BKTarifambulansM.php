<?php

class BKTarifambulansM extends TarifAmbulansM
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTarifPerKm(){
		$tarif = 0;
		if(!empty($this->tarifperkm)){
			$tarif = $this->tarifperkm;
		}
		
		return $tarif;
	}
	
	public function getTarifAmbulans(){
		$tarif = 0;
		if(!empty($this->tarifambulans)){
			$tarif = $this->tarifambulans;
		}
		
		return $tarif;
	}
}
?>
