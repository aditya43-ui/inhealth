<?php

/**
 * This is the model class for table "informasifarmasi_r".
 *
 * The followings are the available columns in table 'informasifarmasi_r':
 * @property integer $informasifarmasi_id
 * @property string $tanggal
 * @property integer $obatalkes_id
 * @property string $obatalkes_nama
 * @property integer $jumlah
 */
class SEInformasifarmasiR extends InformasifarmasiR {

    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasifarmasiR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'informasifarmasi_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('obatalkes_id, jumlah', 'numerical', 'integerOnly' => true),
            array('obatalkes_nama', 'length', 'max' => 200),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('informasifarmasi_id, tanggal, obatalkes_id, obatalkes_nama, jumlah', 'safe', 'on' => 'search'),
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
            'informasifarmasi_id' => 'Informasifarmasi',
            'tanggal' => 'Tanggal',
            'obatalkes_id' => 'Obatalkes',
            'obatalkes_nama' => 'Obatalkes Nama',
            'jumlah' => 'Jumlah',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('tanggal',$this->tgl_awal,$this->tgl_akhir);
                if(is_array($this->obatalkes_id)){
                    $criteria->addInCondition('obatalkes_id', $this->obatalkes_id);
                }else{
                    $criteria->compare('obatalkes_id',$this->obatalkes_id);
                }        
		return $criteria;
	}
        
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
                $criteria->group = "obatalkes_id, obatalkes_nama, tanggal";
                $criteria->select = $criteria->group.", tanggal AS periode, SUM(jumlah) AS jumlah";
                $criteria->order = "periode ASC, jumlah DESC";
                $criteria->limit = 50;
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
