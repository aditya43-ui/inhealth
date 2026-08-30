<?php

/**
 * This is the model class for table "keadaanumum_m".
 *
 * The followings are the available columns in table 'keadaanumum_m':
 * @property integer $keadaanumum_id
 * @property string $keadaanumum_nama
 */
class KeadaanumumM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeadaanumumM the static model class
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
		return 'keadaanumum_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keadaanumum_nama', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keadaanumum_id, keadaanumum_nama', 'safe', 'on'=>'search'),
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
			'keadaanumum_id' => 'Id',
			'keadaanumum_nama' => 'Nama Keadaan Umum',
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

		$criteria->compare('keadaanumum_id',$this->keadaanumum_id);
		$criteria->compare('LOWER(keadaanumum_nama)',strtolower($this->keadaanumum_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('keadaanumum_id',$this->keadaanumum_id);
		$criteria->compare('LOWER(keadaanumum_nama)',strtolower($this->keadaanumum_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}