<?php

/**
 * This is the model class for table "suku_m".
 *
 * The followings are the available columns in table 'suku_m':
 * @property integer $suku_id
 * @property string $suku_nama
 * @property string $suku_namalainnya
 * @property boolean $suku_aktif
 */
class SukuM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SukuM the static model class
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
		return 'suku_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suku_nama', 'required'),
			array('suku_nama, suku_namalainnya', 'length', 'max'=>50),
			array('suku_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suku_id, suku_nama, suku_namalainnya, suku_aktif', 'safe', 'on'=>'search'),
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
			'suku_id' => 'ID',
			'suku_nama' => 'Suku',
			'suku_namalainnya' => 'Nama Lainnya',
			'suku_aktif' => 'Aktif',
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

		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		$criteria->compare('LOWER(suku_namalainnya)',strtolower($this->suku_namalainnya),true);
		$criteria->compare('suku_aktif',isset($this->suku_aktif)?$this->suku_aktif:true);
                //$criteria->addCondition('suku_aktif is true');
//                $criteria->order='suku_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		$criteria->compare('LOWER(suku_namalainnya)',strtolower($this->suku_namalainnya),true);
		$criteria->compare('suku_aktif',isset($this->suku_aktif)?$this->suku_aktif:true);
//		$criteria->compare('suku_aktif',$this->suku_aktif);
                $criteria->order='suku_id';
                $criteria->limit=-1;
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
          public function beforeSave() {
            $this->suku_nama = ucwords(strtolower($this->suku_nama));
            $this->suku_namalainnya = strtoupper($this->suku_namalainnya);
            return parent::beforeSave();
        }
}