<?php

/**
 * This is the model class for table "terapipascaanastesi_t".
 * @author rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * The followings are the available columns in table 'terapipascaanastesi_t':
 * @property integer $terapipascaanastesi_id
 * @property integer $pesananpascaanastesi_t
 * @property string $nama_terapi
 */
class TerapipascaanastesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerapipascaanastesiT the static model class
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
		return 'terapipascaanastesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesananpascaanastesi_id', 'required'),
			array('pesananpascaanastesi_id', 'numerical', 'integerOnly'=>true),
			array('nama_terapi', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesananpascaanastesi_id, nama_terapi', 'safe', 'on'=>'search'),
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
			'terapipascaanastesi_id' => 'Terapipascaanastesi',
			'pesananpascaanastesi_id' => 'Pesananpascaanastesi T',
			'nama_terapi' => 'Nama Terapi',
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

		if(!empty($this->terapipascaanastesi_id)){
			$criteria->addCondition('terapipascaanastesi_id = '.$this->terapipascaanastesi_id);
		}
		if(!empty($this->pesananpascaanastesi_id)){
			$criteria->addCondition('pesananpascaanastesi_id = '.$this->pesananpascaanastesi_id);
		}
		$criteria->compare('LOWER(nama_terapi)',strtolower($this->nama_terapi),true);

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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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