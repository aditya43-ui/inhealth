<?php

class ASPendaftaranT extends PendaftaranT
{
        public $tgl_pendaftaran_cari,$dokter,$penanggungJawab,$no_rekam_medik,$nama_pasien,$alamat_pasien;
        public $cari_instalasi_id;
        public $cari_no_pendaftaran;
        public $tgl_awal, $tgl_akhir;
        public $instalasis,$kamarruangan_nobed,$diagnosa_nama,$nama_pegawai,$tglpulang,$pendidikan;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
         public function searchPendaftaranPasienKlaim()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with=array('pasien','penanggungJawab');
                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat_pasien),true);
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
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
                $criteria->compare('no_urutantri',$this->no_urutantri);
                $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
                $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
                $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
                $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
                $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
                $criteria->compare('alihstatus',$this->alihstatus);
                $criteria->compare('byphone',$this->byphone);
                $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
                $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
                $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
                $criteria->compare('status_konfirmasi',$this->status_konfirmasi);
		        $criteria->compare('date(tgl_konfirmasi)',$this->tgl_konfirmasi);
                
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        /**
         * menampilkan instalasi untuk pembayaran
         * @return array
         */
        public function getInstalasis(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI) 
                    );
            $criteria->addCondition('instalasi_aktif = true');
            $criteria->order = 'instalasi_id';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return array();
        }
        /**
         * untuk pencarian dialog pendaftaran pasien
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien','instalasi','ruangan');
            $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat_pasien),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);					
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('tgl_pendaftaran',strtolower($this->tgl_pendaftaran),true);
            if(!empty($this->tgl_pendaftaran_cari))
                $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_pendaftaran_cari." 00:00:00",$this->tgl_pendaftaran_cari." 23:59:59");
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
            $criteria->order = "no_pendaftaran";
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }

         public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true,'carabayar_id'=>$carabayar_id),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }

        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$instalasi_id);					
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
        
        public function getInstalasiUangMukaItems(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD, 
                        Params::INSTALASI_ID_RI,
                        Params::INSTALASI_ID_LAB,
                    ));
            $criteria->order = 'instalasi_nama';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return null;
        }
        /**
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public static function getKelasPelayananItems()
        {
            return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
        }
        /**
        * mengambil data jenis kasus penyakit berdasarkan ruangan
        * @param type $ruangan_id
        */
        public static function getJenisKasusPenyakitItems($ruangan_id = null)
        {            
            if(empty($ruangan_id)){
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
            }
            $criteria = new CdbCriteria();
            $criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
            $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
            $criteria->order = "t.jeniskasuspenyakit_nama";
            $criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
            return JeniskasuspenyakitM::model()->findAll($criteria);
        }
        /**
         * menampilkan dokter 
         * @param type $ruangan_id
         * @return type
         */
        public static function getDokterItems($ruangan_id='')
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
		
		/**
         * menampilkan nama lengkap dokter
         */
        public function getNamaDokter(){
            if(!empty($this->pegawai_id)){
                $modPegawai = PegawaiM::model()->findByPk($this->pegawai_id);
                return $modPegawai->gelardepan." ".$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? " ".$modPegawai->gelarbelakang->gelarbelakang_nama : "");
            }else{
                return null;
            }
        }
}