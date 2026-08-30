<?php

/**
 * This is the model class for table "evaluasiaskep_t".
 *
 * The followings are the available columns in table 'evaluasiaskep_t':
 * @property integer $evaluasiaskep_id
 * @property integer $pegawai_id
 * @property integer $implementasiaskep_id
 * @property integer $ruangan_id
 * @property string $no_evaluasi
 * @property string $evaluasiaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property EvaluasiaskepdetT[] $evaluasiaskepdetTs
 * @property ImplementasiaskepT $implementasiaskep
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 */
class EvaluasiaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasiaskepT the static model class
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
		return 'evaluasiaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, implementasiaskep_id, ruangan_id, no_evaluasi, evaluasiaskep_tgl, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, implementasiaskep_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('no_evaluasi', 'length', 'max'=>20),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evaluasiaskep_id, pegawai_id, implementasiaskep_id, ruangan_id, no_evaluasi, evaluasiaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'evaluasiaskepdetTs' => array(self::HAS_MANY, 'EvaluasiaskepdetT', 'evaluasiaskep_id'),
			'implementasiaskep' => array(self::BELONGS_TO, 'ImplementasiaskepT', 'implementasiaskep_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiaskep_id' => 'Evaluasiaskep',
			'pegawai_id' => 'Pegawai',
			'implementasiaskep_id' => 'Implementasiaskep',
			'ruangan_id' => 'Ruangan',
			'no_evaluasi' => 'No. Evaluasi',
			'evaluasiaskep_tgl' => 'Evaluasiaskep Tgl',
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

		$criteria->compare('evaluasiaskep_id',$this->evaluasiaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_evaluasi',$this->no_evaluasi,true);
		$criteria->compare('evaluasiaskep_tgl',$this->evaluasiaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}