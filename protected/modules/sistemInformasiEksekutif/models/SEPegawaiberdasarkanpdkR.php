<?php

/**
 * This is the model class for table "pegawaiberdasarkanpdk_r".
 *
 * The followings are the available columns in table 'pegawaiberdasarkanpdk_r':
 * @property integer $pegawaiberdasarkanpdk_id
 * @property string $tanggal
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property integer $jumlah
 */
class SEPegawaiberdasarkanpdkR extends PegawaiberdasarkanpdkR {

    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $dataPieChartPdk;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegawaiberdasarkanpdkR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pegawaiberdasarkanpdk_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendidikan_id, jumlah', 'numerical', 'integerOnly' => true),
            array('pendidikan_nama', 'length', 'max' => 10),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pegawaiberdasarkanpdk_id, tanggal, pendidikan_id, pendidikan_nama, jumlah', 'safe', 'on' => 'search'),
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
            'pegawaiberdasarkanpdk_id' => 'Pegawaiberdasarkanpdk',
            'tanggal' => 'Tanggal',
            'pendidikan_id' => 'Pendidikan',
            'pendidikan_nama' => 'Pendidikan Nama',
            'jumlah' => 'Jumlah',
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

        if (!empty($this->pegawaiberdasarkanpdk_id)) {
            $criteria->addCondition('pegawaiberdasarkanpdk_id = ' . $this->pegawaiberdasarkanpdk_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->pendidikan_id)) {
            $criteria->addCondition('pendidikan_id = ' . $this->pendidikan_id);
        }
        $criteria->compare('LOWER(pendidikan_nama)', strtolower($this->pendidikan_nama), true);
        if (!empty($this->jumlah)) {
            $criteria->addCondition('jumlah = ' . $this->jumlah);
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
