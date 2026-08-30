<?php
class STLaporanpengirimansterilisasiV extends LaporanpengirimansterilisasiV
{
    public $tgl_awal, $tgl_akhir, $sterilisasi_jam;
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
                
                $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		if(!empty($this->sterilisasidetail_jml)){
			$criteria->addCondition('sterilisasidetail_jml = '.$this->sterilisasidetail_jml);
		}
		$criteria->compare('LOWER(sterilisasidetail_ket)',strtolower($this->sterilisasidetail_ket),true);
		$criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
		$criteria->compare('LOWER(menerima)',strtolower($this->menerima),true);
		$criteria->compare('LOWER(mengetahui_k)',strtolower($this->mengetahui_k),true);
		$criteria->compare('LOWER(menerima_k)',strtolower($this->menerima_k),true);

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
