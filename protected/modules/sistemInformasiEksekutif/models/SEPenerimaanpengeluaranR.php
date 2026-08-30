<?php

/**
 * This is the model class for table "penerimaanpengeluaran_r".
 *
 * The followings are the available columns in table 'penerimaanpengeluaran_r':
 * @property integer $penerimaanpengeluaran_id
 * @property string $tanggal
 * @property double $penerimaan
 * @property double $pengeluaran
 */
class SEPenerimaanpengeluaranR extends PenerimaanpengeluaranR {

    public $jns_periode;
    public $periode, $jumlah_penerimaan, $jumlah_pengeluaran;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenerimaanpengeluaranR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'penerimaanpengeluaran_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('penerimaan, pengeluaran', 'numerical'),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('penerimaanpengeluaran_id, tanggal, penerimaan, pengeluaran', 'safe', 'on' => 'search'),
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
            'penerimaanpengeluaran_id' => 'Penerimaanpengeluaran',
            'tanggal' => 'Tanggal',
            'penerimaan' => 'Penerimaan',
            'pengeluaran' => 'Pengeluaran',
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

        if (!empty($this->penerimaanpengeluaran_id)) {
            $criteria->addCondition('penerimaanpengeluaran_id = ' . $this->penerimaanpengeluaran_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        $criteria->compare('penerimaan', $this->penerimaan);
        $criteria->compare('pengeluaran', $this->pengeluaran);

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
