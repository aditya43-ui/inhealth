<?php

class GFStokopnameT extends StokopnameT{
    public $disableJenisStokOpname = false; //default dropdown jenis stock opname
    public $tgl_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->stokopname_id)){
			$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->formuliropname_id)){
			$criteria->addCondition('formuliropname_id = '.$this->formuliropname_id);
		}
		$criteria->addBetweenCondition('date(tglstokopname)',$this->tglstokopname, $this->tgl_akhir);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		$criteria->compare('isstokawal',$this->isstokawal);
		$criteria->compare('LOWER(jenisstokopname)',strtolower($this->jenisstokopname),true);
		$criteria->compare('LOWER(keterangan_opname)',strtolower($this->keterangan_opname),true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('totalnetto',$this->totalnetto);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->petugas1_id)){
			$criteria->addCondition('petugas1_id = '.$this->petugas1_id);
		}
		if(!empty($this->petugas2_id)){
			$criteria->addCondition('petugas2_id = '.$this->petugas2_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('create_ruangan',Yii::app()->user->getState('ruangan_id'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
