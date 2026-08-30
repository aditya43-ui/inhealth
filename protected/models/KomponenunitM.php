<?php

/**
 * This is the model class for table "komponenunit_m".
 *
 * The followings are the available columns in table 'komponenunit_m':
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property string $komponenunit_namalainnya
 * @property boolean $komponenunit_aktif
 */
class KomponenunitM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponenunitM the static model class
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
		return 'komponenunit_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('komponenunit_nama','required'),
			array('komponenunit_nama, komponenunit_namalainnya', 'length', 'max'=>30),
			array('komponenunit_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponenunit_id, komponenunit_nama, komponenunit_namalainnya, komponenunit_aktif', 'safe', 'on'=>'search'),
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
			'komponenunit_id' => 'ID',
			'komponenunit_nama' => 'Komponen Unit',
			'komponenunit_namalainnya' => 'Nama Lain',
			'komponenunit_aktif' => 'Aktif',
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

		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->compare('LOWER(komponenunit_namalainnya)',strtolower($this->komponenunit_namalainnya),true);
		$criteria->compare('komponenunit_aktif',isset($this->komponenunit_aktif)?$this->komponenunit_aktif:true);
                //$criteria->addCondition('komponenunit_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('LOWER(komponenunit_nama)',strtolower($this->komponenunit_nama),true);
		$criteria->compare('LOWER(komponenunit_namalainnya)',strtolower($this->komponenunit_namalainnya),true);
//		$criteria->compare('komponenunit_aktif',$this->komponenunit_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave(){
            $this->komponenunit_nama = ucwords(strtolower($this->komponenunit_nama));
            $this->komponenunit_namalainnya = strtoupper($this->komponenunit_namalainnya);
            return parent::beforeSave();
        }
        
        public static function getItems() {
            return self::model()->findAll(array(
                'condition'=>'komponenunit_aktif = true',
                'order'=>'komponenunit_nama',
            ));
        }
}