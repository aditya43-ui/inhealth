<?php

/**
 * This is the model class for table "hapuspresensi_r".
 *
 * The followings are the available columns in table 'hapuspresensi_r':
 * @property integer $hapuspresensi_id
 * @property integer $pegawai_id
 * @property integer $shift_id
 * @property string $tgl_presensi
 * @property string $status_kehadiran
 * @property string $keterangan
 * @property string $alasan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemaikai_id
 * @property integer $create_ruangan
 */
class HapuspresensiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HapuspresensiR the static model class
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
		return 'hapuspresensi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time', 'required'),
			array('pegawai_id, shift_id, create_loginpemakai_id, update_loginpemaikai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('status_kehadiran', 'length', 'max'=>100),
			array('tgl_presensi, keterangan, alasan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hapuspresensi_id, pegawai_id, shift_id, tgl_presensi, status_kehadiran, keterangan, alasan, create_time, update_time, create_loginpemakai_id, update_loginpemaikai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'hapuspresensi_id' => 'Hapuspresensi',
			'pegawai_id' => 'Pegawai',
			'shift_id' => 'Shift',
			'tgl_presensi' => 'Tgl. Presensi',
			'status_kehadiran' => 'Status Kehadiran',
			'keterangan' => 'Keterangan',
			'alasan' => 'Alasan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemaikai_id' => 'Update Loginpemaikai',
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

		$criteria->compare('hapuspresensi_id',$this->hapuspresensi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('tgl_presensi',$this->tgl_presensi,true);
		$criteria->compare('status_kehadiran',$this->status_kehadiran,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('alasan',$this->alasan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemaikai_id',$this->update_loginpemaikai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}