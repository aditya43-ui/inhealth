<?php

/**
 * This is the model class for table "warnanomorrm_m".
 *
 * The followings are the available columns in table 'warnanomorrm_m':
 * @property integer $warnanomorrm_id
 * @property integer $warnanomorrm_angka
 * @property string $warnanomorrm_warna
 * @property string $warnanomorrm_kodewarna
 * @property boolean $warnanomorrm_aktif
 */
class WarnanomorrmM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WarnanomorrmM the static model class
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
		return 'warnanomorrm_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warnanomorrm_angka, warnanomorrm_warna', 'required'),
			array('warnanomorrm_angka', 'numerical', 'integerOnly'=>true),
			array('warnanomorrm_warna, warnanomorrm_kodewarna', 'length', 'max'=>20),
                        array('warnanomorrm_angka','length','max'=>5),
                        array('warnanomorrm_angka','compare','operator'=>'<=','compareValue'=>32767),
                        array('warnanomorrm_angka','compare','operator'=>'>=','compareValue'=>0),
			array('warnanomorrm_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('warnanomorrm_id, warnanomorrm_angka, warnanomorrm_warna, warnanomorrm_kodewarna, warnanomorrm_aktif', 'safe', 'on'=>'search'),
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
			'warnanomorrm_id' => 'Warna Nomor ID',
			'warnanomorrm_angka' => 'Warna Angka',
			'warnanomorrm_warna' => 'Warna',
			'warnanomorrm_kodewarna' => 'Kode Warna',
			'warnanomorrm_aktif' => 'Aktif',
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

		$criteria->compare('warnanomorrm_id',$this->warnanomorrm_id);
		$criteria->compare('warnanomorrm_angka',$this->warnanomorrm_angka);
		$criteria->compare('LOWER(warnanomorrm_warna)',strtolower($this->warnanomorrm_warna),true);
		$criteria->compare('LOWER(warnanomorrm_kodewarna)',strtolower($this->warnanomorrm_kodewarna),true);
		$criteria->compare('warnanomorrm_aktif',isset($this->warnanomorrm_aktif)?$this->warnanomorrm_aktif:true);
                //$criteria->addCondition('warnanomorrm_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('warnanomorrm_id',$this->warnanomorrm_id);
		$criteria->compare('warnanomorrm_angka',$this->warnanomorrm_angka);
		$criteria->compare('LOWER(warnanomorrm_warna)',strtolower($this->warnanomorrm_warna),true);
		$criteria->compare('LOWER(warnanomorrm_kodewarna)',strtolower($this->warnanomorrm_kodewarna),true);
		$criteria->compare('warnanomorrm_aktif',$this->warnanomorrm_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}