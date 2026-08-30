<?php

/**
 * This is the model class for table "mapbarangsterilisasi_m".
 *
 * The followings are the available columns in table 'mapbarangsterilisasi_m':
 * @property integer $peralatansterilisasi_id
 * @property integer $barang_id
 */
class MapbarangsterilisasiM extends CActiveRecord
{
        public $peralatansterilisasi_nama;
        public $barang_nama;
        public $jenisperalatan;
        public $nama;
        public $jml;
        public $map_id;
        public $item_id, $item_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MapbarangsterilisasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mapbarangsterilisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('peralatansterilisasi_id, barang_id', 'required'),
			array('peralatansterilisasi_id, barang_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('peralatansterilisasi_id, barang_id', 'safe', 'on'=>'search'),
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
                    'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'peralatansterilisasi_id' => 'Peralatansterilisasi',
			'barang_id' => 'Barang',
			'jmlbarang' => 'Jumlah Barang',
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

		if(!empty($this->peralatansterilisasi_id)){
			$criteria->addCondition('peralatansterilisasi_id = '.$this->peralatansterilisasi_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        
       
}