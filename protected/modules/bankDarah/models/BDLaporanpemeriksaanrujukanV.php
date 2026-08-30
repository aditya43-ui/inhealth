<?php
class BDLaporanpemeriksaanrujukanV extends LaporanpemeriksaanrujukanV
{
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $no_pendaftaran;
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        public function searchGrafik()
        {
            $criteria = new CDbCriteria();
			
			$criteria->select = 'count(pendaftaran_id) as jumlah, asalrujukan_nama as data';
			$criteria->group = 'asalrujukan_nama';
			
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
			}
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
			}
            $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
			}
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('tarif_satuan',$this->tarif_satuan);
            $criteria->compare('qty_tindakan',$this->qty_tindakan);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
			if(!empty($this->tindakansudahbayar_id)){
				$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
			}
            $criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->rujukan_id)){
				$criteria->addCondition('rujukan_id = '.$this->rujukan_id);
			}
			if(!empty($this->asalrujukan_id)){
				$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
			}
            $criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
            $criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
            $criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
            $criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
            return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
        }
        
        public function searchTableLaporan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        public function searchPrintLaporan()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this,
                array(
                    'pagination' => false,
                    'criteria' => $criteria,
                )
            );
        }

        protected function functionCriteria()
        {
            $criteria = new CDbCriteria();
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
			}
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
			}
            $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
			}
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('tarif_satuan',$this->tarif_satuan);
            $criteria->compare('qty_tindakan',$this->qty_tindakan);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
			if(!empty($this->tindakansudahbayar_id)){
				$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
			}
            $criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->rujukan_id)){
				$criteria->addCondition('rujukan_id = '.$this->rujukan_id);
			}
			if(!empty($this->asalrujukan_id)){
				$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
			}
            $criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
            $criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
            $criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
            $criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
            $criteria->order = "pendaftaran_id";
            return $criteria;
        }
        
        public function getTotal()
        {
            return $this->tarif_satuan * $this->qty_tindakan;
        }  
               
}
?>