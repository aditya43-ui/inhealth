<?php
    class FADiagnosaobatM extends DiagnosaobatM
    {

    public $diagnosa_kode,$diagnosa_nama,$obatalkes_nama;
    public static function model($className=__CLASS__)
    {
        
    }
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('diagnosa','obatalkes');
        $criteria->order = 't.diagnosa_id';
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("t.diagnosa_id = ".$this->diagnosa_id);						
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("t.obatalkes_id = ".$this->obatalkes_id);						
		}
		$criteria->compare('LOWER(diagnosa.diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		//$criteria->compare('diagnosa_aktif',isset($this->diagnosa_aktif)?$this->diagnosa_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getDiagnosaItems()
        {
            return DiagnosaM::model()->findAll('diagnosa_aktif=TRUE ORDER BY diagnosa_nama');
        }
        
        public function getObatalkesItems()
        {
            return ObatalkesM::model()->findAll('obatalkes_aktif=TRUE ORDER BY obatalkes_nama');
        }
    }
	
?>