<?php

class GZLaporanjmlpasienhariangiziV extends LaporanjmlpasienhariangiziV
{
        public $tgl_awal, $tgl_akhir, $pilihanTab, $jml_perhari, $pilihan_tab;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanjmlpasienhariangiziV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('tglkirimmenu',$this->tgl_awal,$this->tgl_akhir);
                if(is_array($this->jenisdiet_id)){
                    $criteria->addInCondition('jenisdiet_id', $this->jenisdiet_id);
                }else{
                    $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
                }
                if(is_array($this->jeniswaktu_id)){
                    $criteria->addInCondition('jeniswaktu_id', $this->jeniswaktu_id);
                }else{
                    $criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
                }            
		return $criteria;
	}
        
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
                $criteria->select = "jenisdiet_id, jenisdiet_nama, jeniswaktu_id, jeniswaktu_nama, MIN(tglkirimmenu) AS tglkirimmenu, SUM(jml_kirim) AS jml_kirim";
                $criteria->group = "jenisdiet_id, jenisdiet_nama, jeniswaktu_id, jeniswaktu_nama";                
                $criteria->order = "tglkirimmenu, jeniswaktu_id";
		return $criteria;
	}
        
        public function searchPrintLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
                $criteria->select = "jenisdiet_id, jenisdiet_nama, jeniswaktu_id, jeniswaktu_nama, MIN(tglkirimmenu) AS tglkirimmenu, SUM(jml_kirim) AS jml_kirim";
                $criteria->group = "jenisdiet_id, jenisdiet_nama, jeniswaktu_id, jeniswaktu_nama";                
                $criteria->order = "tglkirimmenu, jeniswaktu_id";
		return $criteria;
	}
        
	public function searchRekap()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
                $criteria->group = "jenisdiet_id, jenisdiet_nama";
                $criteria->select = $criteria->group.", MIN(tglkirimmenu) AS tglkirimmenu, SUM(jml_kirim) AS jml_kirim";
		return $criteria;
	}
        
        public function getNamaModel(){
            return __CLASS__;
        }
        
        
}