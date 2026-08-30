<?php

/**
 * This is the model class for table "sop_m".
 *
 * The followings are the available columns in table 'sop_m':
 * @property integer $sop_id
 * @property integer $instalasi_id
 * @property string $sop_nodokumen
 * @property string $sop_norevisi
 * @property string $sop_tglterbit
 * @property string $sop_tglrevisi
 * @property integer $pegawai_id
 * @property integer $sop_jmlhalaman
 * @property string $sop_nama
 * @property string $sop_pengertian
 * @property string $sop_tujuan
 * @property string $sop_kebijakan
 * @property string $sop_image
 * @property boolean $sop_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SopdetailM[] $sopdetailMs
 */
class SopM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sop_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, sop_nodokumen, sop_tglterbit, sop_nama, create_loginpemakai_id, create_ruangan', 'required'),
			array('instalasi_id, pegawai_id, sop_jmlhalaman, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('sop_nodokumen, sop_norevisi', 'length', 'max'=>100),
			array('sop_nama', 'length', 'max'=>150),
			array('sop_tujuan, sop_kebijakan', 'length', 'max'=>250),
			array('sop_image', 'length', 'max'=>500),
			array('sop_tglrevisi, sop_pengertian, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sop_id, instalasi_id, sop_nodokumen, sop_norevisi, sop_tglterbit, sop_tglrevisi, pegawai_id, sop_jmlhalaman, sop_nama, sop_pengertian, sop_tujuan, sop_kebijakan, sop_image, sop_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sopdetailMs' => array(self::HAS_MANY, 'SopdetailM', 'sop_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sop_id' => 'Sop',
			'instalasi_id' => 'Instalasi',
			'sop_nodokumen' => 'Nomor Dokumen',
			'sop_norevisi' => 'Sop Norevisi',
			'sop_tglterbit' => 'Tanggal Terbit',
			'sop_tglrevisi' => 'Sop Tglrevisi',
			'pegawai_id' => 'Penandatangan',
			'sop_jmlhalaman' => 'Jumlah Halaman',
			'sop_nama' => 'Nama SOP',
			'sop_pengertian' => 'Pengertian',
			'sop_tujuan' => 'Tujuan',
			'sop_kebijakan' => 'Kebijakan',
			'sop_image' => 'Gambar',
			'sop_aktif' => 'Sop Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sop_id',$this->sop_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('sop_nodokumen',$this->sop_nodokumen,true);
		$criteria->compare('sop_norevisi',$this->sop_norevisi,true);
		$criteria->compare('sop_tglterbit',$this->sop_tglterbit,true);
		$criteria->compare('sop_tglrevisi',$this->sop_tglrevisi,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('sop_jmlhalaman',$this->sop_jmlhalaman);
		$criteria->compare('sop_nama',$this->sop_nama,true);
		$criteria->compare('sop_pengertian',$this->sop_pengertian,true);
		$criteria->compare('sop_tujuan',$this->sop_tujuan,true);
		$criteria->compare('sop_kebijakan',$this->sop_kebijakan,true);
		$criteria->compare('sop_image',$this->sop_image,true);
		$criteria->compare('sop_aktif',$this->sop_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SopM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
