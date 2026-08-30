<?php
class BKObatalkesM extends ObatalkesM
{
        public $sumberdana_nama,$jenisobatalkes_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan data obat alkes untuk dialog
         * @return \CActiveDataProvider
         */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                                $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                                JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                                LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
                                ";
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);					
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("t.sumberdana_id = ".$this->sumberdana_id);					
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("t.satuankecil_id = ".$this->satuankecil_id);					
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("t.jenisobatalkes_id = ".$this->jenisobatalkes_id);					
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
                $criteria->addCondition('obatalkes_aktif = TRUE');
		$criteria->order='obatalkes_nama ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        /**
         * untuk dialog pilih obat alkes
         * @return type
         */
        public function getSatuanKecilNama(){
            return $this->satuankecil->satuankecil_nama;
        }
}