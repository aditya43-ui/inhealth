<?php

/**
 * This is the model class for table "riwayatindividu_r".
 *
 * The followings are the available columns in table 'riwayatindividu_r':
 * @property integer $riwayatindividu_id
 * @property integer $anamesa_id
 * @property string $nama_riwayat_individu
 * @property string $status_riwayatinidividu
 */
class RiwayatindividuR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatindividuR the static model class
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
		return 'riwayatindividu_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anamesa_id, nama_riwayat_individu, status_riwayatinidividu', 'required'),
			array('anamesa_id', 'numerical', 'integerOnly'=>true),
			array('nama_riwayat_individu', 'length', 'max'=>200),
			array('status_riwayatinidividu', 'length', 'max'=>200), // telah dilakukan perubahan juga di db LNG-1014
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatindividu_id, anamesa_id, nama_riwayat_individu, status_riwayatinidividu', 'safe', 'on'=>'search'),
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
			'riwayatindividu_id' => 'Riwayatindividu',
			'anamesa_id' => 'Anamesa',
			'nama_riwayat_individu' => 'Nama Riwayat Individu',
			'status_riwayatinidividu' => 'Status Riwayatinidividu',
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

		if(!empty($this->riwayatindividu_id)){
			$criteria->addCondition('riwayatindividu_id = '.$this->riwayatindividu_id);
		}
		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		$criteria->compare('LOWER(nama_riwayat_individu)',strtolower($this->nama_riwayat_individu),true);
		$criteria->compare('LOWER(status_riwayatinidividu)',strtolower($this->status_riwayatinidividu),true);

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