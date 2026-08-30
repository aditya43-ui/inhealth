<?php

/**
 * This is the model class for table "subrak_m".
 *
 * The followings are the available columns in table 'subrak_m':
 * @property integer $subrak_id
 * @property string $subrak_nama
 * @property string $subrak_namalainnya
 * @property boolean $subrak_aktif
 */
class SubrakM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubrakM the static model class
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
		return 'subrak_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subrak_nama', 'required'),
			array('subrak_nama, subrak_namalainnya', 'length', 'max'=>30),
			array('subrak_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subrak_id, subrak_nama, subrak_namalainnya, subrak_aktif', 'safe', 'on'=>'search'),
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
			'subrak_id' => 'ID',
			'subrak_nama' => 'Nama Sub Rak',
			'subrak_namalainnya' => 'Nama Lainnya',
			'subrak_aktif' => 'Aktif',
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

		$criteria->compare('subrak_id',$this->subrak_id);
		$criteria->compare('LOWER(subrak_nama)',strtolower($this->subrak_nama),true);
		$criteria->compare('LOWER(subrak_namalainnya)',strtolower($this->subrak_namalainnya),true);
		$criteria->compare('subrak_aktif',isset($this->subrak_aktif)?$this->subrak_aktif:true);
                //$criteria->addCondition('subrak_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('subrak_id',$this->subrak_id);
		$criteria->compare('LOWER(subrak_nama)',strtolower($this->subrak_nama),true);
		$criteria->compare('LOWER(subrak_namalainnya)',strtolower($this->subrak_namalainnya),true);
		$criteria->compare('subrak_aktif',$this->subrak_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}