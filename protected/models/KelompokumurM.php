<?php

/**
 * This is the model class for table "kelompokumur_m".
 *
 * The followings are the available columns in table 'kelompokumur_m':
 * @property integer $kelompokumur_id
 * @property string $kelompokumur_nama
 * @property string $kelompokumur_namalainnya
 * @property string $kelompokumur_minimal
 * @property string $kelompokumur_maksimal
 * @property boolean $kelompokumur_aktif
 */
class KelompokumurM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokumurM the static model class
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
		return 'kelompokumur_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumur_nama, kelompokumur_minimal, kelompokumur_maksimal, kelompokumur_aktif', 'required'),
			array('kelompokumur_nama, kelompokumur_namalainnya', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompokumur_id, kelompokumur_nama, kelompokumur_namalainnya, kelompokumur_minimal, kelompokumur_maksimal, kelompokumur_aktif', 'safe', 'on'=>'search'),
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
			'kelompokumur_id' => 'ID',
			'kelompokumur_nama' => 'Nama',
			'kelompokumur_namalainnya' => 'Nama Lainnya',
			'kelompokumur_minimal' => 'Umur Minimal',
			'kelompokumur_maksimal' => 'Umur Maksimal',
			'kelompokumur_aktif' => 'Aktif',
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

		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(kelompokumur_namalainnya)',strtolower($this->kelompokumur_namalainnya),true);
		$criteria->compare('LOWER(kelompokumur_minimal)',strtolower($this->kelompokumur_minimal),true);
		$criteria->compare('LOWER(kelompokumur_maksimal)',strtolower($this->kelompokumur_maksimal),true);
		$criteria->compare('kelompokumur_aktif',$this->kelompokumur_aktif);
                $criteria->addCondition('kelompokumur_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(kelompokumur_namalainnya)',strtolower($this->kelompokumur_namalainnya),true);
		$criteria->compare('LOWER(kelompokumur_minimal)',strtolower($this->kelompokumur_minimal),true);
		$criteria->compare('LOWER(kelompokumur_maksimal)',strtolower($this->kelompokumur_maksimal),true);
		$criteria->compare('kelompokumur_aktif',$this->kelompokumur_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
}