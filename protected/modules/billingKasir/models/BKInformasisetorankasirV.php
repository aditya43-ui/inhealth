<?php

class BKInformasisetorankasirV extends InformasisetorankasirV { 
	public $tgl_awal, $tgl_akhir;
	
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function searchInformasi()
	{
		$c = new CDbCriteria();
		
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$c->addBetweenCondition('tglsetorankasir', $this->tgl_awal, $this->tgl_akhir);
		}
		$c->compare('lower(nosetorankasir)', strtolower($this->nosetorankasir), true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$c,
		));
	}
}
