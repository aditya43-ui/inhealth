<?php

/**
 * This is the model class for table "bedahanastesilokal_intraop_t".
 *
 * The followings are the available columns in table 'bedahanastesilokal_intraop_t':
 * @property integer $bedahanastesilokal_intraop_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $pemeriksaanke
 * @property string $observasi_jam
 * @property integer $respirasi_nilai
 * @property integer $td_systolic
 * @property integer $td_dyastolic
 * @property integer $detaknadi
 * @property double $suhubadan
 * @property string $status_anestesi
 * @property string $status_tindakanbedah
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 * @property BedahanastesilokalMedikasiintraopT[] $bedahanastesilokalMedikasiintraopTs
 */
class BedahanastesilokalIntraopT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BedahanastesilokalIntraopT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bedahanastesilokal_intraop_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, pemeriksaanke, observasi_jam, respirasi_nilai, td_systolic, td_dyastolic, detaknadi, suhubadan', 'required'),
            array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, respirasi_nilai, td_systolic, td_dyastolic, detaknadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('suhubadan', 'numerical'),
            array('status_anestesi, status_tindakanbedah', 'length', 'max' => 50),
            array('create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bedahanastesilokal_intraop_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, observasi_jam, respirasi_nilai, td_systolic, td_dyastolic, detaknadi, suhubadan, status_anestesi, status_tindakanbedah, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
            'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
            'bedahanastesilokalMedikasiintraopTs' => array(self::HAS_MANY, 'BedahanastesilokalMedikasiintraopT', 'bedahanastesilokal_intraop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bedahanastesilokal_intraop_id' => 'Bedahanastesilokal Intraop',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'rencanaoperasi_id' => 'Rencanaoperasi',
            'pemeriksaanke' => 'Pemeriksaan Ke',
            'observasi_jam' => 'Jam Observasi',
            'respirasi_nilai' => 'Respirasi',
            'td_systolic' => 'Tekanan Darah',
            'td_dyastolic' => 'Td Dyastolic',
            'detaknadi' => 'Nadi',
            'suhubadan' => 'Suhu',
            'status_anestesi' => 'Status Anestesi/Sedasi',
            'status_tindakanbedah' => 'Status Tindakan Bedah',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->bedahanastesilokal_intraop_id)) {
            $criteria->addCondition('bedahanastesilokal_intraop_id = ' . $this->bedahanastesilokal_intraop_id);
        }
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pasienadmisi_id)) {
            $criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
        }
        if (!empty($this->pasienmasukpenunjang_id)) {
            $criteria->addCondition('pasienmasukpenunjang_id = ' . $this->pasienmasukpenunjang_id);
        }
        if (!empty($this->rencanaoperasi_id)) {
            $criteria->addCondition('rencanaoperasi_id = ' . $this->rencanaoperasi_id);
        }
        if (!empty($this->pemeriksaanke)) {
            $criteria->addCondition('pemeriksaanke = ' . $this->pemeriksaanke);
        }
        $criteria->compare('LOWER(observasi_jam)', strtolower($this->observasi_jam), true);
        if (!empty($this->respirasi_nilai)) {
            $criteria->addCondition('respirasi_nilai = ' . $this->respirasi_nilai);
        }
        if (!empty($this->td_systolic)) {
            $criteria->addCondition('td_systolic = ' . $this->td_systolic);
        }
        if (!empty($this->td_dyastolic)) {
            $criteria->addCondition('td_dyastolic = ' . $this->td_dyastolic);
        }
        if (!empty($this->detaknadi)) {
            $criteria->addCondition('detaknadi = ' . $this->detaknadi);
        }
        $criteria->compare('suhubadan', $this->suhubadan);
        $criteria->compare('LOWER(status_anestesi)', strtolower($this->status_anestesi), true);
        $criteria->compare('LOWER(status_tindakanbedah)', strtolower($this->status_tindakanbedah), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
        }

        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function genPemeriksaan() {
        $data = self::model()->findByAttributes(array(
            'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id,
                ), array(
            'order' => 'pemeriksaanke desc',
        ));

        $this->pemeriksaanke = empty($data) ? 1 : ($data->pemeriksaanke + 1);
    }

    
    public function penentuanStatusAnestesi($status) {
        
        $jam = strtotime($this->observasi_jam);
        if (!empty($status->jam_mulaianestesi)) {
            $jam_anestesi = strtotime($status->jam_mulaianestesi);
            
            if ($jam < $jam_anestesi) {
                $this->status_anestesi = null;
            } else {
                $this->status_anestesi = Params::STATUSDURANTEANESTESI_SEDANG_ANESTESI;
            }
        }
        
        if (!empty($status->jam_selesaianestesi)) {
            $jam_anestesi = strtotime($status->jam_selesaianestesi);
            
            if ($jam >= $jam_anestesi) {
                $this->status_anestesi = Params::STATUSDURANTEANESTESI_AKHIR_ANESTESI;
            }
        }
        
        if (!empty($status->jam_mulaitindakanbedah)) {
            $jam_anestesi = strtotime($status->jam_mulaitindakanbedah);
            
            if ($jam < $jam_anestesi) {
                $this->status_tindakanbedah = null;
            } else {
                $this->status_tindakanbedah = Params::STATUSDURANTEANESTESI_SEDANG_TINDAKAN;
            }
        }
        
        if (!empty($status->jam_selesaitindakanbedah)) {
            $jam_anestesi = strtotime($status->jam_selesaitindakanbedah);
            
            if ($jam >= $jam_anestesi) {
                $this->status_tindakanbedah = Params::STATUSDURANTEANESTESI_AKHIR_TINDAKAN;
            }
        }
    }
    
}
