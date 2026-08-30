<?php

/**
 * This is the model class for table "biayalembur_m".
 *
 * The followings are the available columns in table 'biayalembur_m':
 * @property integer $biayalembur_id
 * @property double $biayalembur_nilai
 * @property double $biayalembur_nilailibur
 * @property boolean $biayalembur_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class BiayalemburM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BiayalemburM the static model class
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
		return 'biayalembur_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan, biayalembur_nama', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('biayalembur_nilai, biayalembur_nilailibur', 'numerical'),
			array('biayalembur_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
            array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
            array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
            array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
            array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
            
			array('biayalembur_id, biayalembur_nilai, biayalembur_nilailibur, biayalembur_nama, biayalembur_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'biayalembur_id' => 'Biayalembur',
			'biayalembur_nama' => 'Nama',
			'biayalembur_nilai' => 'Biaya Normal (per Jam)',
			'biayalembur_nilailibur' => 'Biaya Libur (per Jam)',
			'biayalembur_aktif' => 'Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('biayalembur_id',$this->biayalembur_id);
		$criteria->compare('lower(biayalembur_nama)',strtolower($this->biayalembur_nama), true);
		$criteria->compare('biayalembur_nilai',$this->biayalembur_nilai);
		$criteria->compare('biayalembur_nilailibur',$this->biayalembur_nilailibur);
		$criteria->compare('biayalembur_aktif',$this->biayalembur_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}