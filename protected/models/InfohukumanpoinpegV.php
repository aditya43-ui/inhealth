<?php

/**
 * This is the model class for table "infohukumanpoinpeg_v".
 *
 * The followings are the available columns in table 'infohukumanpoinpeg_v':
 * @property integer $poinpegawai_id
 * @property string $poinpegawai_alasan
 * @property string $poinpegawai_tgl
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jabatan_nama
 * @property integer $pegpembuat_id
 * @property string $gelardpn_pembuat
 * @property string $nama_pembuat
 * @property string $gelarblkg_pembuat
 * @property string $jab_pembuat
 */
class InfohukumanpoinpegV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfohukumanpoinpegV the static model class
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
		return 'infohukumanpoinpeg_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poinpegawai_id, pegawai_id, pegpembuat_id', 'numerical', 'integerOnly'=>true),
			array('gelardepan, gelardpn_pembuat', 'length', 'max'=>10),
			array('nama_pegawai, nama_pembuat', 'length', 'max'=>50),
			array('gelarbelakang_nama, gelarblkg_pembuat', 'length', 'max'=>15),
			array('jabatan_nama, jab_pembuat', 'length', 'max'=>100),
			array('poinpegawai_alasan, poinpegawai_tgl', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('poinpegawai_id, poinpegawai_alasan, poinpegawai_tgl, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, jabatan_nama, pegpembuat_id, gelardpn_pembuat, nama_pembuat, gelarblkg_pembuat, jab_pembuat', 'safe', 'on'=>'search'),
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
			'poinpegawai_id' => 'ID',
			'poinpegawai_alasan' => 'Alasan',
			'poinpegawai_tgl' => 'Tanggal',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'jabatan_nama' => 'Jabatan',
			'pegpembuat_id' => 'ID Pencatat',
			'gelardpn_pembuat' => 'Gelar Depan Pencatat',
			'nama_pembuat' => 'Pencatat',
			'gelarblkg_pembuat' => 'Gelar Belakang Pencatat',
			'jab_pembuat' => 'Jabatan Pencatat',
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

		$criteria->compare('poinpegawai_id',$this->poinpegawai_id);
		$criteria->compare('poinpegawai_alasan',$this->poinpegawai_alasan,true);
		$criteria->compare('poinpegawai_tgl',$this->poinpegawai_tgl,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('pegpembuat_id',$this->pegpembuat_id);
		$criteria->compare('gelardpn_pembuat',$this->gelardpn_pembuat,true);
		$criteria->compare('nama_pembuat',$this->nama_pembuat,true);
		$criteria->compare('gelarblkg_pembuat',$this->gelarblkg_pembuat,true);
		$criteria->compare('jab_pembuat',$this->jab_pembuat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}