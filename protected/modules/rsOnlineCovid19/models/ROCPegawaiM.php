<?php

class ROCPegawaiM extends PegawaiM
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
                $criteria->join = " LEFT JOIN jabatan_m ON jabatan_m.jabatan_id = t.jabatan_id"
                        . " JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = t.kelompokpegawai_id"
                        . " LEFT JOIN gelarbelakang_m gelarbelakang ON gelarbelakang.gelarbelakang_id = t.gelarbelakang_id";
                $criteria->select = "t.gelardepan, t.nama_pegawai, t.pegawai_id, jabatan_m.jabatan_nama, kelompokpegawai_m.kelompokpegawai_nama, gelarbelakang.gelarbelakang_id,gelarbelakang.gelarbelakang_nama, t.tglpenghapusankemenkes, t.tglpengiriminkemenkes, t.tglubahpengirimankemenkes, t.pegawaipenghapusankemenkes, t.pegawaipengirimkemenkes, t.pegawaiubahpengirimankemenkes";
                
		$criteria->addCondition('t.pegawai_aktif = true');
                $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai),true);
                
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition("t.kelompokpegawai_id = ".$this->kelompokpegawai_id); 	
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
