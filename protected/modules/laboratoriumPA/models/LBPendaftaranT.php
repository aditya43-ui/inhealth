<?php

class LBPendaftaranT extends PendaftaranT
{
        public $is_adapjpasien = 0;
        public $is_pasienrujukan = 0;
        public $dokter;
        public $carabayar_nama,$penjamin_nama,$nama_pegawai,$diagnosa,$jeniskasuspenyakit_nama,$kelaspelayanan_nama;
		public $is_asubadak = 0;
		public $is_asudepartemen = 0;
		public $is_asupekerja = 0;
		public static function model($className=__CLASS__)
		{
			return parent::model($className);
		}
		
        public function rules()
        {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                        array('kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id, pegawai_id, ruangan_id, jeniskasuspenyakit_id, kelaspelayanan_id, carabayar_id, penjamin_id', 'required'),
                        array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id', 'numerical', 'integerOnly'=>true),
                        array('no_pendaftaran', 'length', 'max'=>20),
                        array('no_urutantri', 'length', 'max'=>6),
                        array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk,status_konfirmasi', 'length', 'max'=>50),
                        array('umur', 'length', 'max'=>30),
                        array('alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, tglrenkontrol, statusfarmasi', 'safe'),
                        // The following rule is used by search().
                        // Please remove those attributes that should not be searched.
                        array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur,tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi', 'safe', 'on'=>'search'),
                );
        }


        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public static function getRuanganPenunjangItems($instalasi_id = null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganpenunjangV::model()->findAll($criteria);
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
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public static function getKelasPelayananItems($ruangan_id = null)
        {
            if($ruangan_id==null){
                return array();
            }else{
               $criteria = new CdbCriteria();
                $criteria->join = "JOIN kelasruangan_m on t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
                $criteria->addCondition('t.kelaspelayanan_aktif = true');
                $criteria->addCondition('kelasruangan_m.ruangan_id ='.$ruangan_id);
                $criteria->order = "t.urutankelas";
                return KelaspelayananM::model()->findAll($criteria);
            } 
        }

        /**
         * Mengambil daftar semua kelaspelayanan 
         * @return CActiveDataProvider 
         */
        public static function getKelasPelayanan()
        {
            return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
        }
            

        /**
         * Mengambil daftar semua carabayar
         * @return CActiveDataProvider 
         */
        public static function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public static function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
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
				$criteria->addCondition('ruangan_id = '.$ruangan_id);
			}
            $criteria->addCondition('pegawai_aktif = true');
            $criteria->order = "nama_pegawai, gelardepan";
            $modDokter = DokterV::model()->findAll($criteria);
            return $modDokter;
        }

         /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran Laboratorium
         * @return \CActiveDataProvider
         */
        public function searchRiwayatPasien(){
            $criteria=new CDbCriteria;
            $criteria->addCondition('pasien_id = '.$this->pasien_id); 
            $criteria->addCondition('ruangan_id = '.Params::RUANGAN_ID_LAB_ANATOMI);
            $criteria->order = 'tgl_pendaftaran desc';          
            $criteria->limit = 5;          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getRuanganLab()
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganlabpaV::model()->findAll($criteria);
        }
		
}
?>
