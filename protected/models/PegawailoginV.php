<?php

/**
 * This is the model class for table "pegawailogin_v".
 *
 * The followings are the available columns in table 'pegawailogin_v':
 * @property string $instalasi_nama
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $jeniskelamin
 * @property string $nama_pemakai
 * @property string $katakunci_pemakai
 * @property string $lastlogin
 * @property string $tglpembuatanlogin
 * @property string $tglupdatelogin
 * @property boolean $statuslogin
 * @property string $modul_nama
 */
class PegawailoginV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawailoginV the static model class
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
		return 'pegawailogin_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, nama_pegawai, modul_nama', 'length', 'max'=>50),
			array('kelompokpegawai_nama, nomorindukpegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin, nama_pemakai', 'length', 'max'=>20),
			array('katakunci_pemakai', 'length', 'max'=>200),
			array('lastlogin, tglpembuatanlogin, tglupdatelogin, statuslogin, jmlaktifitas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_nama, ruangan_nama, pegawai_id, kelompokpegawai_nama, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_nama, jeniskelamin, nama_pemakai, katakunci_pemakai, lastlogin, tglpembuatanlogin, tglupdatelogin, statuslogin, modul_nama, jmlaktifitas', 'safe', 'on'=>'search'),
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
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'jeniskelamin' => 'Jenis Kelamin',
			'nama_pemakai' => 'Nama Pemakai',
			'katakunci_pemakai' => 'Katakunci Pemakai',
			'lastlogin' => 'Lastlogin',
			'tglpembuatanlogin' => 'Tglpembuatanlogin',
			'tglupdatelogin' => 'Tglupdatelogin',
			'statuslogin' => 'Statuslogin',
			'modul_nama' => 'Modul Nama',
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

		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelompokpegawai_nama',$this->kelompokpegawai_nama,true);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('katakunci_pemakai',$this->katakunci_pemakai,true);
		$criteria->compare('lastlogin',$this->lastlogin,true);
		$criteria->compare('tglpembuatanlogin',$this->tglpembuatanlogin,true);
		$criteria->compare('tglupdatelogin',$this->tglupdatelogin,true);
		$criteria->compare('statuslogin',$this->statuslogin);
		$criteria->compare('modul_nama',$this->modul_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}