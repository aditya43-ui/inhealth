<?php

/**
 * This is the model class for table "lokasirak_m".
 *
 * The followings are the available columns in table 'lokasirak_m':
 * @property integer $lokasirak_id
 * @property string $lokasirak_nama
 * @property string $lokasirak_namalainnya
 * @property boolean $lokasirak_aktif
 */
class LokasirakM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasirakM the static model class
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
		return 'lokasirak_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasirak_nama', 'required'),
			array('lokasirak_nama, lokasirak_namalainnya', 'length', 'max'=>100),
			array('lokasirak_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasirak_id, lokasirak_nama, lokasirak_namalainnya, lokasirak_aktif', 'safe', 'on'=>'search'),
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
			'lokasirak_id' => 'ID',
			'lokasirak_nama' => 'Nama Lokasi Rak',
			'lokasirak_namalainnya' => 'Nama Lainnya',
			'lokasirak_aktif' => 'Aktif',
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

		$criteria->compare('lokasirak_id',$this->lokasirak_id);
		$criteria->compare('LOWER(lokasirak_nama)',strtolower($this->lokasirak_nama),true);
		$criteria->compare('LOWER(lokasirak_namalainnya)',strtolower($this->lokasirak_namalainnya),true);
		$criteria->compare('lokasirak_aktif',isset($this->lokasirak_aktif)?$this->lokasirak_aktif:true);
                //$criteria->addCondition('lokasirak_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('lokasirak_id',$this->lokasirak_id);
		$criteria->compare('LOWER(lokasirak_nama)',strtolower($this->lokasirak_nama),true);
		$criteria->compare('LOWER(lokasirak_namalainnya)',strtolower($this->lokasirak_namalainnya),true);
		$criteria->compare('lokasirak_aktif',$this->lokasirak_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}