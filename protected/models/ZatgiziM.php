<?php

/**
 * This is the model class for table "zatgizi_m".
 *
 * The followings are the available columns in table 'zatgizi_m':
 * @property integer $zatgizi_id
 * @property string $zatgizi_nama
 * @property string $zatgizi_satuan
 * @property string $zatgizi_namalainnya
 * @property boolean $zatgizi_aktif
 */
class ZatgiziM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ZatgiziM the static model class
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
		return 'zatgizi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zatgizi_nama', 'required'),
			array('zatgizi_nama, zatgizi_namalainnya', 'length', 'max'=>30),
			array('zatgizi_satuan', 'length', 'max'=>10),
			array('zatgizi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zatgizi_id, zatgizi_nama, zatgizi_satuan, zatgizi_namalainnya, zatgizi_aktif', 'safe', 'on'=>'search'),
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
			'zatgizi_id' => 'ID',
			'zatgizi_nama' => ' Nama Zat Gizi',
			'zatgizi_satuan' => ' Satuan',
			'zatgizi_namalainnya' => ' Nama Lain Zat',
			'zatgizi_aktif' => ' Aktif',
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

		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('LOWER(zatgizi_nama)',strtolower($this->zatgizi_nama),true);
		$criteria->compare('LOWER(zatgizi_satuan)',strtolower($this->zatgizi_satuan),true);
		$criteria->compare('LOWER(zatgizi_namalainnya)',strtolower($this->zatgizi_namalainnya),true);
		$criteria->compare('zatgizi_aktif',isset($this->zatgizi_aktif)?$this->zatgizi_aktif:true);
		//$criteria->order='zatgizi_id';
//                $criteria->addCondition('zatgizi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('zatgizi_id',$this->zatgizi_id);
		$criteria->compare('LOWER(zatgizi_nama)',strtolower($this->zatgizi_nama),true);
		$criteria->compare('LOWER(zatgizi_satuan)',strtolower($this->zatgizi_satuan),true);
		$criteria->compare('LOWER(zatgizi_namalainnya)',strtolower($this->zatgizi_namalainnya),true);
		//$criteria->compare('zatgizi_aktif',$this->zatgizi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->compare('zatgizi_aktif',isset($this->zatgizi_aktif)?$this->zatgizi_aktif:true);
		$criteria->order='zatgizi_id';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}