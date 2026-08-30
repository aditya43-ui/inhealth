<?php
class LBLaporanpemeriksaanrujukanrsV extends LaporanpemeriksaanrujukanrsV
{
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $nama_pasien,$no_rekam_medik,$tglmasukpenunjang;
        public $jmlbayar_tindakan,$jmlsisabayar_tindakan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchGrafik() {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            $criteria->select = 'count(t.tglmasukpenunjang) as jumlah, t.ruanganasal_nama as data';
            $criteria->group = 't.ruanganasal_nama';
            $criteria->order = "jumlah DESC";
			
			return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
			
			
        }

        public function searchTableLaporan() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            $criteria->order = "t.tglmasukpenunjang ASC";
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchPrintLaporan() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria = $this->functionCriteria();
            $criteria->order = "t.tglmasukpenunjang ASC";
            return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
        }
        protected function functionCriteria() {
            $criteria = new CDbCriteria();
//            print_r($this->tgl_awal);
//            exit;
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(t.tglmasukpenunjang)',$this->tgl_awal,$this->tgl_akhir);
            $criteria->select = 't.namadepan, t.daftartindakan_kode, t.daftartindakan_nama,t.tarif_satuan,t.no_pendaftaran,t.tglmasukpenunjang,pasien_m.nama_pasien,pasien_m.no_rekam_medik,
                                sum(t.qty_tindakan) as qty_tindakan,
                                sum(tindakansudahbayar_t.jmlbayar_tindakan) as jmlbayar_tindakan,
                                sum(tindakansudahbayar_t.jmlsisabayar_tindakan) as jmlsisabayar_tindakan,
                                sum(t.tarif_satuan * t.qty_tindakan) as total';
            $criteria->join = 'JOIN pendaftaran_t on pendaftaran_t.pendaftaran_id = t.pendaftaran_id 
                               JOIN pasien_m on pasien_m.pasien_id = pendaftaran_t.pasien_id
                               LEFT JOIN tindakansudahbayar_t on tindakansudahbayar_t.tindakansudahbayar_id = t.tindakansudahbayar_id';
            $criteria->group = 't.namadepan, t.daftartindakan_kode, t.daftartindakan_nama, t.tarif_satuan, t.no_pendaftaran, t.tglmasukpenunjang, pasien_m.nama_pasien, pasien_m.no_rekam_medik';
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition('t.tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
			}
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition('t.daftartindakan_id = '.$this->daftartindakan_id);
			}
            $criteria->compare('LOWER(t.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(t.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
            $criteria->compare('LOWER(t.daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition('t.pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
			}
            $criteria->compare('LOWER(t.t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('t.tarif_satuan',$this->tarif_satuan);
            $criteria->compare('t.qty_tindakan',$this->qty_tindakan);
            $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
			if(!empty($this->tindakansudahbayar_id)){
				$criteria->addCondition('t.tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
			}
            $criteria->compare('LOWER(t.tgl_tindakan)',strtolower($this->tgl_tindakan),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->pasienkirimkeunitlain_id)){
				$criteria->addCondition('t.pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
            $criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
            $criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
            $criteria->compare('LOWER(t.nourut)',strtolower($this->nourut),true);
            $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);            
            $criteria->addCondition(" t.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            return $criteria;
        }   
        
        public function getTotal()
        {
            return $this->tarif_satuan * $this->qty_tindakan;
        }  
}
?>