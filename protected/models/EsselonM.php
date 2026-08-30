<?php

/**
 * This is the model class for table "esselon_m".
 *
 * The followings are the available columns in table 'esselon_m':
 * @property integer $esselon_id
 * @property string $esselon_nama
 * @property string $esselon_namalainnya
 * @property boolean $esselon_aktif
 */
class EsselonM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EsselonM the static model class
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
		return 'esselon_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('esselon_nama', 'required'),
			array('esselon_nama, esselon_namalainnya', 'length', 'max'=>15),
			array('esselon_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('esselon_id, esselon_nama, esselon_namalainnya, esselon_aktif', 'safe', 'on'=>'search'),
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
			'esselon_id' => 'ID',
			'esselon_nama' => 'Nama',
			'esselon_namalainnya' => 'Nama lainnya',
			'esselon_aktif' => 'Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('LOWER(esselon_nama)',strtolower($this->esselon_nama),true);
		$criteria->compare('LOWER(esselon_namalainnya)',strtolower($this->esselon_namalainnya),true);
		$criteria->compare('esselon_aktif',$this->esselon_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('LOWER(esselon_nama)',strtolower($this->esselon_nama),true);
		$criteria->compare('LOWER(esselon_namalainnya)',strtolower($this->esselon_namalainnya),true);
		$criteria->compare('esselon_aktif',$this->esselon_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}