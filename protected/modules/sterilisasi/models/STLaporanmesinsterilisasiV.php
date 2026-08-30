<?php
class STLaporanmesinsterilisasiV extends LaporanmesinsterilisasiV
{
    public $tgl_awal, $tgl_akhir, $sterilisasi_jammulai, $sterilisasi_jamselesai, $sterilisasi_hasil;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
        public function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $format = new MyFormatter();
                
		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
                $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
                $criteria->addBetweenCondition('DATE(sterilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
                
                if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(sterilisasi_no)',strtolower($this->sterilisasi_no),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		if(!empty($this->sterilisasidetail_jml)){
			$criteria->addCondition('sterilisasidetail_jml = '.$this->sterilisasidetail_jml);
		}
		$criteria->compare('LOWER(sterilisasidetail_ket)',strtolower($this->sterilisasidetail_ket),true);

		return $criteria;
	}
        
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
}
