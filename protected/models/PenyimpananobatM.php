
<?php

/**
 * This is the model class for table "penyimpananobat_m".
 *
 * The followings are the available columns in table 'penyimpananobat_m':
 * @property integer $penyimpananobat_id
 * @property integer $ruangan_id
 * @property integer $rakobat_id
 * @property integer $obatalkes_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RuanganM $ruangan
 * @property RakobatM $rakobat
 * @property ObatalkesM $obatalkes
 */
class PenyimpananobatM extends CActiveRecord
{
    public $lokasiobat_nama, $lokasiobat_namalain, $lokasiobat_aktif, $rakobat_nama, $rakobat_namalain, $rakobat_label, $rakobat_aktif;
    public $ruangan_nama;
    public $ruangan_namalainnya;
    public $obatalkes_nama;
    public $obatalkes_kode;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'penyimpananobat_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('ruangan_id, rakobat_id, obatalkes_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('penyimpananobat_id, ruangan_id, rakobat_id, obatalkes_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'rakobat' => array(self::BELONGS_TO, 'RakobatM', 'rakobat_id'),
            'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'penyimpananobat_id' => 'Penyimpananobat',
            'ruangan_id' => 'Ruangan',
            'rakobat_id' => 'Rak obat',
            'obatalkes_id' => 'Obat dan Alat Kesehatan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'penyimpananobat_aktif' => 'Aktif'
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

public function criteriaSearch(){

    $criteria = new CDbCriteria;

    $criteria->compare('penyimpananobat_id', $this->penyimpananobat_id);
    $criteria->compare('t.ruangan_id', $this->ruangan_id);
    $criteria->compare('t.rakobat_id', $this->rakobat_id);
    $criteria->compare('t.obatalkes_id', $this->obatalkes_id);
    $criteria->compare('create_time', $this->create_time, true);
    $criteria->compare('update_time', $this->update_time, true);
    $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
    $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
    $criteria->compare('create_ruangan', $this->create_ruangan);
    $criteria->compare('penyimpananobat_aktif', isset($this->penyimpananobat_aktif) ? $this->penyimpananobat_aktif : true);
    $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
    $criteria->compare('LOWER(rakobat_nama)', strtolower($this->rakobat_nama), true);
    $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);

    $criteria->select = "t.*,
                ruangan_m.ruangan_nama,
                ruangan_m.ruangan_namalainnya,
                rakobat_m.rakobat_nama,
                obatalkes_m.obatalkes_nama";
    $criteria->join = "LEFT JOIN ruangan_m ON t.ruangan_id =ruangan_m.ruangan_id
LEFT JOIN rakobat_m ON t.rakobat_id = rakobat_m.rakobat_id
LEFT JOIN obatalkes_m ON t.obatalkes_id = obatalkes_m.obatalkes_id";

return $criteria;
}

     public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = $this->criteriaSearch();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }



    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.



        $criteria = $this->criteriaSearch();


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PenyimpananobatM the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
