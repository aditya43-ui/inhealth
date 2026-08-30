<?php

/**
 * This is the model class for table "riwayatresikokerja_r".
 *
 * The followings are the available columns in table 'riwayatresikokerja_r':
 * @property integer $riwayatresikokerja_id
 * @property integer $anamesa_id
 * @property string $jenis_faktor_resiko
 * @property string $nama_faktor_resiko
 * @property string $status_faktor_resiko
 */
class RiwayatresikokerjaR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatresikokerjaR the static model class
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
		return 'riwayatresikokerja_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anamesa_id, jenis_faktor_resiko, nama_faktor_resiko, status_faktor_resiko', 'required'),
			array('anamesa_id', 'numerical', 'integerOnly'=>true),
			array('jenis_faktor_resiko', 'length', 'max'=>20),
			array('nama_faktor_resiko', 'length', 'max'=>200),
			array('status_faktor_resiko', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatresikokerja_id, anamesa_id, jenis_faktor_resiko, nama_faktor_resiko, status_faktor_resiko', 'safe', 'on'=>'search'),
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
			'riwayatresikokerja_id' => 'Riwayatresikokerja',
			'anamesa_id' => 'Anamesa',
			'jenis_faktor_resiko' => 'Jenis Faktor Risiko',
			'nama_faktor_resiko' => 'Nama Faktor Risiko',
			'status_faktor_resiko' => 'Status Faktor Risiko',
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

		if(!empty($this->riwayatresikokerja_id)){
			$criteria->addCondition('riwayatresikokerja_id = '.$this->riwayatresikokerja_id);
		}
		if(!empty($this->anamesa_id)){
			$criteria->addCondition('anamesa_id = '.$this->anamesa_id);
		}
		$criteria->compare('LOWER(jenis_faktor_resiko)',strtolower($this->jenis_faktor_resiko),true);
		$criteria->compare('LOWER(nama_faktor_resiko)',strtolower($this->nama_faktor_resiko),true);
		$criteria->compare('LOWER(status_faktor_resiko)',strtolower($this->status_faktor_resiko),true);

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