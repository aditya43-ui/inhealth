<?php
class LBLaporanpemeriksaanp3V extends Laporanpemeriksaanp3V
{
	public $total_biaya;
        public $jns_periode;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
       public function searchGrafik() {
            $criteria = new CDbCriteria;
            $criteria->select = "count(date_part('Month',tgl_tindakan)) as jumlah, TO_CHAR(tgl_tindakan,'Mon') as data";
            $criteria->group = 'tgl_tindakan';
            $criteria = $this->functionCriteria();
            
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        public function searchTableLaporan() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchPrintLaporan() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria = $this->functionCriteria();

            return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
        }

        protected function functionCriteria() {
            $criteria = new CDbCriteria();
            
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(tgl_tindakan)',$this->tgl_awal,$this->tgl_akhir);
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
            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id = '.$this->pasien_id);
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('jmlbayar_tindakan',$this->jmlbayar_tindakan);
            $criteria->compare('jmlsisabayar_tindakan',$this->jmlsisabayar_tindakan);

            return $criteria;
        }   
        
        public function getTotal()
        {
            return $this->tarif_satuan * $this->qty_tindakan;
        }  
}
?>