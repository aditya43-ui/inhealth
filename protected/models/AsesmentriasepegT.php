<?php

/**
 * This is the model class for table "asesmentriasepeg_t".
 *
 * The followings are the available columns in table 'asesmentriasepeg_t':
 * @property integer $asesmentriase_id
 * @property integer $pegawai_id
 *
 * The followings are the available model relations:
 * @property AsesmentriaseT $asesmentriase
 * @property PegawaiM $pegawai
 */
class AsesmentriasepegT extends CActiveRecord
{
	public $getpegawaitriase;
	public $nama_pegawai;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentriasepegT the static model class
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
		return 'asesmentriasepeg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmentriase_id, pegawai_id', 'required'),
			array('asesmentriase_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentriase_id, pegawai_id', 'safe', 'on'=>'search'),
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
			'asesmentriase' => array(self::BELONGS_TO, 'AsesmentriaseT', 'asesmentriase_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentriase_id' => 'Asesmentriase',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('asesmentriase_id',$this->asesmentriase_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}