<?php

/**
 * This is the model class for table "tindakankeperawatan_m".
 *
 * The followings are the available columns in table 'tindakankeperawatan_m':
 * @property integer $tindakankeperawatan_id
 * @property string $tindakankeperawatan_nama
 * @property string $tindakankeperawatan_namalain
 * @property boolean $tindakankeperawatan_aktif
 * @property integer $tindakankeperawatan_grup_order
 * @property integer $tindakankeperawatan_order
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $has_input
 */
class TindakankeperawatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankeperawatanM the static model class
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
		return 'tindakankeperawatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakankeperawatan_nama, tindakankeperawatan_grup_order, tindakankeperawatan_order, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tindakankeperawatan_grup_order, tindakankeperawatan_order', 'numerical', 'integerOnly'=>true),
			array('tindakankeperawatan_nama, tindakankeperawatan_namalain', 'length', 'max'=>200),
			array('tindakankeperawatan_aktif, update_time, update_loginpemakai_id, has_input', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakankeperawatan_id, tindakankeperawatan_nama, tindakankeperawatan_namalain, tindakankeperawatan_aktif, tindakankeperawatan_grup_order, tindakankeperawatan_order, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, has_input', 'safe', 'on'=>'search'),
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
			'tindakankeperawatan_id' => 'Tindakankeperawatan',
			'tindakankeperawatan_nama' => 'Tindakankeperawatan Nama',
			'tindakankeperawatan_namalain' => 'Tindakankeperawatan Namalain',
			'tindakankeperawatan_aktif' => 'Tindakankeperawatan Aktif',
			'tindakankeperawatan_grup_order' => 'Tindakankeperawatan Grup Order',
			'tindakankeperawatan_order' => 'Tindakankeperawatan Order',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'has_input' => 'Has Input',
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

		$criteria->compare('tindakankeperawatan_id',$this->tindakankeperawatan_id);
		$criteria->compare('tindakankeperawatan_nama',$this->tindakankeperawatan_nama,true);
		$criteria->compare('tindakankeperawatan_namalain',$this->tindakankeperawatan_namalain,true);
		$criteria->compare('tindakankeperawatan_aktif',$this->tindakankeperawatan_aktif);
		$criteria->compare('tindakankeperawatan_grup_order',$this->tindakankeperawatan_grup_order);
		$criteria->compare('tindakankeperawatan_order',$this->tindakankeperawatan_order);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('has_input',$this->has_input);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}