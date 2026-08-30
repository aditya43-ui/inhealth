<?php

/**
 * This is the model class for table "asesmenpraanestesi_t".
 *
 * The followings are the available columns in table 'asesmenpraanestesi_t':
 * @property integer $asesmenpraanestesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienkirimkeunitlain_id
 * @property string $tgl_asesmenprabedah
 * @property integer $dokteranestesi_id
 * @property integer $dokterbedah_id
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property integer $nadi
 * @property double $suhu
 * @property integer $rr
 * @property integer $spo2
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property string $riwayatpenyakit
 * @property string $riwayatpengobatan
 * @property string $riwayatalergimakanan
 * @property string $riwayatalergiobat
 * @property string $keluhanutama
 * @property integer $skalanyeri
 * @property string $skalanyeri_ket
 * @property boolean $is_konsumsirokok
 * @property boolean $is_alatbantu_dengar
 * @property boolean $is_alatbantu_kacamata
 * @property boolean $is_alatbantu_pacujantung
 * @property boolean $is_alatbantu_sofelens
 * @property boolean $is_alatbantu_gigipalsu
 * @property boolean $is_alatbantu_prostese
 * @property boolean $is_zatadiktif
 * @property boolean $is_kelainan_kepalaleher
 * @property string $kepalaleher_keterangan
 * @property boolean $is_kelainan_mulutdangigi
 * @property string $mulutdangigi_keterangan
 * @property boolean $is_kelainan_thorax
 * @property string $thorax_keterangan
 * @property boolean $is_kelainan_abdomen
 * @property string $abdomen_keterangan
 * @property boolean $is_kelainan_kardiovaskuler
 * @property string $kardiovaskuler_keterangan
 * @property boolean $is_kelainan_genito
 * @property string $genito_keterangan
 * @property boolean $is_kelainan_muskuloskeletal
 * @property string $muskuloskeletal_keterangan
 * @property boolean $is_kelainan_reproduksi
 * @property string $reproduksi_keterangan
 * @property string $kesadaran
 * @property integer $gcs_eye_id
 * @property integer $gcs_verbal_id
 * @property integer $gcs_motorik_id
 * @property boolean $is_rencana_ambulatory
 * @property boolean $is_rencana_rawatinap
 * @property boolean $is_rencana_icu
 * @property boolean $is_rujuk
 * @property integer $rujukke_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $dokteranestesi
 * @property PegawaiM $dokteranestesi
 * @property MetodegcsM $gcsEye
 * @property MetodegcsM $gcsMotorik
 * @property MetodegcsM $gcsVerbal
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 * @property PendaftaranT $pendaftaran
 * @property RujukandariM $rujukke
 */
class AsesmenpraanestesiT extends CActiveRecord {

