<?php

/**
 * This is the model class for table "riwayattht_r".
 *
 * The followings are the available columns in table 'riwayattht_r':
 * @property integer $riwayattht_id
 * @property integer $pemeriksaanfisik_id
 * @property string $jenis_tht
 * @property string $bagian_tht
 * @property string $status_bagiantht
 */
class RiwayatthtR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatthtR the static model class
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
		return 'riwayattht_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanfisik_id, jenis_tht, bagian_tht, status_bagiantht', 'required'),
			array('pemeriksaanfisik_id', 'numerical', 'integerOnly'=>true),
			array('jenis_tht, status_bagiantht', 'length', 'max'=>20),
			array('bagian_tht', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayattht_id, pemeriksaanfisik_id, jenis_tht, bagian_tht, status_bagiantht', 'safe', 'on'=>'search'),
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
			'riwayattht_id' => 'Riwayattht',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'jenis_tht' => 'Jenis Tht',
			'bagian_tht' => 'Bagian Tht',
			'status_bagiantht' => 'Status Bagiantht',
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

		if(!empty($this->riwayattht_id)){
			$criteria->addCondition('riwayattht_id = '.$this->riwayattht_id);
		}
		if(!empty($this->pemeriksaanfisik_id)){
			$criteria->addCondition('pemeriksaanfisik_id = '.$this->pemeriksaanfisik_id);
		}
		$criteria->compare('LOWER(jenis_tht)',strtolower($this->jenis_tht),true);
		$criteria->compare('LOWER(bagian_tht)',strtolower($this->bagian_tht),true);
		$criteria->compare('LOWER(status_bagiantht)',strtolower($this->status_bagiantht),true);

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