<?php

/**
 * This is the model class for table "pendapatanjasa_r".
 *
 * The followings are the available columns in table 'pendapatanjasa_r':
 * @property integer $pendapatanjasa_id
 * @property string $tanggal
 * @property string $jasamedis
 * @property string $jasaparamedis
 */
class SEPendapatanjasaR extends PendapatanjasaR {

    public $jns_periode;
    public $periode, $jumlah_medis, $jumlah_paramedis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PendapatanjasaR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pendapatanjasa_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tanggal, jasamedis, jasaparamedis', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pendapatanjasa_id, tanggal, jasamedis, jasaparamedis', 'safe', 'on' => 'search'),
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
            'pendapatanjasa_id' => 'Pendapatanjasa',
            'tanggal' => 'Tanggal',
            'jasamedis' => 'Jasamedis',
            'jasaparamedis' => 'Jasaparamedis',
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

        if (!empty($this->pendapatanjasa_id)) {
            $criteria->addCondition('pendapatanjasa_id = ' . $this->pendapatanjasa_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        $criteria->compare('LOWER(jasamedis)', strtolower($this->jasamedis), true);
        $criteria->compare('LOWER(jasaparamedis)', strtolower($this->jasaparamedis), true);

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
