<?php
class GFObatAlkesM extends ObatalkesM
{
	public $nama_pegawai;
	public $sumberdana_nama;
	public $jenisobatalkes_nama;
	public $satuankecil_nama;
	public $rownum;
	public $is_nobatch_tglkadaluarsa;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchData()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('sumberdana');

		if(!empty($this->lokasigudang_id)){
			$criteria->addCondition('lokasigudang_id = '.$this->lokasigudang_id);
		}
		if(!empty($this->generik_id)){
			$criteria->addCondition('generik_id = '.$this->generik_id);
		}
		if(!empty($this->satuanbesar_id)){
			$criteria->addCondition('satuanbesar_id = '.$this->satuanbesar_id);
		}
		
		$criteria->compare('discountinue',FALSE);
		$criteria->compare('obatalkes_aktif',TRUE);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
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
				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
			}
			if(!empty($this->sumberdana_id)){
				$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
			}
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
			}
			if(!empty($this->jenisobatalkes_id)){
				$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
			}
            $criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
            $criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
            $criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
//            $criteria->compare('LOWER(t.tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
            if(!empty($this->tglkadaluarsa)){
                $criteria->addCondition("date(t.tglkadaluarsa) = '".$this->tglkadaluarsa."'");
            }
            $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
            $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
            $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
            $criteria->addCondition('obatalkes_aktif = TRUE');
           // $criteria->order='obatalkes_nama ASC';
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
		public function getPabrikItems()
		{
			return PabrikM::model()->findAll('pabrik_aktif=true ORDER BY pabrik_nama');
		}
		public function getAtcItems()
		{
			return GFAtcM::model()->findAll('atc_aktif=true ORDER BY atc_nama');
		}
}