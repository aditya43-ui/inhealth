<?php

/**
 * This is the model class for table "kelompoktindakanbpjs_m".
 *
 * The followings are the available columns in table 'kelompoktindakanbpjs_m':
 * @property integer $kelompoktindakanbpjs_id
 * @property string $kelompoktindakanbpjs_nama
 * @property string $kelompoktindakanbpjs_namalain
 * @property boolean $kelompoktindakakanbpjs_aktif
 */
class KelompoktindakanbpjsM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kelompoktindakanbpjs_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompoktindakanbpjs_nama', 'required'),
			array('kelompoktindakanbpjs_nama, kelompoktindakanbpjs_namalain', 'length', 'max'=>100),
			array('kelompoktindakakanbpjs_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kelompoktindakanbpjs_id, kelompoktindakanbpjs_nama, kelompoktindakanbpjs_namalain, kelompoktindakakanbpjs_aktif', 'safe', 'on'=>'search'),
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
			'kelompoktindakanbpjs_id' => 'Kelompoktindakanbpjs',
			'kelompoktindakanbpjs_nama' => 'Kelompoktindakanbpjs Nama',
			'kelompoktindakanbpjs_namalain' => 'Kelompoktindakanbpjs Namalain',
			'kelompoktindakakanbpjs_aktif' => 'Kelompoktindakakanbpjs Aktif',
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

		$criteria->compare('kelompoktindakanbpjs_id',$this->kelompoktindakanbpjs_id);
		$criteria->compare('kelompoktindakanbpjs_nama',$this->kelompoktindakanbpjs_nama,true);
		$criteria->compare('kelompoktindakanbpjs_namalain',$this->kelompoktindakanbpjs_namalain,true);
		$criteria->compare('kelompoktindakakanbpjs_aktif',$this->kelompoktindakakanbpjs_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KelompoktindakanbpjsM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
