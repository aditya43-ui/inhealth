<?php

/**
 * This is the model class for table "ambilpencucianlinenumum_t".
 *
 * The followings are the available columns in table 'ambilpencucianlinenumum_t':
 * @property integer $ambilpencucianlinenumum_id
 * @property integer $terimapencucianlinenumum_id
 * @property integer $pencucianlinenumum_id
 * @property string $tglpengambilan
 * @property string $nopengambilan
 * @property string $namapengambil
 * @property double $berat
 * @property double $harga
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class AmbilpencucianlinenumumT extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ambilpencucianlinenumum_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tglpengambilan, namapengambil', 'required'),
            array('terimapencucianlinenumum_id, pencucianlinenumum_id, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('berat, harga', 'numerical'),
            array('nopengambilan', 'length', 'max' => 25),
            array('namapengambil', 'length', 'max' => 50),
            array('tglpengambilan, create_time, update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ambilpencucianlinenumum_id, terimapencucianlinenumum_id, pencucianlinenumum_id, tglpengambilan, nopengambilan, namapengambil, berat, harga, create_time, update_time, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ambilpencucianlinenumum_id' => 'Ambilpencucianlinenumum',
            'terimapencucianlinenumum_id' => 'Terimapencucianlinenumum',
            'pencucianlinenumum_id' => 'Pencucianlinenumum',
            'tglpengambilan' => 'Tglpengambilan',
            'tglpencucian' => 'Tanggal Pencucian',
            'nopengambilan' => 'No. Pengambilan',
            'namapengambil' => 'Nama Pengambil',
            'namapengirim' => 'Nama Pengirim',
            'mesinpencucian_nama' => 'Mesin Pencucian',
            'keterangan' => 'Keterangan',
            'berat' => 'Berat',
            'harga' => 'Harga',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_ruangan' => 'Create Ruangan',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
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

        $criteria->compare('ambilpencucianlinenumum_id', $this->ambilpencucianlinenumum_id);
        $criteria->compare('terimapencucianlinenumum_id', $this->terimapencucianlinenumum_id);
        $criteria->compare('pencucianlinenumum_id', $this->pencucianlinenumum_id);
        $criteria->compare('tglpengambilan', $this->tglpengambilan, true);
        $criteria->compare('nopengambilan', $this->nopengambilan, true);
        $criteria->compare('namapengambil', $this->namapengambil, true);
        $criteria->compare('berat', $this->berat);
        $criteria->compare('harga', $this->harga);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AmbilpencucianlinenumumT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
