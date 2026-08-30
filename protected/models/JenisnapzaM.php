<?php

/**
 * This is the model class for table "jenisnapza_m".
 *
 * The followings are the available columns in table 'jenisnapza_m':
 * @property integer $jenisnapza_id
 * @property string $jenisnapza_nama
 * @property string $jenisnapza_desc
 * @property boolean $jenisnapza_aktif
 */
class JenisnapzaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisnapzaM the static model class
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
		return 'jenisnapza_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisnapza_nama', 'required'),
			array('jenisnapza_nama', 'length', 'max'=>100),
			array('jenisnapza_desc, jenisnapza_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisnapza_id, jenisnapza_nama, jenisnapza_desc, jenisnapza_aktif', 'safe', 'on'=>'search'),
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
			'jenisnapza_id' => 'ID',
			'jenisnapza_nama' => 'Nama Jenis Napza',
			'jenisnapza_desc' => 'Deskripsi',
			'jenisnapza_aktif' => 'Jenis Napza Aktif',
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

		$criteria->compare('jenisnapza_id',$this->jenisnapza_id);
		$criteria->compare('LOWER(jenisnapza_nama)',strtolower($this->jenisnapza_nama),true);
		$criteria->compare('LOWER(jenisnapza_desc)',strtolower($this->jenisnapza_desc),true);
		$criteria->compare('jenisnapza_aktif',isset($this->jenisnapza_aktif)?$this->jenisnapza_aktif:true);
//                $criteria->addCondition('jenisnapza_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisnapza_id',$this->jenisnapza_id);
		$criteria->compare('LOWER(jenisnapza_nama)',strtolower($this->jenisnapza_nama),true);
		$criteria->compare('LOWER(jenisnapza_desc)',strtolower($this->jenisnapza_desc),true);
		//$criteria->compare('jenisnapza_aktif',$this->jenisnapza_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}