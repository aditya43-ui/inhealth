<?php

/**
 * This is the model class for table "hutangpiutang_r".
 *
 * The followings are the available columns in table 'hutangpiutang_r':
 * @property integer $hutangpiutang_id
 * @property string $tanggal
 * @property double $hutang
 * @property double $piutang
 */
class SEHutangpiutangR extends HutangpiutangR {

    public $jns_periode;
    public $periode, $jumlah_hutang, $jumlah_piutang;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HutangpiutangR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hutangpiutang_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hutang, piutang', 'numerical'),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('hutangpiutang_id, tanggal, hutang, piutang', 'safe', 'on' => 'search'),
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
            'hutangpiutang_id' => 'Hutangpiutang',
            'tanggal' => 'Tanggal',
            'hutang' => 'Hutang',
            'piutang' => 'Piutang',
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

        if (!empty($this->hutangpiutang_id)) {
            $criteria->addCondition('hutangpiutang_id = ' . $this->hutangpiutang_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        $criteria->compare('hutang', $this->hutang);
        $criteria->compare('piutang', $this->piutang);

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
