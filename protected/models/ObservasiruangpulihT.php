<?php

/**
 * This is the model class for table "observasiruangpulih_t".
 *
 * The followings are the available columns in table 'observasiruangpulih_t':
 * @property integer $observasiruangpulih_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $pemeriksaanke
 * @property string $observasijam
 * @property integer $detaknadi
 * @property integer $pernapasan
 * @property double $suhubadan
 * @property integer $td_systolic
 * @property integer $td_dyastolic
 * @property double $spo2_nilai
 * @property double $o2_nilai
 * @property integer $skalanyeri
 * @property boolean $mualmuntah_status
 * @property string $mualmuntah_ket
 * @property boolean $perdarahan_status
 * @property string $perdarahan_ket
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
 */
class ObservasiruangpulihT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObservasiruangpulihT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'observasiruangpulih_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, pemeriksaanke, observasijam, detaknadi, pernapasan, suhubadan, td_systolic, td_dyastolic', 'required'),
            array('observasijam, detaknadi, pernapasan, suhubadan, td_systolic', 'required'),
            array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, detaknadi, pernapasan, td_systolic, td_dyastolic, skalanyeri, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('suhubadan, spo2_nilai, o2_nilai', 'numerical'),
            array('mualmuntah_ket, perdarahan_ket', 'length', 'max' => 100),
            array('mualmuntah_status, perdarahan_status, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('observasiruangpulih_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, pemeriksaanke, observasijam, detaknadi, pernapasan, suhubadan, td_systolic, td_dyastolic, spo2_nilai, o2_nilai, skalanyeri, mualmuntah_status, mualmuntah_ket, perdarahan_status, perdarahan_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'observasiruangpulih_id' => 'Observasiruangpulih',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'rencanaoperasi_id' => 'Rencanaoperasi',
            'pemeriksaanke' => 'Pemeriksaan ke-',
            'observasijam' => 'Jam Observasi',
            'detaknadi' => 'Nadi',
            'pernapasan' => 'Pernapasan',
            'suhubadan' => 'Suhu',
            'td_systolic' => 'Tekanan Darah',
            'td_dyastolic' => 'Td Dyastolic',
            'spo2_nilai' => 'SPo2',
            'o2_nilai' => 'O2',
            'skalanyeri' => 'Skala Nyeri',
            'mualmuntah_status' => 'Mual/Muntah',
            'mualmuntah_ket' => 'Mualmuntah Ket',
            'perdarahan_status' => 'Perdarahan',
            'perdarahan_ket' => 'Perdarahan Ket',
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

        if (!empty($this->observasiruangpulih_id)) {
            $criteria->addCondition('observasiruangpulih_id = ' . $this->observasiruangpulih_id);
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
        $criteria->compare('LOWER(observasijam)', strtolower($this->observasijam), true);
        if (!empty($this->detaknadi)) {
            $criteria->addCondition('detaknadi = ' . $this->detaknadi);
        }
        if (!empty($this->pernapasan)) {
            $criteria->addCondition('pernapasan = ' . $this->pernapasan);
        }
        $criteria->compare('suhubadan', $this->suhubadan);
        if (!empty($this->td_systolic)) {
            $criteria->addCondition('td_systolic = ' . $this->td_systolic);
        }
        if (!empty($this->td_dyastolic)) {
            $criteria->addCondition('td_dyastolic = ' . $this->td_dyastolic);
        }
        $criteria->compare('spo2_nilai', $this->spo2_nilai);
        $criteria->compare('o2_nilai', $this->o2_nilai);
        if (!empty($this->skalanyeri)) {
            $criteria->addCondition('skalanyeri = ' . $this->skalanyeri);
        }
        $criteria->compare('mualmuntah_status', $this->mualmuntah_status);
        $criteria->compare('LOWER(mualmuntah_ket)', strtolower($this->mualmuntah_ket), true);
        $criteria->compare('perdarahan_status', $this->perdarahan_status);
        $criteria->compare('LOWER(perdarahan_ket)', strtolower($this->perdarahan_ket), true);
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
            'pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id,
        ), array(
            'order'=>'pemeriksaanke desc',
        ));

        $this->pemeriksaanke = empty($data) ? 1 : ($data->pemeriksaanke + 1);
    }

}
