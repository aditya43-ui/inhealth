<?php

class ROCKamarruanganM extends KamarruanganM
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
	public $tgl_awal, $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchinformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
                $criteria->join = "JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id";
                $criteria->select = "ruangan_m.ruangan_nama, kamarruangan_id, t.kamarruangan_nokamar, t.kamarruangan_nobed, t.kamarruangan_jmlbed, t.tglpenghapusankemenkes, t.tglpengiriminkemenkes, t.tglubahpengirimankemenkes, t.pegawaipenghapusankemenkes, t.pegawaipengirimkemenkes, t.pegawaiubahpengirimankemenkes";
                
		$criteria->addCondition('t.kamarruangan_aktif = true');
                $criteria->compare('LOWER(t.kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar),true);
                $criteria->compare('LOWER(t.kamarruangan_nobed)', strtolower($this->kamarruangan_nobed),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_m.ruangan_id = ".$this->ruangan_id); 	
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
