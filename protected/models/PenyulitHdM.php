<?php

/**
 * This is the model class for table "penyulit_hd_m".
 *
 * The followings are the available columns in table 'penyulit_hd_m':
 * @property string $penyulit_hd_id
 * @property string $penyulit_hd_nama
 * @property string $penyulit_hd_namalainnya
 */
class PenyulitHdM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyulitHdM the static model class
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
		return 'penyulit_hd_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyulit_hd_nama, penyulit_hd_namalainnya', 'required'),
			array('penyulit_hd_nama, penyulit_hd_namalainnya', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyulit_hd_id, penyulit_hd_nama, penyulit_hd_namalainnya', 'safe', 'on'=>'search'),
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
			'penyulit_hd_id' => 'Penyulit Hd',
			'penyulit_hd_nama' => 'Nama Penyulit',
			'penyulit_hd_namalainnya' => 'Nama Penyulit Lainnya',
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

		$criteria->compare('penyulit_hd_id',$this->penyulit_hd_id,true);
		$criteria->compare('LOWER(penyulit_hd_nama)', strtolower($this->penyulit_hd_nama),true);
		$criteria->compare('LOWER(penyulit_hd_namalainnya)', strtolower($this->penyulit_hd_namalainnya),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('penyulit_hd_id',$this->penyulit_hd_id,true);
		$criteria->compare('LOWER(penyulit_hd_nama)', strtolower($this->penyulit_hd_nama),true);
		$criteria->compare('LOWER(penyulit_hd_namalainnya)', strtolower($this->penyulit_hd_namalainnya),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}