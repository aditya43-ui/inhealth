<?php

/**
 * This is the model class for table "penyimpanansterildet_t".
 *
 * The followings are the available columns in table 'penyimpanansterildet_t':
 * @property integer $penyimpanansterildet_id
 * @property integer $rakpenyimpanan_id
 * @property integer $penyimpanansteril_id
 * @property integer $lokasipenyimpanan_id
 * @property integer $sterilisasi_id
 * @property integer $barang_id
 * @property string $penyimpanansterildet_ket
 * @property integer $penyimpanansterildet_jml
 */
class PenyimpanansterildetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyimpanansterildetT the static model class
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
		return 'penyimpanansterildet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rakpenyimpanan_id, penyimpanansteril_id, lokasipenyimpanan_id, peralatansterilisasi_id', 'required'),
			array('rakpenyimpanan_id, penyimpanansteril_id, lokasipenyimpanan_id, sterilisasi_id, peralatansterilisasi_id', 'numerical', 'integerOnly'=>true),
			array('penyimpanansterildet_ket', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyimpanansterildet_id, rakpenyimpanan_id, penyimpanansteril_id, lokasipenyimpanan_id, sterilisasi_id, peralatansterilisasi_id, penyimpanansterildet_ket', 'safe', 'on'=>'search'),
			array('rakpenyimpanan_id, penyimpanansteril_id, lokasipenyimpanan_id, sterilisasi_id, peralatansterilisasi_id, penyimpanansterildet_jml', 'numerical', 'integerOnly'=>true),
			array('penyimpanansterildet_ket, barang_id, sterilisasidetail_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyimpanansterildet_id, rakpenyimpanan_id, penyimpanansteril_id, lokasipenyimpanan_id, sterilisasi_id, peralatansterilisasi_id, penyimpanansterildet_ket, penyimpanansterildet_jml, barang_id', 'safe', 'on'=>'search'),
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
			'peralatansterilisasi'=>array(self::BELONGS_TO,'PeralatansterilisasiM','peralatansterilisasi_id'),
			'rakpenyimpanan'=>array(self::BELONGS_TO,'RakpenyimpananM','rakpenyimpanan_id'),
			'penyimpanansteril'=>array(self::BELONGS_TO,'PenyimpanansterilT','penyimpanansteril_id'),
			'lokasipenyimpanan'=>array(self::BELONGS_TO,'LokasipenyimpananM','lokasipenyimpanan_id'),
			'sterilisasi'=>array(self::BELONGS_TO,'SterilisasiT','sterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyimpanansterildet_id' => 'ID Penyimpanan Steril Detail',
			'rakpenyimpanan_id' => 'Rak. Penyimpanan',
			'penyimpanansteril_id' => 'ID Penyimpanan Steril',
			'lokasipenyimpanan_id' => 'Lokasi Penyimpanan',
			'sterilisasi_id' => 'Sterilisasi',
			'peralatansterilisasi_id' => 'Peralatan Sterilisasi',
			'penyimpanansterildet_ket' => 'Keterangan',
			'penyimpanansterildet_jml' => 'Jumlah',
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

		if(!empty($this->penyimpanansterildet_id)){
			$criteria->addCondition('penyimpanansterildet_id = '.$this->penyimpanansterildet_id);
		}
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->penyimpanansteril_id)){
			$criteria->addCondition('penyimpanansteril_id = '.$this->penyimpanansteril_id);
		}
		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		if(!empty($this->peralatansterilisasi_id)){
			$criteria->addCondition('peralatansterilisasi_id = '.$this->peralatansterilisasi_id);
		}
		$criteria->compare('LOWER(penyimpanansterildet_ket)',strtolower($this->penyimpanansterildet_ket),true);
		if(!empty($this->penyimpanansterildet_jml)){
			$criteria->addCondition('penyimpanansterildet_jml = '.$this->penyimpanansterildet_jml);
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