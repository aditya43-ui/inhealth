<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PJPendaftaranT extends PendaftaranT
{        
        public $kasusPenyakitNama;
        public $dokterNama;
        public $kelompokumurNama;
        public $kelompokumurId;
        public $penjaminNama;
        public $ruanganNama;
        public $is_pasienrujukan = 0;
        public $is_asuransi = 0;
        public $is_penanggungjawab = 0;
        public $is_karcis = 0;
        public $is_pasien_lama = 0;
        public $noRekamMedik;

        public $is_adapjpasien = 0;

        public $diagnosa;

        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return PPPendaftaranRj the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                // NOTE: you should only define rules for those attributes that
                // will receive user inputs.
                return array(
                        array('pegawai_id, pasien_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, 
                               statusmasuk, umur, ruangan_id, carabayar_id, penjamin_id, kelaspelayanan_id, jeniskasuspenyakit_id', 'required'),
                        array('penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_urutantri', 'numerical', 'integerOnly'=>true),
                        array('no_pendaftaran', 'length', 'max'=>20),
                        array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk', 'length', 'max'=>50),
                        array('umur', 'length', 'max'=>30),
                        array('pegawai_id, alihstatus, byphone, kunjunganrumah, nopendaftaran_aktif, no_asuransi, namapemilik_asuransi
                                  nopokokperusahaan, kelastanggungan_id, namaperusahaan', 'safe'),

                        array('noRekamMedik, namaPasien, namaBin, alamat, propinsi, kabupaten, kecamatan, kelurahan, 
                               kasusPenyakitNama, dokterNama, kelompokumurNama, kelompokumurId, penjaminNama,
                               ruanganNama','safe','on'=>'searchPasienPendaftaran'),

                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),

                        // The following rule is used by search().
                        // Please remove those attributes that should not be searched.
                        array('pendaftaran_id, penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, create_time, upate_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan, nopendaftaran_aktif', 'safe', 'on'=>'search'),
                );
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                        'pendaftaran_id' => 'Pendaftaran',
                        'penjamin_id' => 'Penjamin',
                        'caramasuk_id' => 'Cara masuk',
                        'carabayar_id' => 'Jenis Penjamin',
                        'pegawai_id' => 'Dokter',

                        'pasien_id' => 'ID Pasien',
                        'shift_id' => 'Shift',
                        'golonganumur_id' => 'Golongan Umur',
                        'kelaspelayanan_id' => 'Kelas pelayanan',
                        'rujukan_id' => 'Rujukan',
                        'penanggungjawab_id' => 'Penanggungjawab',
                        'ruangan_id' => 'Ruangan Tujuan',
                        'instalasi_id' => 'Instalasi',
                        'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
                        'no_pendaftaran' => 'No. Pendaftaran',
                        'tgl_pendaftaran' => 'Tgl. Pendaftaran',
                        'no_urutantri' => 'No. Urut Antri',
                        'transportasi' => 'Transportasi',
                        'keadaanmasuk' => 'Keadaan Masuk',
                        'statusperiksa' => 'Status Periksa',
                        'statuspasien' => 'Status Pasien',
                        'kunjungan' => 'Kunjungan',
                        'alihstatus' => 'Alih Status',
                        'byphone' => 'By Phone',
                        'kunjunganrumah' => 'Kunjungan Rumah',
                        'statusmasuk' => 'Status Masuk',
                        'umur' => 'Umur',

                        'no_asuransi' => 'No. Asuransi',
                        'namapemilik_asuransi' => 'Pemilik Asuransi',
                        'nopokokperusahaan' => 'No. Pokok Perusahaan',
                        'kelastanggungan_id' => 'Kelas Tanggungan',
                        'namaperusahaan' => 'Nama Perusahaan',

                        'ruanganNama' => 'Poliklinik',
                        'penjaminNama' => 'Penjamin',
                        'kelompokumurNama' => 'Kelompok Umur',
                        'kelompokumurId' => 'Kelompok Umur',
                        'kasusPenyakitNama' => 'Kasus Penyakit',
                        'dokterNama' => 'Dokter',
                        'create_time' => 'Waktu Create',
                        'update_time' => 'update Time',
                        'create_loginpemakai_id' => 'Create Login Pemakai',
                        'update_loginpemakai_id' => 'Update Login Pemakai',
                        'create_ruangan' => 'Create Ruangan',
                        'nopendaftaran_aktif' => 'Aktif',
                );
        }

        public function searchPasienPendaftaran()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with=array('pasien','penanggungJawab','jeniskasuspenyakit','dokter','penjamin','ruangan');
                $criteria->compare('ruangan.instalasi_id', Params::INSTALASI_ID_RJ);
                $criteria->compare('LOWER(penjamin.penjamin_nama)',  strtolower($this->penjaminNama),true);
                $criteria->compare('LOWER(dokter.nama_pegawai)',  strtolower($this->dokterNama),true);
                $criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',  strtolower($this->kasusPenyakitNama),true);
                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->noRekamMedik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->namaPasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)',  strtolower($this->namaBin),true);
                $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat),true);
                $criteria->compare('pasien.kelompokumur_id',  strtolower($this->kelompokumurId));
                $criteria->compare('pasien.propinsi_id',  strtolower($this->propinsi));
                $criteria->compare('pasien.kabupaten_id',  strtolower($this->kabupaten));
                $criteria->compare('pasien.kecamatan_id',  strtolower($this->kecamatan));
                $criteria->compare('pasien.kelurahan_id',  strtolower($this->kelurahan));
                $criteria->compare('pendaftaran_id',$this->pendaftaran_id);
                $criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('caramasuk_id',$this->caramasuk_id);
                $criteria->compare('carabayar_id',$this->carabayar_id);
                $criteria->compare('pasien_id',$this->pasien_id);
                $criteria->compare('shift_id',$this->shift_id);
                $criteria->compare('golonganumur_id',$this->golonganumur_id);
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('rujukan_id',$this->rujukan_id);
                $criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
                $criteria->compare('t.ruangan_id',$this->ruangan_id);
                $criteria->compare('t.instalasi_id',$this->instalasi_id);
                $criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
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
                $criteria->order = 'tgl_pendaftaran DESC';

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }

         /**
            * Mengambil daftar semua ruangan
            * @return CActiveDataProvider 
        */
        public static function getRuanganItems($instalasi_id = null)
        {
           $criteria = new CDbCriteria();
           $criteria->compare('instalasi_id',$instalasi_id);
           $criteria->addCondition('ruangan_aktif = true');
           $criteria->order = "ruangan_nama";
           return RuanganM::model()->findAll($criteria);
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
        public static function getKelasPelayananItems()
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
         * 
         * Mengambil daftar dokter berdasarkan ruangan_id
         * @param integer $ruangan_id
         */
        public function getDokterItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'pegawai_aktif'=>true), array('order'=>'pegawai_id'));
            else
                return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true), array('order'=>'pegawai_id'));
        }
    
        /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran Konsultasi Gizi Luar
         * @return \CActiveDataProvider
         */
        public function searchRiwayatPasien(){
            $criteria=new CDbCriteria;
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
            $criteria->limit = 5;          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
					'pagination'=>false,
            ));
        }
    
}
?>
