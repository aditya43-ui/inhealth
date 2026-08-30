<?php

class ROCObatalkesM extends ObatalkesM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrawatinapV the static model class
     */
    public $ceklis = false;
    public $carakeluar;
	public $is_dokter = 0;
	public $pegawai_id;
	public $pilih,$daftartindakan_id,$ceklist;
	public $tgl_awal, $tgl_akhir, $jenisobatalkes_nama, $sumberdana_nama;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchinformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
                $criteria->join = " JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id"
                        . " JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id";
                $criteria->select = "t.obatalkes_id, t.obatalkes_nama, sumberdana_m.sumberdana_nama, jenisobatalkes_m.jenisobatalkes_nama, t.tglpenghapusankemenkes, t.tglpengiriminkemenkes, t.tglubahpengirimankemenkes, t.pegawaipenghapusankemenkes, t.pegawaipengirimkemenkes, t.pegawaiubahpengirimankemenkes";
                
		$criteria->addCondition('t.obatalkes_aktif = true');
                $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($this->obatalkes_nama),true);
                $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($this->obatalkes_kode),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("t.jenisobatalkes_id = ".$this->jenisobatalkes_id); 	
		}
                if(!empty($this->sumberdana_id)){
			$criteria->addCondition("t.sumberdana_id = ".$this->sumberdana_id); 	
		}
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
