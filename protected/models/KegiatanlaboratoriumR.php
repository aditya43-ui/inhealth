<?php

/**
 * This is the model class for table "kegiatanlaboratorium_r".
 *
 * The followings are the available columns in table 'kegiatanlaboratorium_r':
 * @property integer $kegiatanlaboratorium_id
 * @property string $tanggal
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_nama
 * @property integer $jumlah
 */
class KegiatanlaboratoriumR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanlaboratoriumR the static model class
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
		return 'kegiatanlaboratorium_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispemeriksaanlab_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('jenispemeriksaanlab_nama', 'length', 'max'=>30),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanlaboratorium_id, tanggal, jenispemeriksaanlab_id, jenispemeriksaanlab_nama, jumlah', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kegiatanlaboratorium_id' => 'Kegiatanlaboratorium',
			'tanggal' => 'Tanggal',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
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

		if(!empty($this->kegiatanlaboratorium_id)){
			$criteria->addCondition('kegiatanlaboratorium_id = '.$this->kegiatanlaboratorium_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->jenispemeriksaanlab_id)){
			$criteria->addCondition('jenispemeriksaanlab_id = '.$this->jenispemeriksaanlab_id);
		}
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		if(!empty($this->jumlah)){
			$criteria->addCondition('jumlah = '.$this->jumlah);
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