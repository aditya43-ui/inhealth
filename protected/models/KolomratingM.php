<?php

/**
 * This is the model class for table "kolomrating_m".
 *
 * The followings are the available columns in table 'kolomrating_m':
 * @property integer $kolomrating_id
 * @property integer $indikatorperilaku_id
 * @property string $kolomrating_namalevel
 * @property integer $kolomrating_point
 * @property string $kolomrating_uraian
 * @property string $kolomrating_deskripsi
 * @property boolean $kolomrating_aktif
 */
class KolomratingM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KolomratingM the static model class
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
		return 'kolomrating_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kolomrating_namalevel, kolomrating_point, kolomrating_nilaiawal, kolomrating_nilaiakhir', 'required'),
			array('indikatorperilaku_id, kolomrating_point', 'numerical', 'integerOnly'=>true),
			array('kolomrating_namalevel', 'length', 'max'=>100),
			array('kolomrating_uraian', 'length', 'max'=>500),
			array('kolomrating_aktif, kolomrating_uraian, kolomrating_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kolomrating_id, indikatorperilaku_id, kolomrating_namalevel, kolomrating_point, kolomrating_uraian, kolomrating_deskripsi, kolomrating_aktif', 'safe', 'on'=>'search'),
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
			'kolomrating_id' => 'Kolom Rating',
			'indikatorperilaku_id' => 'Indikator Perilaku',
			'kolomrating_namalevel' => 'Nama Level',
			'kolomrating_point' => 'Point',
			'kolomrating_uraian' => 'Uraian',
			'kolomrating_deskripsi' => 'Deskripsi',
			'kolomrating_aktif' => 'Status',
                        'kolomrating_nilaiawal' => 'Skor Awal',
                        'kolomrating_nilaiakhir' => 'Skor Akhir',
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

		$criteria->compare('kolomrating_id',$this->kolomrating_id);
		$criteria->compare('indikatorperilaku_id',$this->indikatorperilaku_id);
		$criteria->compare('LOWER(kolomrating_namalevel)',  strtolower($this->kolomrating_namalevel),true);
		$criteria->compare('kolomrating_point',$this->kolomrating_point);
		$criteria->compare('LOWER(kolomrating_uraian)',strtolower($this->kolomrating_uraian),true);
		$criteria->compare('LOWER(kolomrating_deskripsi)',strtolower($this->kolomrating_deskripsi),true);
		$criteria->compare('kolomrating_aktif',$this->kolomrating_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kolomrating_id',$this->kolomrating_id);
		$criteria->compare('indikatorperilaku_id',$this->indikatorperilaku_id);
		$criteria->compare('LOWER(kolomrating_namalevel)',  strtolower($this->kolomrating_namalevel),true);
		$criteria->compare('kolomrating_point',$this->kolomrating_point);
		$criteria->compare('LOWER(kolomrating_uraian)',strtolower($this->kolomrating_uraian),true);
		$criteria->compare('LOWER(kolomrating_deskripsi)',strtolower($this->kolomrating_deskripsi),true);
		$criteria->compare('kolomrating_aktif',$this->kolomrating_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
		));
	}
}