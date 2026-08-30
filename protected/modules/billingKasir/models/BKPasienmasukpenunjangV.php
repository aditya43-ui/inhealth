<?php

class BKPasienmasukpenunjangV extends PasienmasukpenunjangV
{
        public $instalasi_id; //untuk pencarian ruangan
        public $instalasi_nama;
        public $tglselesaiperiksa;
        public $tglpembayaran;
        public $nopembayaran;
        public $pembayaran_id, $nobuktibayar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * menampilkan pasien masuk penunjang group by pendaftaran
         */
        public function criteriaGroupByPendaftaran(){
            $criteria = new CDbCriteria();
            $criteria->group = 'pasien_id, no_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, '
                    . 'alamatemail, statusrekammedis, statusperkawinan, ispasienluar, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, '
                    . 'pekerjaan_id, pekerjaan_nama, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, keadaanmasuk, statuspasien, alihstatus, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, '
                    . 'caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj';
            $criteria->select = $criteria->group;
            if(!empty($this->instalasi_id)){
                $ruangan_ids = array();
                $modRuangans = RuanganM::model()->findAllByAttributes(array("instalasi_id"=>$this->instalasi_id), "ruangan_aktif = true");
                if (count((array)$modRuangans) > 0){
                    foreach($modRuangans AS $i => $ruangan){
                        $ruangan_ids[$i] = $ruangan->ruangan_id;
                    }
                    $criteria->addInCondition("ruangan_id", $ruangan_ids);
                }
            }
            return $criteria;
        }
        
        /**
         * menampilkan data kunjungan pasien 
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjungan(){
            $format = new MyFormatter();
            $criteria = $this->criteriaGroupByPendaftaran();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        /**
         * menampilkan terakhir masuk penunjang
         */
        public function getPenunjangAkhir(){
            $criteria = new CdbCriteria();
            if(!empty($this->pendaftaran_id)){
                $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
                $criteria->order = "pasienmasukpenunjang_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }
            if(isset($model)){
                return $model;
            }else{
                return new $this;
            }
            
        }
                
}