<?php

/**
 * This is the model class for table "mcatatandokter_t".
 *
 * The followings are the available columns in table 'mcatatandokter_t':
 * @property integer $mcatatandokter_id
 * @property integer $pegawai_id
 * @property integer $mkategoricatatan_id
 * @property string $judulcatatan
 * @property string $isicatatan
 * @property string $status_catatan
 * @property string $tglrencana
 * @property string $tempat_kegiatan
 * @property string $alamat_kegiatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class McatatandokterT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return McatatandokterT the static model class
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
		return 'mcatatandokter_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, mkategoricatatan_id, judulcatatan, isicatatan, status_catatan, create_time, create_loginpemakai_id', 'required'),
			array('pegawai_id, mkategoricatatan_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('judulcatatan', 'length', 'max'=>200),
			array('status_catatan', 'length', 'max'=>50),
			array('tempat_kegiatan', 'length', 'max'=>100),
			array('alamat_kegiatan', 'length', 'max'=>400),
			array('tglrencana, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mcatatandokter_id, pegawai_id, mkategoricatatan_id, judulcatatan, isicatatan, status_catatan, tglrencana, tempat_kegiatan, alamat_kegiatan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'mcatatandokter_id' => 'Mcatatandokter',
			'pegawai_id' => 'Pegawai',
			'mkategoricatatan_id' => 'Mkategoricatatan',
			'judulcatatan' => 'Judulcatatan',
			'isicatatan' => 'Isicatatan',
			'status_catatan' => 'Status Catatan',
			'tglrencana' => 'Tglrencana',
			'tempat_kegiatan' => 'Tempat Kegiatan',
			'alamat_kegiatan' => 'Alamat Kegiatan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('mcatatandokter_id',$this->mcatatandokter_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('mkategoricatatan_id',$this->mkategoricatatan_id);
		$criteria->compare('judulcatatan',$this->judulcatatan,true);
		$criteria->compare('isicatatan',$this->isicatatan,true);
		$criteria->compare('status_catatan',$this->status_catatan,true);
		$criteria->compare('tglrencana',$this->tglrencana,true);
		$criteria->compare('tempat_kegiatan',$this->tempat_kegiatan,true);
		$criteria->compare('alamat_kegiatan',$this->alamat_kegiatan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}