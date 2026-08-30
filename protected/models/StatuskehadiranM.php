<?php

/**
 * This is the model class for table "statuskehadiran_m".
 *
 * The followings are the available columns in table 'statuskehadiran_m':
 * @property integer $statuskehadiran_id
 * @property string $statuskehadiran_nama
 * @property string $statuskehadiran_singkatan
 * @property boolean $statuskehadiran_aktif
 */
class StatuskehadiranM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatuskehadiranM the static model class
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
		return 'statuskehadiran_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statuskehadiran_nama, statuskehadiran_singkatan', 'required'),
			array('statuskehadiran_nama', 'length', 'max'=>50),
			array('statuskehadiran_singkatan', 'length', 'max'=>1),
			array('statuskehadiran_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statuskehadiran_id, statuskehadiran_nama, statuskehadiran_singkatan, statuskehadiran_aktif', 'safe', 'on'=>'search'),
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
			'statuskehadiran_id' => 'ID Status Kehadiran',
			'statuskehadiran_nama' => 'Status Kehadiran',
			'statuskehadiran_singkatan' => 'Singkatan',
			'statuskehadiran_aktif' => 'Aktif',
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

		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
		$criteria->compare('LOWER(statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);
		$criteria->compare('LOWER(statuskehadiran_singkatan)',strtolower($this->statuskehadiran_singkatan),true);
		$criteria->compare('statuskehadiran_aktif',isset($this->statuskehadiran_aktif)?$this->statuskehadiran_aktif:true);
                //$criteria->addCondition('statuskehadiran_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
		$criteria->compare('LOWER(statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);
		$criteria->compare('LOWER(statuskehadiran_singkatan)',strtolower($this->statuskehadiran_singkatan),true);
		$criteria->compare('statuskehadiran_aktif',$this->statuskehadiran_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}