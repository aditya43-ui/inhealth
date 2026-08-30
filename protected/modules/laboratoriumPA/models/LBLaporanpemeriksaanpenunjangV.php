<?php
class LBLaporanpemeriksaanpenunjangV extends LaporanpemeriksaanpenunjangV
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
            $criteria->select = "count(date_part('Month',t.tgl_tindakan)) AS jumlah, TO_CHAR(t.tgl_tindakan,'Mon') AS data";
            $criteria->group = "TO_CHAR(t.tgl_tindakan,'Mon')";
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
            $criteria->join = " JOIN tindakanpelayanan_t tp ON tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
            $criteria->select = 't.daftartindakan_kode, t.daftartindakan_nama,t.tarif_satuan, 
                                sum(t.qty_tindakan) as qty_tindakan,
                                sum(t.tarif_satuan * t.qty_tindakan) as total';
            
            $criteria->group = 't.daftartindakan_kode, t.daftartindakan_nama, t.tarif_satuan';
            
            $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(t.tgl_tindakan)',$this->tgl_awal,$this->tgl_akhir);
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
            $criteria->compare('LOWER(t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('t.tarif_satuan',$this->tarif_satuan);
            $criteria->compare('t.qty_tindakan',$this->qty_tindakan);
            $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->addCondition(" tp.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
			if(!empty($this->tindakansudahbayar_id)){
				$criteria->addCondition('t.tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
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