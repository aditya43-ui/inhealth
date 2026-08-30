<?php

class RDPendaftaranT extends PendaftaranT
{    
    public $noRm, $namaInstalasi, $namaRuangan, $namaCarabayar, $tgl_pendaftaran_cari, $statusperiksa, $namaPasien, $LamaRawat; //untuk filter grid / dialog box
	public $jeniskasuspenyakit_nama;
	public $kelaspelayanan;
        public $carabayar_nama, $penjamin_nama, $spesialissubspesialis_id, $alamat_pasien, $no_rekam_medik;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchRiwayat($data)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
			}
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);				
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);				
			}
			if(!empty($this->shift_id)){
				$criteria->addCondition("shift_id = ".$this->shift_id);				
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);				
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
			}
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
			}
			if(!empty($this->penanggungjawab_id)){
				$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
			}
            $criteria->condition = "pasien_id = ".$data;
			
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
        /**
        * searchPasienRD menampilkan pasien rawat darurat untuk dialog box di:
         * - transaksi - pasien pulang
        * @return \CActiveDataProvider
        */
        public function searchPasienRD(){
           $format = new MyFormatter;
           $criteria = new CDbCriteria();
           $criteria->with = array('pasien','instalasi','ruangan', 'carabayar');
           $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
           if(!empty($this->tgl_pendaftaran_cari)){
               $this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
               $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_pendaftaran_cari." 00:00:00", $this->tgl_pendaftaran_cari." 23:59:59");
           }
           $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->noRm), true);
           $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->namaPasien), true);
           $criteria->compare('LOWER(instalasi.instalasi_nama)', strtolower($this->namaInstalasi), true);
           $criteria->compare('LOWER(ruangan.ruangan_nama)', strtolower($this->namaRuangan), true);
           $criteria->compare('LOWER(carabayar.carabayar_nama)', strtolower($this->namaCarabayar), true);
           $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
           $criteria->addCondition("pasienbatalperiksa_id is null and pendaftaran_id is not null");
           $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
           $criteria->addNotInCondition("statusperiksa", array("SUDAH PULANG"));
           $criteria->addInCondition('ispasienluar',array(false));
           $criteria->limit = 50;
           $criteria->order = 'tgl_pendaftaran DESC';
           //kembalikan format
           $this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y',strtotime($this->tgl_pendaftaran_cari));
           return new CActiveDataProvider($this, array(
                       'criteria'=>$criteria,
               ));
        }
        //=== Start functions untuk dialogpendaftaran ===
        public function getJenisKasusPenyakitNama(){
			if(!empty($this->jeniskasuspenyakit_id)){
				return $this->jeniskasuspenyakit->jeniskasuspenyakit_nama;
			}else{
				return null;
			}
        }
        public function getInstalasiNama(){
            return $this->instalasi->instalasi_nama;
        }
        public function getRuanganNama(){
            return $this->ruangan->ruangan_nama;
        }
        public function getPasienNama(){
            return $this->pasien->nama_pasien;
        }
        public function getPasienJenisKelamin(){
            return $this->pasien->jeniskelamin;
        }
        public function getPasienNoRm(){
            return $this->pasien->no_rekam_medik;
        }
        public function getPasienAlias(){
            return $this->pasien->nama_bin;
        }
        public function getCarabayarNama(){
            return $this->carabayar->carabayar_nama;
        }
        public function getPenjaminNama(){
            return $this->penjamin->penjamin_nama;
        }
        public function getPegawaiNama(){
            return $this->pegawai->NamaLengkap;
        }
        
         public function getStatusPeriksa()
        {
            return RDPendaftaranT::model()->findAll('statusperiksa_aktif=true ORDER BY statusperiksa');
        }
        
        public function getRuanganItems($instalasi_id=null)
        {
          if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
          }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
          }
        }

        /**
        * menampilkan dokter 
        * @param type $ruangan_id
        * @return type
        */
      public function getDokterItems($ruangan_id='')
      {
        $criteria = new CdbCriteria();
        if(!empty($ruangan_id)){
          $criteria->addCondition("ruangan_id = ".$ruangan_id);   
        }
        $criteria->addCondition('pegawai_aktif = true');
        $criteria->order = "nama_pegawai, gelardepan";
        $modDokter = DokterV::model()->findAll($criteria);
        return $modDokter;
      }

      public function getDokterKondisi()
      {
        $criteria = new CdbCriteria();
        
        $criteria->addCondition('instalasi_id = 3 or jabatan_id = 23');   
        
        $criteria->addCondition('pegawai_aktif = true');
        $criteria->order = "nama_pegawai, gelardepan";
        $modDokter = DokterV::model()->findAll($criteria);
        return $modDokter;
      }

      public function getDokterALL()
      {
        $criteria = new CdbCriteria();
        
        $criteria->addCondition("instalasi_id != 3 and jabatan_id != 23 and gelarbelakang_nama != 'Sp.EM'");   
        
        $criteria->addCondition('pegawai_aktif = true');
        $criteria->order = "nama_pegawai, gelardepan";
        $modDokter = DokterV::model()->findAll($criteria);
        return $modDokter;
      }

      public function getKelasPelayananItems()
      {
              return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true ORDER BY kelaspelayanan_nama');
      }
}
?>
