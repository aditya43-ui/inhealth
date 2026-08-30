<?php
class BDLaporanpemeriksaanpenunjangV extends LaporanpemeriksaanpenunjangV
{
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchGrafik()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            $criteria->select = "count(date_part('Month',tgl_tindakan)) AS jumlah, TO_CHAR(tgl_tindakan,'Mon') AS data";
            $criteria->group = "TO_CHAR(tgl_tindakan,'Mon')";
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        public function searchTableLaporan()
        {
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
            $format = new MyFormatter();
            
            $criteria->select = 'daftartindakan_kode, daftartindakan_nama,tarif_satuan, 
                                sum(qty_tindakan) as qty_tindakan,
                                sum(tarif_satuan * qty_tindakan) as total';
			
			$criteria->join ='join pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id';
			$criteria->addCondition('pasienmasukpenunjang_t.ruangan_id = '.PARAMS::RUANGAN_ID_RAD);
            $criteria->group = 'daftartindakan_kode, daftartindakan_nama, tarif_satuan';
            
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
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

            return $criteria;
        }   
        
         protected function criteriaBayarPeriksa() {
            $criteria = new CDbCriteria();

            if($this->daftartindakan_nama == 'Biaya Administrasi'){
                $adm = 'Biaya Administrasi';
                $criteria->select = 'nama_pasien,pendaftaran_id,alamat_pasien,tgl_pendaftaran,no_pendaftaran,nama_pegawai,
                                sum(tarif_satuan * t.qty_tindakan) as administrasi,
                                sum(totaldiscount) as totaldiscount,
                                sum(totalsisatagihan) as totalsisatagihan,
                                sum(totalbayartindakan) as totalbayartindakan,
                                CASE daftartindakan_nama
                               WHEN "Biaya Administrasi" THEN SUM(qty_tindakan*tarif_satuan) END AS administrasi';
                $criteria->addBetweenCondition('DATE(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir,true);
                $criteria->compare('LOWER(daftartindakan_nama)',strtolower($adm));
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran));
            }
            $criteria->select = 'nama_pasien,pendaftaran_id,alamat_pasien,tgl_pendaftaran,no_pendaftaran,nama_pegawai,
                                sum(tarif_satuan * qty_tindakan) as total,
                                sum(totaldiscount) as totaldiscount,
                                sum(totalsisatagihan) as totalsisatagihan,
                                sum(totalbayartindakan) as totalbayartindakan';
            $criteria->group = 'nama_pasien,pendaftaran_id,alamat_pasien,tgl_pendaftaran,no_pendaftaran,nama_pegawai';
            $criteria->addBetweenCondition('DATE(tglpembayaran)',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran));

            return $criteria;
        } 
        
        public function searchLaporanPembayaranPemeriksaan()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->criteriaBayarPeriksa();

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchPrintLaporanPembayaranPemeriksaan() 
        {
            $criteria = new CDbCriteria;

            $criteria = $this->criteriaBayarPeriksa();
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'pagination' => false,
                        'criteria' => $criteria,
                    ));
        }
        
        public function getTotal()
        {
            return $this->tarif_satuan * $this->qty_tindakan;
        }  
}

?>