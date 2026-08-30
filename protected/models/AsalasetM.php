<?php

/**
 * This is the model class for table "asalaset_m".
 *
 * The followings are the available columns in table 'asalaset_m':
 * @property integer $asalaset_id
 * @property string $asalaset_nama
 * @property string $asalaset_singkatan
 * @property boolean $asalaset_aktif
 */
class AsalasetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsalasetM the static model class
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
		return 'asalaset_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asalaset_nama, asalaset_singkatan, asalaset_aktif', 'required'),
			array('asalaset_nama', 'length', 'max'=>50),
			array('asalaset_singkatan', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asalaset_id, asalaset_nama, asalaset_singkatan, asalaset_aktif', 'safe', 'on'=>'search'),
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
			'asalaset_id' => 'ID',
			'asalaset_nama' => ' Nama Asal Aset',
			'asalaset_singkatan' => ' Singkatan Asal Aset',
			'asalaset_aktif' => 'Aktif',
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

		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('LOWER(asalaset_nama)',strtolower($this->asalaset_nama),true);
		$criteria->compare('LOWER(asalaset_singkatan)',strtolower($this->asalaset_singkatan),true);
		$criteria->compare('asalaset_aktif',isset($this->asalaset_aktif)?$this->asalaset_aktif:true);
//                $criteria->addCondition('asalaset_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('asalaset_id',$this->asalaset_id);
		$criteria->compare('LOWER(asalaset_nama)',strtolower($this->asalaset_nama),true);
		$criteria->compare('LOWER(asalaset_singkatan)',strtolower($this->asalaset_singkatan),true);
		//$criteria->compare('asalaset_aktif',$this->asalaset_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}