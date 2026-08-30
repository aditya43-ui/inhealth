<?php

/**
 * This is the model class for table "notadinaskpa_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'notadinaskpa_t':
 * @property integer $notadinaskpa_id
 * @property integer $suratperjanjiankerja_id
 * @property string $notadinaskpa_nomor
 * @property string $notadinaskpa_tanggal
 * @property string $nomor_notadinas
 * @property integer $pegkpa_id
 * @property string $notadinaskpa_kepada
 * @property integer $supplier_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SupplierM $supplier
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property PegawaiM $pegkpa
 */
class NotadinaskpaT extends CActiveRecord {

    public $pegkpa_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NotadinaskpaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notadinaskpa_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nomor_notadinas,suratperjanjiankerja_id, notadinaskpa_nomor, notadinaskpa_tanggal, notadinaskpa_kepada, supplier_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('suratperjanjiankerja_id, pegkpa_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('notadinaskpa_nomor, nomor_notadinas', 'length', 'max' => 50),
            array('notadinaskpa_kepada', 'length', 'max' => 100),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('notadinaskpa_id, suratperjanjiankerja_id, notadinaskpa_nomor, notadinaskpa_tanggal, nomor_notadinas, pegkpa_id, notadinaskpa_kepada, supplier_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
            'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
            'pegkpa' => array(self::BELONGS_TO, 'PegawaiM', 'pegkpa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'notadinaskpa_id' => 'Notadinaskpa',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'notadinaskpa_nomor' => 'Nomor Transaksi',
            'notadinaskpa_tanggal' => 'Tanggal Nota Dinas',
            'nomor_notadinas' => 'Nomor Nota Dinas',
            'pegkpa_id' => 'Kuasa Pengguna Anggaran',
            'notadinaskpa_kepada' => 'Kepada',
            'supplier_id' => 'Supplier',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
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

        if (!empty($this->notadinaskpa_id)) {
            $criteria->addCondition('notadinaskpa_id = ' . $this->notadinaskpa_id);
        }
        if (!empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('suratperjanjiankerja_id = ' . $this->suratperjanjiankerja_id);
        }
        $criteria->compare('LOWER(notadinaskpa_nomor)', strtolower($this->notadinaskpa_nomor), true);
        $criteria->compare('LOWER(notadinaskpa_tanggal)', strtolower($this->notadinaskpa_tanggal), true);
        $criteria->compare('LOWER(nomor_notadinas)', strtolower($this->nomor_notadinas), true);
        if (!empty($this->pegkpa_id)) {
            $criteria->addCondition('pegkpa_id = ' . $this->pegkpa_id);
        }
        $criteria->compare('LOWER(notadinaskpa_kepada)', strtolower($this->notadinaskpa_kepada), true);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('supplier_id = ' . $this->supplier_id);
        }
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
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
