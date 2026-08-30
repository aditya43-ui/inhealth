<?php
class LBLaporanpemeriksaangroupV extends LaporanpemeriksaangroupV
{
	public $bayartindakan,$sisatindakan,$total_biaya;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $data,$jumlah,$tick;
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
//        public function searchGrafik()
//        {
//            $data = $this->getGrafikPemeriksaan();
//            return $data;
//            /*
//            $criteria = new CDbCriteria;
//            $criteria->select = "count(date_part('Month',tgl_tindakan)) as jumlah, TO_CHAR(tgl_tindakan,'Mon') as data";
//            $criteria->group = 'tgl_tindakan';
//            $criteria = $this->functionCriteria();
//            
//            return new CActiveDataProvider($this,
//                array(
//                    'criteria' => $criteria,
//                    'pagination' => false,
//                )
//            );
//             */
//        }

        public function searchTableLaporan()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }

        public function searchGrafik() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
			$criteria->group = 'carabayar_nama';
			
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
            $criteria->addCondition("ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            return new CActiveDataProvider($this, array(
                        'pagination' => false,
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
        
        public function getTotalBiaya()
        {
            return 125;
        }  
        
        private function getGrafikPemeriksaan()
        {
            $cond = array(
                "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "tindakanpelayanan_t.ruangan_id = 18"
            );
            
            if(is_array($this->carabayar_id) && count($this->carabayar_id) > 0)
            {
                $cond[] = 'tindakanpelayanan_t.carabayar_id IN (' . implode(",", $this->carabayar_id) . ')';
            }
            $query = "
                SELECT
                    COUNT(tindakanpelayanan_t.pendaftaran_id) as jumlah,
                    carabayar_m.carabayar_nama as data
                FROM tindakanpelayanan_t
                JOIN carabayar_m ON 
                        tindakanpelayanan_t.carabayar_id = carabayar_m.carabayar_id
                 ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                GROUP BY carabayar_m.carabayar_nama
            ";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data);
        }
        
        /**
         * HINDARI PENGGUNAAN SQL MANUAL (SELECT) GUNAKAN CdbCriteria
         * UNTUK MODEL DARI VIEW DATABASE JANGAN ADA JOIN
         * CONTOH YG SALAH :
         * @return \CArrayDataProvider
         */
        public function searchLaporanPemeriksaan()
        {
            $cond = array(
                "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "tindakanpelayanan_t.ruangan_id = 18"
            );
            
            if(is_array($this->carabayar_id) && count($this->carabayar_id) > 0)
            {
                $cond[] = 'tindakanpelayanan_t.carabayar_id IN (' . implode(",", $this->carabayar_id) . ')';
            }
            $query = "select
                    tindakanpelayanan_t.pendaftaran_id as id,
                    pendaftaran_t.no_pendaftaran,
                    pasien_m.nama_pasien,
                    pasien_m.alamat_pasien,
                    carabayar_m.carabayar_nama,
                    SUM(tindakanpelayanan_t.qty_tindakan * tindakanpelayanan_t.tarif_satuan) AS total_biaya,
                    SUM(tindakansudahbayar_t.jmlbayar_tindakan) AS bayartindakan,
                    SUM(tindakansudahbayar_t.jmlsisabayar_tindakan) AS sisatindakan
                FROM tindakanpelayanan_t
                 JOIN pasienmasukpenunjang_t ON 
                        tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                 LEFT JOIN tindakansudahbayar_t ON 
                        tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                 JOIN pendaftaran_t ON
                        pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                 JOIN pasien_m ON 
                        pendaftaran_t.pasien_id = pasien_m.pasien_id
                 JOIN penjaminpasien_m ON
                        pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
                 JOIN carabayar_m ON 
                        pendaftaran_t.carabayar_id = carabayar_m.carabayar_id	
                 ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                GROUP BY tindakanpelayanan_t.pendaftaran_id,pendaftaran_t.no_pendaftaran,pasien_m.nama_pasien,pasien_m.alamat_pasien, carabayar_m.carabayar_nama
                ORDER BY tindakanpelayanan_t.pendaftaran_id, pendaftaran_t.no_pendaftaran
            ";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data);
        }        
        
        /* END CONTOH */
        /**
         * digunakan di:
         * - searchLaporanCarabayar()
         * - searchLaporanRincianCarabayar()
         * - views/laporan/pemeriksaanCaraBayar/_printLaporan
         * @param type $tipe = pendaftaran | rincian
         * @return \CDbCriteria
         */
        public function criteriaCarabayar($tipe = ""){
            $criteria = new CDbCriteria();
            $ruangan = array(Params::RUANGAN_ID_LAB,Params::RUANGAN_ID_RAD);
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $criteria->addBetweenCondition('DATE(tgl_tindakan)',$this->tgl_awal,$this->tgl_akhir);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            if(is_array($this->penjamin_id)){
                $criteria->addInCondition('penjamin_id',$this->penjamin_id);
            }else{
				if(!empty($this->penjamin_id)){
					$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
				}
            }
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            //$criteria->addInCondition('ruangan_id',$ruangan);
            $criteria->addCondition("ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            if($tipe == 'pendaftaran'){
                $criteria->group = "pendaftaran_id, no_pendaftaran, 
                pasien_id, nama_pasien, alamat_pasien, 
                carabayar_id, carabayar_nama, 
                penjamin_id, penjamin_nama, tgl_tindakan";
                $criteria->select = $criteria->group.", SUM(tarif_satuan * qty_tindakan) AS total_biaya, 
                        SUM(jmlbayar_tindakan) AS bayartindakan,
                        SUM(jmlsisabayar_tindakan) AS sisatindakan";
            }else if($tipe == 'rincian'){
                $criteria->group = "pendaftaran_id, no_pendaftaran, 
                pasien_id, nama_pasien, alamat_pasien, 
                carabayar_id, carabayar_nama, 
                penjamin_id, penjamin_nama,
                pasienmasukpenunjang_id, no_masukpenunjang,
                daftartindakan_id, daftartindakan_nama, tgl_tindakan";
                $criteria->select = $criteria->group.", SUM(tarif_tindakan) AS total_biaya, 
                        SUM(jmlbayar_tindakan) AS bayartindakan,
                        SUM(jmlsisabayar_tindakan) AS sisatindakan";
            }
            $criteria->order ='tgl_tindakan asc';
            return $criteria;
        }


        public function searchLaporanCarabayar(){
            $criteria = $this->criteriaCarabayar('pendaftaran');
            $pagination = array('pageSize'=>10);
            
            return new CActiveDataProvider($this, array(
                        'pagination' => $pagination,
                        'criteria' => $criteria,
                    ));
        }
        
        public function searchPrintLaporanCarabayar(){
            $criteria = $this->criteriaCarabayar('pendaftaran');
            $criteria->limit = -1;
            $pagination = false;
            
            return new CActiveDataProvider($this, array(
                        'pagination' => $pagination,
                        'criteria' => $criteria,
                    ));
        }
        
        
        public function searchLaporanRincianCarabayar(){
            $criteria = $this->criteriaCarabayar('rincian');
            
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        
        public function searchPrintLaporanRincianCarabayar(){
            $criteria = $this->criteriaCarabayar('rincian');
            $criteria->limit = -1;
            $pagination = false;
            return new CActiveDataProvider($this, array(
                        'pagination' => $pagination,
                        'criteria' => $criteria,
                    ));
        }
        
        
        
        
        public function searchLaporanRincianPemeriksaan()
        {
            $cond = array(
                "DATE(tindakanpelayanan_t.tgl_tindakan) BETWEEN '". $this->tgl_awal ."' AND '". $this->tgl_akhir ."'",
                "pasienmasukpenunjang_t.ruangan_id = 18"
            );
            if(is_array($this->carabayar_id) && count($this->carabayar_id) > 0)
            {
                $cond[] = 'tindakanpelayanan_t.carabayar_id IN (' . implode(",", $this->carabayar_id) . ')';
            }
            $query = "
                SELECT
                    tindakanpelayanan_t.pendaftaran_id as id,
                    pasienmasukpenunjang_t.pasienmasukpenunjang_id,
                    pasienmasukpenunjang_t.no_masukpenunjang,
                    tindakanpelayanan_t.pendaftaran_id,
                    pendaftaran_t.no_pendaftaran,
                    pasien_m.nama_pasien,
                    daftartindakan_m.daftartindakan_nama,
                    carabayar_m.carabayar_nama,
                    pasienmasukpenunjang_t.statusperiksa,
                    SUM(tindakansudahbayar_t.jmlbayar_tindakan) AS bayartindakan,
                    SUM(tindakansudahbayar_t.jmlsisabayar_tindakan) AS sisatindakan,
                    SUM(tindakanpelayanan_t.qty_tindakan * tindakanpelayanan_t.tarif_satuan) AS total_biaya
                from tindakanpelayanan_t
                 JOIN pasienmasukpenunjang_t ON 
                        tindakanpelayanan_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
                 LEFT JOIN tindakansudahbayar_t ON 
                        tindakanpelayanan_t.tindakansudahbayar_id = tindakansudahbayar_t.tindakansudahbayar_id
                 JOIN daftartindakan_m ON 
                        tindakanpelayanan_t.daftartindakan_id = daftartindakan_m.daftartindakan_id
                 JOIN pendaftaran_t ON
                        pasienmasukpenunjang_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                 JOIN pasien_m ON 
                        pendaftaran_t.pasien_id = pasien_m.pasien_id
                 JOIN penjaminpasien_m ON
                        pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
                 JOIN carabayar_m ON 
                        pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                 	
                ". (count($cond) > 0 ? " WHERE " . implode(" AND ", $cond) : "" ) ."
                GROUP BY  tindakanpelayanan_t.pendaftaran_id,pasienmasukpenunjang_t.pasienmasukpenunjang_id,
                          pasienmasukpenunjang_t.no_masukpenunjang,pendaftaran_t.no_pendaftaran,
                          carabayar_m.carabayar_nama,pasien_m.nama_pasien,pasienmasukpenunjang_t.statusperiksa,daftartindakan_m.daftartindakan_nama
                ORDER BY tindakanpelayanan_t.pendaftaran_id, pasienmasukpenunjang_t.statusperiksa
            ";
            $data = Yii::app()->db->createCommand($query)->queryAll();
            return new CArrayDataProvider($data);
        }
        
        public function getNamaModel() {
            return __CLASS__;
        }
}
?>