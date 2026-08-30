<?php

/**
 * This is the model class for table "rakpenyimpanan_m".
 *
 * The followings are the available columns in table 'rakpenyimpanan_m':
 * @property integer $rakpenyimpanan_id
 * @property integer $lokasipenyimpanan_id
 * @property string $rakpenyimpanan_label
 * @property string $rakpenyimpanan_kode
 * @property string $rakpenyimpanan_nama
 * @property string $rakpenyimpanan_namalain
 * @property boolean $rakpenyimpanan_aktif
 */
class RakpenyimpananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RakpenyimpananM the static model class
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
		return 'rakpenyimpanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasipenyimpanan_id, rakpenyimpanan_label, rakpenyimpanan_kode, rakpenyimpanan_nama, rakpenyimpanan_namalain', 'required'),
			array('lokasipenyimpanan_id', 'numerical', 'integerOnly'=>true),
			array('rakpenyimpanan_label', 'length', 'max'=>10),
			array('rakpenyimpanan_kode', 'length', 'max'=>5),
			array('rakpenyimpanan_nama, rakpenyimpanan_namalain', 'length', 'max'=>100),
			array('rakpenyimpanan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rakpenyimpanan_id, lokasipenyimpanan_id, rakpenyimpanan_label, rakpenyimpanan_kode, rakpenyimpanan_nama, rakpenyimpanan_namalain, rakpenyimpanan_aktif', 'safe', 'on'=>'search'),
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
			 'lokasipenyimpanan' => array(self::BELONGS_TO, 'LokasipenyimpananM', 'lokasipenyimpanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rakpenyimpanan_id' => 'ID',
			'lokasipenyimpanan_id' => 'Lokasi Penyimpanan',
			'rakpenyimpanan_label' => 'Label',
			'rakpenyimpanan_kode' => 'Kode',
			'rakpenyimpanan_nama' => 'Nama',
			'rakpenyimpanan_namalain' => 'Nama Lain',
			'rakpenyimpanan_aktif' => 'Aktif',
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

		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		$criteria->compare('LOWER(rakpenyimpanan_label)',strtolower($this->rakpenyimpanan_label),true);
		$criteria->compare('LOWER(rakpenyimpanan_kode)',strtolower($this->rakpenyimpanan_kode),true);
		$criteria->compare('LOWER(rakpenyimpanan_nama)',strtolower($this->rakpenyimpanan_nama),true);
		$criteria->compare('LOWER(rakpenyimpanan_namalain)',strtolower($this->rakpenyimpanan_namalain),true);
		$criteria->compare('rakpenyimpanan_aktif',isset($this->rakpenyimpanan_aktif)?$this->rakpenyimpanan_aktif:true);

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