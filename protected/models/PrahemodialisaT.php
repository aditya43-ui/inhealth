<?php

/**
 * This is the model class for table "prahemodialisa_t".
 *
 * The followings are the available columns in table 'prahemodialisa_t':
 * @property integer $prahemodialisa_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tgl_pengkajian
 * @property string $prehd_datasubyektif
 * @property string $prehd_dataobyektif
 * @property integer $prehd_tdsystolic
 * @property integer $prehd_tddiastolic
 * @property string $prehd_tekanandarah
 * @property integer $prehd_nadi
 * @property double $prehd_suhu
 * @property double $prehd_respirasi
 * @property double $prehd_bb_kg
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
 */
class PrahemodialisaT extends CActiveRecord {

    public $dokterpelaksana_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PrahemodialisaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'prahemodialisa_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dokterpelaksana_id, pasien_id, pendaftaran_id', 'required'),
            array('pasien_id, pendaftaran_id, pasienadmisi_id, prehd_tdsystolic, prehd_tddiastolic, prehd_nadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('prehd_suhu, prehd_respirasi, prehd_bb_kg', 'numerical'),
            array('prehd_tekanandarah', 'length', 'max' => 20),
            array('tgl_pengkajian, prehd_datasubyektif, prehd_dataobyektif, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('prahemodialisa_id, pasien_id, pendaftaran_id, pasienadmisi_id, tgl_pengkajian, prehd_datasubyektif, prehd_dataobyektif, prehd_tdsystolic, prehd_tddiastolic, prehd_tekanandarah, prehd_nadi, prehd_suhu, prehd_respirasi, prehd_bb_kg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'dokterpelaksana' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpelaksana_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'prahemodialisa_id' => 'Prahemodialisa',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'dokterpelaksana_id' => 'Dokter Pelaksana',
            'tgl_pengkajian' => 'Tgl. Pengkajian',
            'prehd_datasubyektif' => 'Data Subyektif',
            'prehd_dataobyektif' => 'Data Obyektif',
            'prehd_tdsystolic' => 'Tensi',
            'prehd_tddiastolic' => 'Prehd Tddiastolic',
            'prehd_tekanandarah' => 'Prehd Tekanandarah',
            'prehd_nadi' => 'Nadi',
            'prehd_suhu' => 'Suhu',
            'prehd_respirasi' => 'Respirasi',
            'prehd_bb_kg' => 'BB',
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

        if (!empty($this->prahemodialisa_id)) {
            $criteria->addCondition('prahemodialisa_id = ' . $this->prahemodialisa_id);
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
        $criteria->compare('LOWER(tgl_pengkajian)', strtolower($this->tgl_pengkajian), true);
        $criteria->compare('LOWER(prehd_datasubyektif)', strtolower($this->prehd_datasubyektif), true);
        $criteria->compare('LOWER(prehd_dataobyektif)', strtolower($this->prehd_dataobyektif), true);
        if (!empty($this->prehd_tdsystolic)) {
            $criteria->addCondition('prehd_tdsystolic = ' . $this->prehd_tdsystolic);
        }
        if (!empty($this->prehd_tddiastolic)) {
            $criteria->addCondition('prehd_tddiastolic = ' . $this->prehd_tddiastolic);
        }
        $criteria->compare('LOWER(prehd_tekanandarah)', strtolower($this->prehd_tekanandarah), true);
        if (!empty($this->prehd_nadi)) {
            $criteria->addCondition('prehd_nadi = ' . $this->prehd_nadi);
        }
        $criteria->compare('prehd_suhu', $this->prehd_suhu);
        $criteria->compare('prehd_respirasi', $this->prehd_respirasi);
        $criteria->compare('prehd_bb_kg', $this->prehd_bb_kg);
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

}
