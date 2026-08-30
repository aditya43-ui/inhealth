<?php

/**
 * This is the model class for table "pemanggilanantrianlantai2_v".
 *
 * The followings are the available columns in table 'pemanggilanantrianlantai2_v':
 * @property integer $antrian_id
 * @property string $noantrian
 * @property string $tglantrian
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $loket_nama
 */
class Pemanggilanantrianlantai2V extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pemanggilanantrianlantai2_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antrian_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('ruangan_nama, loket_nama', 'length', 'max'=>50),
			array('tglantrian', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('antrian_id, noantrian, tglantrian, ruangan_id, instalasi_id, ruangan_nama, loket_nama', 'safe', 'on'=>'search'),
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
			'antrian_id' => 'Antrian',
			'noantrian' => 'Noantrian',
			'tglantrian' => 'Tglantrian',
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'loket_nama' => 'Loket Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('loket_nama',$this->loket_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pemanggilanantrianlantai2V the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
