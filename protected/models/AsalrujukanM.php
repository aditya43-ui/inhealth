<?php

/**
 * This is the model class for table "asalrujukan_m".
 *
 * The followings are the available columns in table 'asalrujukan_m':
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property string $asalrujukan_institusi
 * @property string $asalrujukan_namalainnya
 * @property boolean $asalrujukan_aktif
 */
class AsalrujukanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsalrujukanM the static model class
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
		return 'asalrujukan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asalrujukan_nama', 'required'),
			array('asalrujukan_nama', 'length', 'max'=>50),
			array('asalrujukan_institusi, asalrujukan_namalainnya', 'length', 'max'=>20),
			array('asalrujukan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asalrujukan_id, asalrujukan_nama, asalrujukan_institusi, asalrujukan_namalainnya, asalrujukan_aktif', 'safe', 'on'=>'search'),
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
			'asalrujukan_id' => 'ID',
			'asalrujukan_nama' => 'Asal Rujukan',
			'asalrujukan_institusi' => 'Institusi Asal Rujukan',
			'asalrujukan_namalainnya' => 'Nama Lain Asal Rujukan',
			'asalrujukan_aktif' => 'Aktif',
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

		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
		$criteria->compare('LOWER(asalrujukan_namalainnya)',strtolower($this->asalrujukan_namalainnya),true);
		$criteria->compare('asalrujukan_aktif',isset($this->asalrujukan_aktif)?$this->asalrujukan_aktif:true);
//                $criteria->addCondition('asalrujukan_aktif is true');
                //$criteria->order = 'asalrujukan_id ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('LOWER(asalrujukan_institusi)',strtolower($this->asalrujukan_institusi),true);
		$criteria->compare('LOWER(asalrujukan_namalainnya)',strtolower($this->asalrujukan_namalainnya),true);
//		$criteria->compare('asalrujukan_aktif',$this->asalrujukan_aktif);
               // $criteria->order = 'asalrujukan_id';
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                    
		));
	}
        
        public function beforeSave() {
            $this->asalrujukan_nama = ucwords(strtolower($this->asalrujukan_nama));
            $this->asalrujukan_institusi = ucwords(strtolower($this->asalrujukan_institusi));
            $this->asalrujukan_namalainnya = strtoupper($this->asalrujukan_namalainnya);
            return parent::beforeSave();
        }
}