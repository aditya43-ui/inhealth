<?php

class PSObatAlkesM extends ObatalkesM
{
    public $pendaftaran_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog(){
		
		$criteria = new CDbCriteria();
		$criteria->addCondition(" obatalkes_aktif = TRUE ");
		$criteria->compare("LOWER(obatalkes_nama)", strtolower($this->obatalkes_nama),true);
		$criteria->compare("LOWER(obatalkes_kode)", strtolower($this->obatalkes_kode),true);
		if (!empty($this->satuankecil_id)){
			$criteria->addCondition(" satuankecil_id =".$this->satuankecil_id);
		}
		$criteria->order = " obatalkes_nama ASC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
        
        public function searchDialogPasien(){
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("t.obatalkes_aktif = TRUE");
        $criteria->join = 'join (select a.obatalkes_id, a.pendaftaran_id from obatalkespasien_t a group by a.obatalkes_id, a.pendaftaran_id) o on o.obatalkes_id = t.obatalkes_id';
        $criteria->compare('o.pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare("LOWER(t.obatalkes_nama)", strtolower($this->obatalkes_nama),true);
		$criteria->compare("LOWER(t.obatalkes_kode)", strtolower($this->obatalkes_kode),true);
		if (!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id =".$this->satuankecil_id);
		}
		$criteria->order = "t.obatalkes_nama ASC ";
		
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}