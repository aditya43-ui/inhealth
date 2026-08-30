<?php

/**
 * This is the model class for table "caramasuk_m".
 *
 * The followings are the available columns in table 'caramasuk_m':
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property string $caramasuk_namalainnya
 * @property boolean $caramasuk_aktif
 */
class CaramasukM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CaramasukM the static model class
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
		return 'caramasuk_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('caramasuk_nama', 'required'),
			array('caramasuk_nama, caramasuk_namalainnya', 'length', 'max'=>50),
			array('caramasuk_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('caramasuk_id, caramasuk_nama, caramasuk_namalainnya, caramasuk_aktif', 'safe', 'on'=>'search'),
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
			'caramasuk_id' => 'ID',
			'caramasuk_nama' => 'Cara Masuk',
			'caramasuk_namalainnya' => 'Nama Lainnya',
			'caramasuk_aktif' => 'Aktif',
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

		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(caramasuk_namalainnya)',strtolower($this->caramasuk_namalainnya),true);
		$criteria->compare('caramasuk_aktif',isset($this->caramasuk_aktif)?$this->caramasuk_aktif:true);
//                $criteria->addCondition('caramasuk_aktif is true');
               // $criteria->order = 'caramasuk_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(caramasuk_namalainnya)',strtolower($this->caramasuk_namalainnya),true);
//		$criteria->compare('caramasuk_aktif',$this->caramasuk_aktif);
                $criteria->limit = -1;
                $criteria->order = 'caramasuk_id';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
        public function beforeSave() {
            $this->caramasuk_nama = ucwords(strtolower($this->caramasuk_nama));
            $this->caramasuk_namalainnya = strtoupper($this->caramasuk_namalainnya);
            return parent::beforeSave();
        }
}