    public $ruangandibuat_nama, $rujukke_nama;
    public $tgl_pendaftaran, $no_pendaftaran;
    public $dokteranestesi_nama, $dokterbedah_nama;
    public $jnstransaksi;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenpraanestesi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, pendaftaran_id, pasienkirimkeunitlain_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienkirimkeunitlain_id, dokterbedah_id, dokteranestesi_id, tensi_sistolik, tensi_diastolik, nadi, rr, spo2, skalanyeri, gcs_eye_id, gcs_verbal_id, gcs_motorik_id, rujukke_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('suhu, beratbadan_kg, tinggibadan_cm', 'numerical'),
            array('skalanyeri_ket, kesadaran', 'length', 'max' => 50),
            array('kepalaleher_keterangan, mulutdangigi_keterangan, thorax_keterangan, abdomen_keterangan, kardiovaskuler_keterangan, genito_keterangan, muskuloskeletal_keterangan, reproduksi_keterangan', 'length', 'max' => 100),
            array('skorasa, skormallapaty, tgl_asesmenprabedah, riwayatpenyakit, riwayatpengobatan, riwayatalergimakanan, riwayatalergiobat, keluhanutama, is_konsumsirokok, is_alatbantu_dengar, is_alatbantu_kacamata, is_alatbantu_pacujantung, is_alatbantu_sofelens, is_alatbantu_gigipalsu, is_alatbantu_prostese, is_zatadiktif, is_kelainan_kepalaleher, is_kelainan_mulutdangigi, is_kelainan_thorax, is_kelainan_abdomen, is_kelainan_kardiovaskuler, is_kelainan_genito, is_kelainan_muskuloskeletal, is_kelainan_reproduksi, is_rencana_ambulatory, is_rencana_rawatinap, is_rencana_icu, is_rujuk, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('skorasa, skormallapaty, asesmenpraanestesi_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienkirimkeunitlain_id, tgl_asesmenprabedah, dokteranestesi_id, dokteranestesi_id, tensi_sistolik, tensi_diastolik, nadi, suhu, rr, spo2, beratbadan_kg, tinggibadan_cm, riwayatpenyakit, riwayatpengobatan, riwayatalergimakanan, riwayatalergiobat, keluhanutama, skalanyeri, skalanyeri_ket, is_konsumsirokok, is_alatbantu_dengar, is_alatbantu_kacamata, is_alatbantu_pacujantung, is_alatbantu_sofelens, is_alatbantu_gigipalsu, is_alatbantu_prostese, is_zatadiktif, is_kelainan_kepalaleher, kepalaleher_keterangan, is_kelainan_mulutdangigi, mulutdangigi_keterangan, is_kelainan_thorax, thorax_keterangan, is_kelainan_abdomen, abdomen_keterangan, is_kelainan_kardiovaskuler, kardiovaskuler_keterangan, is_kelainan_genito, genito_keterangan, is_kelainan_muskuloskeletal, muskuloskeletal_keterangan, is_kelainan_reproduksi, reproduksi_keterangan, kesadaran, gcs_eye_id, gcs_verbal_id, gcs_motorik_id, is_rencana_ambulatory, is_rencana_rawatinap, is_rencana_icu, is_rujuk, rujukke_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'dokterbedah' => array(self::BELONGS_TO, 'PegawaiM', 'dokterbedah_id'),
            'dokteranestesi' => array(self::BELONGS_TO, 'PegawaiM', 'dokteranestesi_id'),
            'gcsEye' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_eye_id'),
            'gcsMotorik' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_motorik_id'),
            'gcsVerbal' => array(self::BELONGS_TO, 'MetodegcsM', 'gcs_verbal_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'rujukke' => array(self::BELONGS_TO, 'RujukandariM', 'rujukke_id'),
            'jenisanastesi' => array(self::BELONGS_TO, 'JenisanastesiM', 'jenisanastesi_id'),
            'ruangbuat' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenpraanestesi_id' => 'Asesmenpraanestesi',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pasienkirimkeunitlain_id' => 'Pilih Permintaan Anestesi',
            'tgl_asesmenprabedah' => 'Tgl Asesmen Pra Bedah',
            'tgl_asesmenpraanestesi' => 'Tgl Asesmen Pra Anestesi',
            'dokterbedah_id' => 'Dokterbedah',
            'dokteranestesi_id' => 'Dokteranestesi',
            'tensi_sistolik' => 'Tensi Sistolik',
            'tensi_diastolik' => 'Tensi Diastolik',
            'nadi' => 'Nadi',
            'suhu' => 'Suhu',
            'rr' => 'Rr',
            'spo2' => 'Spo2',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'riwayatpenyakit' => 'Riwayat Penyakit',
            'riwayatpengobatan' => 'Riwayat Pengobatan',
            'riwayatalergimakanan' => 'Riwayat Alergi Makanan',
            'riwayatalergiobat' => 'Riwayat Alergi Obat',
            'keluhanutama' => 'Keluhan Utama',
            'skalanyeri' => 'Skalanyeri',
            'skalanyeri_ket' => 'Skalanyeri Ket',
            'is_konsumsirokok' => 'Konsumsi Rokok',
            'is_alatbantu_dengar' => 'Is Alatbantu Dengar',
            'is_alatbantu_kacamata' => 'Is Alatbantu Kacamata',
            'is_alatbantu_pacujantung' => 'Is Alatbantu Pacujantung',
            'is_alatbantu_sofelens' => 'Is Alatbantu Sofelens',
            'is_alatbantu_gigipalsu' => 'Is Alatbantu Gigipalsu',
            'is_alatbantu_prostese' => 'Is Alatbantu Prostese',
            'is_zatadiktif' => 'Penggunaan zat adiktif',
            'is_kelainan_kepalaleher' => 'Is Kelainan Kepalaleher',
            'kepalaleher_keterangan' => 'Kepalaleher Keterangan',
            'is_kelainan_mulutdangigi' => 'Is Kelainan Mulutdangigi',
            'mulutdangigi_keterangan' => 'Mulutdangigi Keterangan',
            'is_kelainan_thorax' => 'Is Kelainan Thorax',
            'thorax_keterangan' => 'Thorax Keterangan',
            'is_kelainan_abdomen' => 'Is Kelainan Abdomen',
            'abdomen_keterangan' => 'Abdomen Keterangan',
            'is_kelainan_kardiovaskuler' => 'Is Kelainan Kardiovaskuler',
            'kardiovaskuler_keterangan' => 'Kardiovaskuler Keterangan',
            'is_kelainan_genito' => 'Is Kelainan Genito',
            'genito_keterangan' => 'Genito Keterangan',
            'is_kelainan_muskuloskeletal' => 'Is Kelainan Muskuloskeletal',
            'muskuloskeletal_keterangan' => 'Muskuloskeletal Keterangan',
            'is_kelainan_reproduksi' => 'Is Kelainan Reproduksi',
            'reproduksi_keterangan' => 'Reproduksi Keterangan',
            'skormallapaty' => 'skormallapaty',
            'skorasa' => 'skorasa',
            'kesadaran' => 'Kesadaran',
            'gcs_eye_id' => 'Gcs Eye',
            'gcs_verbal_id' => 'Gcs Verbal',
            'gcs_motorik_id' => 'Gcs Motorik',
            'is_rencana_ambulatory' => 'Is Rencana Ambulatory',
            'is_rencana_rawatinap' => 'Is Rencana Rawatinap',
            'is_rencana_icu' => 'Is Rencana Icu',
            'is_rujuk' => 'Is Rujuk',
            'rujukke_id' => 'Rujukke',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'dokteranestesi_nama' => 'Dokter Bedah',
            'ruangandibuat_nama' => 'Ruangan'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = [
            "CONCAT(anestesi.gelardepan,' ',anestesi.nama_pegawai,' ',anestesiglr.gelarbelakang_nama) as dokteranestesi_nama",
            "CONCAT(anestesi.gelardepan,' ',anestesi.nama_pegawai,' ',anestesiglr.gelarbelakang_nama) as dokteranestesi_nama",
            "t.*",
            "rbuat.ruangan_nama as ruangandibuat_nama",
            "p.no_pendaftaran",
            "p.tgl_pendaftaran"
        ];
        $criteria->join = " 
                    JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id 
                    LEFT JOIN pegawai_m anestesi ON anestesi.pegawai_id = t.dokteranestesi_id 
                    LEFT JOIN gelarbelakang_m anestesiglr ON anestesiglr.gelarbelakang_id = anestesi.gelarbelakang_id 
                    JOIN ruangan_m rbuat ON rbuat.ruangan_id = t.create_ruangan 
                ";
        $criteria->compare('t.pendaftaran_id', $this->pendaftaran_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchRiwayat()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
        $criteria->compare('t.pasien_id',$this->pasien_id);
        $criteria->order = 't.tgl_asesmenprabedah desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchPasienIcd9()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $cri = new CDbCriteria;
        $cri->select = "t.*, diag.diagnosaicdix_nama, diag.diagnosaicdix_kode, diag.diagnosaicdix_namalainnya";
        $cri->join = " JOIN diagnosaicdix_m diag ON diag.diagnosaicdix_id = t.diagnosaicdix_id ";

        // $cri->addCondition(" pendaftaran_id =  ".$this->pendaftaran_id);
        $cri->addCondition(" kelompokdiagnosa_id = 2 and diag.diagnosaicdix_id is null");

        return new CActiveDataProvider(new PasienIcd9cmT, array(
                'criteria'=>$cri,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AsesmenpraanestesiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param type $model
     * @param type $post
     * @return type
     */
    public static function simpanData($model, $post) {
        $ok = true;
        $format = new MyFormatter();
        $pesan = '';
        $model->attributes = $post;

        $model->jenisanastesi_id = isset($post['jenisanastesi_id']) ? $post['jenisanastesi_id'] : null;
        $model->tgl_asesmenprabedah = !empty($model->tgl_asesmenprabedah) ? $format->formatDateTimeForDb($model->tgl_asesmenprabedah) : null;

        if ($model->jnstransaksi == 'salin') {
            unset($model->asesmenpraanestesi_id);
            $model->isNewRecord = true;
        }

        if(!empty($model->keluhanutama)) {
            $model->keluhanutama = implode(', ', $model->keluhanutama);
        }

        if (empty($model->asesmenpraanestesi_id)) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        $ok &= $model->save();

        if (!$ok) {
            $pesan .= '<br/>asesmen pra anestesi : ' . MyExceptionMessage::getErrorMessage($model);
        }

        $data['sukses'] = $ok;
        $data['model'] = $model;
        $data['pesan'] = $pesan;

        return $data;
    }

    public function setAwal() {
        if (!empty($this->pendaftaran_id)) {
            $daftar = PendaftaranT::model()->findByPk($this->pendaftaran_id);
            $admisi = PasienadmisiT::model()->findByPk($this->pasienadmisi_id);
            $dpjp = PegawaiM::model()->findByPk(!empty($admisi) ? $admisi->pegawai_id : $daftar->pegawai_id);

            // if (!empty($dpjp)){
            //     $this->dokteranestesi_id = $dpjp->pegawai_id;
            //     $this->dokteranestesi_nama = $dpjp->namaLengkap;
            // }

            $this->tgl_asesmenprabedah = date('Y-m-d H:i:s');

            $periksafisik = PemeriksaanfisikT::model()->findByAttributes([
                'pendaftaran_id' => $this->pendaftaran_id
            ]);

            if (!empty($periksafisik)) {
                $this->tensi_sistolik = $periksafisik->td_systolic;
                $this->tensi_diastolik = $periksafisik->td_diastolic;
                $this->nadi = $periksafisik->detaknadi;
                $this->suhu = $periksafisik->suhutubuh;
                $this->rr = $periksafisik->pernapasan;
                $this->spo2 = $periksafisik->tandavital_spo2;
                $this->beratbadan_kg = $periksafisik->beratbadan_kg;
                $this->tinggibadan_cm = $periksafisik->tinggibadan_cm;
            }
        }
    }

    public function loadInput() {
        $this->dokterbedah_nama = !empty($this->dokterbedah) ? $this->dokterbedah->namaLengkap : '';
        $this->dokteranestesi_nama = !empty($this->dokteranestesi) ? $this->dokteranestesi->namaLengkap : '';
        $this->ruangandibuat_nama = !empty($this->ruangbuat) ? $this->ruangbuat->ruangan_nama : '';
        $this->rujukke_nama = !empty($this->rujukke) ? $this->rujukke->namaperujuk : '';
    }

    public function searchMorbiditas() {
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN kelompokdiagnosa_m kd ON kd.kelompokdiagnosa_id = t.kelompokdiagnosa_id "
                . " JOIN diagnosa_m d ON d.diagnosa_id = t.diagnosa_id "
                . " LEFT JOIN klasifikasidiagnosa_m kld ON kld.klasifikasidiagnosa_id = d.klasifikasidiagnosa_id ";
        $criteria->select = [
            "t.tglmorbiditas",
            "kd.kelompokdiagnosa_nama",
            "kld.klasifikasidiagnosa_nama",
            "d.diagnosa_nama",
            "d.diagnosa_kode",
            "d.diagnosa_namalainnya as diagnosa_namalain",
            "t.keterangan",
            "t.pasienmorbiditas_id"
        ];
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        if (!empty($this->default)) {
            $criteria->addCondition("pasienmorbiditas_id IS NULL");
        }
        return new CActiveDataProvider(new PasienmorbiditasT, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchPermintaanKepenunjangOperasi(){
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN operasi_m o ON o.operasi_id = t.operasi_id "
                        . " LEFT JOIN detailoperasi_m deto ON deto.detailoperasi_idPelaksanaoperasiT = t.detailoperasi_id "
                        . " JOIN pasienkirimkeunitlain_t kirim ON kirim.pasienkirimkeunitlain_id = t.pasienkirimkeunitlain_id ";
        $criteria->select = [
            "o.operasi_nama",
            "deto.detailoperasi_nama",
            "t.permintaankepenunjang_id"
        ];
//            $criteria->compare('t.pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);            
        if (!empty($this->default)){
            $criteria->addCondition("t.permintaankepenunjang_id IS NULL");
        }
        $criteria->compare('kirim.pendaftaran_id', $this->pendaftaran_id);
        
        return new CActiveDataProvider(new PermintaankepenunjangT, array(
                'criteria'=>$criteria,
        ));
    }

    public function getDropListPermintaan() {
        $load = [];
        if (!empty($this->pendaftaran_id)) {
            $cri = new CDbCriteria;
            $cri->addCondition(" instalasi_id = 19");
            $cri->addCondition(" pasien_id =  ".$this->pasien_id);
            $cri->order = " tgl_kirimpasien DESC ";
            $mod = PasienkirimkeunitlainT::model()->findAll($cri);

            // var_dump('mod ',$this->pendaftaran_id, $mod);die;
            if (!empty($mod)) {
                // var_dump('kosong');die;
                foreach ($mod as $k => $v) {
                    $tgl = date('Y-m-d', strtotime($v->tgl_kirimpasien));
                    $load[$v->pasienkirimkeunitlain_id] = "Permintaan Anestesi Tgl " . MyFormatter::formatDateTimeId($tgl);
                }
            }
        }

        return$load;
    }

}
