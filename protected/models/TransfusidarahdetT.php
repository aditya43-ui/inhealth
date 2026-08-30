<?php

/**
 * This is the model class for table "transfusidarahdet_t".
 *
 * The followings are the available columns in table 'transfusidarahdet_t':
 * @property integer $transfusidarahdet_id
 * @property integer $transfusidarah_id
 * @property integer $monitoringtranfusidarah_id
 * @property string $nama_tandareaksi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TransfusidarahT $transfusidarah
 * @property MonitoringtranfusidarahT $monitoringtranfusidarah
 */
class TransfusidarahdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransfusidarahdetT the static model class
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
		return 'transfusidarahdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transfusidarah_id, monitoringtranfusidarah_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('transfusidarah_id, monitoringtranfusidarah_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_tandareaksi', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transfusidarahdet_id, transfusidarah_id, monitoringtranfusidarah_id, nama_tandareaksi, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'transfusidarah' => array(self::BELONGS_TO, 'TransfusidarahT', 'transfusidarah_id'),
			'monitoringtranfusidarah' => array(self::BELONGS_TO, 'MonitoringtranfusidarahT', 'monitoringtranfusidarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transfusidarahdet_id' => 'Transfusidarahdet',
			'transfusidarah_id' => 'Transfusidarah',
			'monitoringtranfusidarah_id' => 'Monitoringtranfusidarah',
			'nama_tandareaksi' => 'Nama Tandareaksi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('transfusidarahdet_id',$this->transfusidarahdet_id);
		$criteria->compare('transfusidarah_id',$this->transfusidarah_id);
		$criteria->compare('monitoringtranfusidarah_id',$this->monitoringtranfusidarah_id);
		$criteria->compare('nama_tandareaksi',$this->nama_tandareaksi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}