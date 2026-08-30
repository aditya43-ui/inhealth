<?php

/**
 * This is the model class for table "areaoperasi_t".
 *
 * The followings are the available columns in table 'areaoperasi_t':
 * @property integer $areaoperasi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $kamarruangan_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property integer $pegawai_id
 * @property string $tgl_penandaanarea
 * @property string $proseduroperasi
 * @property string $areaoperasi_ket
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AreaoperasidetT[] $areaoperasidetTs
 */
class AreaoperasiT extends CActiveRecord
{
    public $pegawai_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AreaoperasiT the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'areaoperasi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pasien_id, pendaftaran_id, tgl_penandaanarea, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pasien_id, pendaftaran_id, pasienadmisi_id, kamarruangan_id, pasienmasukpenunjang_id, rencanaoperasi_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('proseduroperasi', 'length', 'max' => 250),
            array('areaoperasi_ket, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('areaoperasi_id, pasien_id, pendaftaran_id, pasienadmisi_id, kamarruangan_id, pasienmasukpenunjang_id, rencanaoperasi_id, pegawai_id, tgl_penandaanarea, proseduroperasi, areaoperasi_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'areaoperasidetTs' => array(self::HAS_MANY, 'AreaoperasidetT', 'areaoperasi_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'areaoperasi_id' => 'Area Operasi',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'kamarruangan_id' => 'Kamarruangan',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'rencanaoperasi_id' => 'Rencanaoperasi',
            'pegawai_id' => 'Operator',
            'tgl_penandaanarea' => 'Tgl. Penandaan Area',
            'proseduroperasi' => 'Proseduroperasi',
            'areaoperasi_ket' => 'Areaoperasi Ket',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('areaoperasi_id', $this->areaoperasi_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('kamarruangan_id', $this->kamarruangan_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('rencanaoperasi_id', $this->rencanaoperasi_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('tgl_penandaanarea', $this->tgl_penandaanarea, true);
        $criteria->compare('proseduroperasi', $this->proseduroperasi, true);
        $criteria->compare('areaoperasi_ket', $this->areaoperasi_ket, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
