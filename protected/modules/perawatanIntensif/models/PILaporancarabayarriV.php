<?php
class PILaporancarabayarriV extends LaporancarabayarriV
{
	public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getNamaModel() {
        return __CLASS__;
    }
	
	public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
	
	protected function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("penjamin_id",$this->penjamin_id); 	
			}else{
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
			}
		}
        if(!empty($this->nursestation_id)){
			$criteria->addCondition("nursestation_id = ".$this->nursestation_id); 	
		}
        
        return $criteria;
    }
	
	public function searchTable() {
        $criteria = new CDbCriteria;
		$criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchPrintTable() {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
}