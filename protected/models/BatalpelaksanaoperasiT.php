<?php

/**
 * This is the model class for table "batalpelaksanaoperasi_t".
 *
 * The followings are the available columns in table 'batalpelaksanaoperasi_t':
 * @property integer $batalpelaksanaoperasi_id
 * @property integer $pelaksanaoperasi_id
 * @property integer $rencanaoperasi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pegpembatal_id
 *
 * The followings are the available model relations:
 * @property PelaksanaoperasiT[] $pelaksanaoperasiTs
 * @property RencanaoperasiT $rencanaoperasi
 * @property PelaksanaoperasiT $pelaksanaoperasi
 * @property PegawaiM $pegpembatal
 */
class BatalpelaksanaoperasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatalpelaksanaoperasiT the static model class
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
		return 'batalpelaksanaoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pelaksanaoperasi_id, rencanaoperasi_id, create_time, create_loginpemakai_id, create_ruangan, pegpembatal_id', 'required'),
			array('pelaksanaoperasi_id, rencanaoperasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegpembatal_id', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('batalpelaksanaoperasi_id, pelaksanaoperasi_id, rencanaoperasi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegpembatal_id', 'safe', 'on'=>'search'),
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
			'pelaksanaoperasiTs' => array(self::HAS_MANY, 'PelaksanaoperasiT', 'batalpelaksanaoperasi_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
			'pelaksanaoperasi' => array(self::BELONGS_TO, 'PelaksanaoperasiT', 'pelaksanaoperasi_id'),
			'pegpembatal' => array(self::BELONGS_TO, 'PegawaiM', 'pegpembatal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'batalpelaksanaoperasi_id' => 'Batalpelaksanaoperasi',
			'pelaksanaoperasi_id' => 'Pelaksanaoperasi',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegpembatal_id' => 'Pegpembatal',
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

		$criteria->compare('batalpelaksanaoperasi_id',$this->batalpelaksanaoperasi_id);
		$criteria->compare('pelaksanaoperasi_id',$this->pelaksanaoperasi_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pegpembatal_id',$this->pegpembatal_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}