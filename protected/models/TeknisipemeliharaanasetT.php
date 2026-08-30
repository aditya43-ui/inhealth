<?php

/**
 * This is the model class for table "teknisipemeliharaanaset_t".
 *
 * The followings are the available columns in table 'teknisipemeliharaanaset_t':
 * @property integer $teknisipemeliharaanaset_id
 * @property string $jenis_teknisi
 * @property integer $pegawai_id
 * @property integer $teknisiperalatan_id
 * @property string $nama_teknisi
 * @property integer $korektifmainten_id
 * @property integer $workorder_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property TeknisiperalatanM $teknisiperalatan
 * @property KorektifmaintenT $korektifmainten
 * @property WorkorderT $workorder
 */
class TeknisipemeliharaanasetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TeknisipemeliharaanasetT the static model class
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
		return 'teknisipemeliharaanaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenis_teknisi, nama_teknisi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, teknisiperalatan_id, korektifmainten_id, workorder_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jenis_teknisi', 'length', 'max'=>10),
			array('nama_teknisi', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('teknisipemeliharaanaset_id, jenis_teknisi, pegawai_id, teknisiperalatan_id, nama_teknisi, korektifmainten_id, workorder_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'teknisiperalatan' => array(self::BELONGS_TO, 'TeknisiperalatanM', 'teknisiperalatan_id'),
			'korektifmainten' => array(self::BELONGS_TO, 'KorektifmaintenT', 'korektifmainten_id'),
			'workorder' => array(self::BELONGS_TO, 'WorkorderT', 'workorder_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'teknisipemeliharaanaset_id' => 'Teknisipemeliharaanaset',
			'jenis_teknisi' => 'Jenis Teknisi',
			'pegawai_id' => 'Pegawai',
			'teknisiperalatan_id' => 'Teknisiperalatan',
			'nama_teknisi' => 'Nama Teknisi',
			'korektifmainten_id' => 'Korektifmainten',
			'workorder_id' => 'Workorder',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('teknisipemeliharaanaset_id',$this->teknisipemeliharaanaset_id);
		$criteria->compare('jenis_teknisi',$this->jenis_teknisi,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('teknisiperalatan_id',$this->teknisiperalatan_id);
		$criteria->compare('nama_teknisi',$this->nama_teknisi,true);
		$criteria->compare('korektifmainten_id',$this->korektifmainten_id);
		$criteria->compare('workorder_id',$this->workorder_id);
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