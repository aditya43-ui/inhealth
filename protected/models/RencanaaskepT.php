<?php

/**
 * This is the model class for table "rencanaaskep_t".
 *
 * The followings are the available columns in table 'rencanaaskep_t':
 * @property integer $rencanaaskep_id
 * @property integer $pengkajianaskep_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $no_rencana
 * @property string $rencanaaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property ImplementasiaskepT[] $implementasiaskepTs
 * @property RencanaaskepdetT[] $rencanaaskepdetTs
 * @property PegawaiM $pegawai
 * @property PengkajianaskepT $pengkajianaskep
 * @property RuanganM $ruangan
 */
class RencanaaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaaskepT the static model class
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
		return 'rencanaaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengkajianaskep_id, pegawai_id, ruangan_id, no_rencana, rencanaaskep_tgl, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pengkajianaskep_id, pegawai_id, ruangan_id, diagnosisaskep_id', 'numerical', 'integerOnly'=>true),
			array('no_rencana', 'length', 'max'=>20),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanaaskep_id, pengkajianaskep_id, pegawai_id, ruangan_id, no_rencana, rencanaaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'implementasiaskepTs' => array(self::HAS_MANY, 'ImplementasiaskepT', 'rencanaaskep_id'),
			'rencanaaskepdetTs' => array(self::HAS_MANY, 'RencanaaskepdetT', 'rencanaaskep_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pengkajianaskep' => array(self::BELONGS_TO, 'PengkajianaskepT', 'pengkajianaskep_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'diagnosisaskep' => array(self::BELONGS_TO, 'DiagnosisaskepT', 'diagnosisaskep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanaaskep_id' => 'Rencanaaskep',
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'no_rencana' => 'No Rencana',
			'rencanaaskep_tgl' => 'Rencanaaskep Tgl',
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

		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_rencana',$this->no_rencana,true);
		$criteria->compare('rencanaaskep_tgl',$this->rencanaaskep_tgl,true);
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