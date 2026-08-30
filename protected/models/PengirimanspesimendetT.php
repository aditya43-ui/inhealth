<?php

/**
 * This is the model class for table "pengirimanspesimendet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pengirimanspesimendet_t':
 * @property integer $pengirimanspesimendet_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pengirimanspesimen_id
 * @property integer $penerimaanspesimendet_id
 * @property integer $pasien_id
 * @property integer $samplelab_id
 * @property integer $spesimen_id
 *
 * The followings are the available model relations:
 * @property PenerimaanspesimendetT $penerimaanspesimendet
 * @property TindakanpelayananT $tindakanpelayanan
 * @property PasienM $pasien
 * @property SpesimenT $spesimen
 * @property SamplelabM $samplelab
 * @property PengirimanspesimenT $pengirimanspesimen
 */
class PengirimanspesimendetT extends CActiveRecord {

    public $nama_pasien, $no_rekam_medik, $waktu_pengambilan_spesimen, $no_spesimen, $jenis_spesimen, $jenis_pemeriksaan, $status;
    public $ruangan_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengirimanspesimendetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengirimanspesimendet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tindakanpelayanan_id, pengirimanspesimen_id, penerimaanspesimendet_id, pasien_id, samplelab_id, spesimen_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengirimanspesimendet_id, tindakanpelayanan_id, pengirimanspesimen_id, penerimaanspesimendet_id, pasien_id, samplelab_id, spesimen_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'penerimaanspesimendet' => array(self::BELONGS_TO, 'PenerimaanspesimendetT', 'penerimaanspesimendet_id'),
            'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'spesimen' => array(self::BELONGS_TO, 'SpesimenT', 'spesimen_id'),
            'samplelab' => array(self::BELONGS_TO, 'SamplelabM', 'samplelab_id'),
            'pengirimanspesimen' => array(self::BELONGS_TO, 'PengirimanspesimenT', 'pengirimanspesimen_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pengirimanspesimendet_id' => 'Pengirimanspesimendet',
            'tindakanpelayanan_id' => 'Tindakanpelayanan',
            'pengirimanspesimen_id' => 'Pengirimanspesimen',
            'penerimaanspesimendet_id' => 'Penerimaanspesimendet',
            'pasien_id' => 'Pasien',
            'samplelab_id' => 'Samplelab',
            'spesimen_id' => 'Spesimen',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('pengirimanspesimendet_id', $this->pengirimanspesimendet_id);
        $criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('penerimaanspesimendet_id', $this->penerimaanspesimendet_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('samplelab_id', $this->samplelab_id);
        $criteria->compare('spesimen_id', $this->spesimen_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
