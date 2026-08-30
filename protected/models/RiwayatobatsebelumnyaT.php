<?php

/**
 * This is the model class for table "riwayatobatsebelumnya_t".
 *
 * @author rusdiyanto <rusdiyanto@.com>
 * @author  M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'riwayatobatsebelumnya_t':
 * @property integer $riwayatobatsebelumnya_id
 * @property integer $asesmen_awal_medis_id
 * @property string $nama_obat
 * @property string $dosis_obat
 * @property string $carapemberian
 * @property string $tglpemberian
 * @property integer $asesmentriase_id
 * @property integer $asesmenterapi_gawatdarurat_id
 *
 * The followings are the available model relations:
 * @property AsesmentriaseT $asesmentriase
 * @property AsesmenAwalMedisT $asesmenAwalMedis
 */
class RiwayatobatsebelumnyaT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RiwayatobatsebelumnyaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'riwayatobatsebelumnya_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmen_awal_medis_id, asesmenterapi_gawatdarurat_id', 'numerical', 'integerOnly' => true),
            array('nama_obat', 'length', 'max' => 250),
            array('dosis_obat', 'length', 'max' => 50),
            array('carapemberian', 'length', 'max' => 100),
            array('asesmentriase_id, tglpemberian', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('riwayatobatsebelumnya_id, asesmen_awal_medis_id, nama_obat, dosis_obat, carapemberian, tglpemberian, asesmentriase_id, asesmenterapi_gawatdarurat_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmentriase' => array(self::BELONGS_TO, 'AsesmentriaseT', 'asesmentriase_id'),
            'asesmenAwalMedis' => array(self::BELONGS_TO, 'AsesmenAwalMedisT', 'asesmen_awal_medis_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'riwayatobatsebelumnya_id' => 'Riwayatobatsebelumnya',
            'asesmen_awal_medis_id' => 'Asesmen Awal Medis',
            'nama_obat' => 'Nama Obat',
            'dosis_obat' => 'Dosis Obat',
            'carapemberian' => 'Carapemberian',
            'tglpemberian' => 'Tglpemberian',
            'asesmentriase_id' => 'Asesmentriase',
            'asesmenterapi_gawatdarurat_id' => 'Asesmenterapi Gawatdarurat',
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

        if (!empty($this->riwayatobatsebelumnya_t)) {
            $criteria->addCondition('riwayatobatsebelumnya_t = ' . $this->riwayatobatsebelumnya_t);
        }
        if (!empty($this->asesmen_awal_medis_id)) {
            $criteria->addCondition('asesmen_awal_medis_id = ' . $this->asesmen_awal_medis_id);
        }
        $criteria->compare('LOWER(nama_obat)', strtolower($this->nama_obat), true);
        $criteria->compare('LOWER(dosis_obat)', strtolower($this->dosis_obat), true);
        $criteria->compare('LOWER(carapemberian)', strtolower($this->carapemberian), true);
        $criteria->compare('LOWER(tglpemberian)', strtolower($this->tglpemberian), true);

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
