<?php

class AGRenanggaranpenerimaandetT extends RenanggaranpenerimaandetT{
	public $hasil,$termin,$no_urut,$approve;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTermin($renanggpenerimaan_id = null){
		$modDetail = array();
		if(!empty($renanggpenerimaan_id)){
		$modRealisasis = AGRealisasianggpenerimaanT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$renanggpenerimaan_id));
			$criteria = new CDbCriteria;
			if(!empty($modRealisasis)){ 
				foreach($modRealisasis as $i => $modRealisasi){
					if(!empty($renanggpenerimaan_id)){
						$criteria->addCondition('renanggpenerimaan_id ='.$renanggpenerimaan_id);
					}
						$criteria->addCondition('renanggaranpenerimaandet_id <> '.$modRealisasi->renanggaranpenerimaandet_id);
				}
			}else{
				if(!empty($renanggpenerimaan_id)){
					$criteria->addCondition('renanggpenerimaan_id ='.$renanggpenerimaan_id);
				}
			}
				$modDetail = AGRenanggaranpenerimaandetT::model()->findAll($criteria);
			
			return $modDetail;
		}else{
			return null;
		}
	}
}