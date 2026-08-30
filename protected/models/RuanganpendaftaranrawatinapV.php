<?php

/**
 * This is the model class for table "ruanganpendaftaranrawatinap_v".
 *
 * The followings are the available columns in table 'ruanganpendaftaranrawatinap_v':
 * @property string $action
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property integer $riwayatruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_singkatan
 * @property string $ruangan_fasilitas
 * @property string $ruangan_lokasi
 * @property string $ruangan_image
 * @property boolean $ruangan_aktif
 * @property integer $ruangan_nourut
 * @property string $ruangan_filesuara
 * @property integer $estimasipelayanan
 * @property string $image_mobile
 * @property integer $warnadokrm_id
 * @property integer $modul_id
 * @property string $kode_bpjs
 */
class RuanganpendaftaranrawatinapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganpendaftaranrawatinapV the static model class
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
		return 'ruanganpendaftaranrawatinap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id, riwayatruangan_id, ruangan_nourut, estimasipelayanan, warnadokrm_id, modul_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image', 'length', 'max'=>100),
			array('ruangan_filesuara, image_mobile', 'length', 'max'=>500),
			array('kode_bpjs', 'length', 'max'=>10),
			array('action, ruangan_fasilitas, ruangan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('action, ruangan_id, instalasi_id, riwayatruangan_id, ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_singkatan, ruangan_fasilitas, ruangan_lokasi, ruangan_image, ruangan_aktif, ruangan_nourut, ruangan_filesuara, estimasipelayanan, image_mobile, warnadokrm_id, modul_id, kode_bpjs', 'safe', 'on'=>'search'),
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
			'action' => 'Action',
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'riwayatruangan_id' => 'Riwayatruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_image' => 'Ruangan Image',
			'ruangan_aktif' => 'Ruangan Aktif',
			'ruangan_nourut' => 'Ruangan Nourut',
			'ruangan_filesuara' => 'Ruangan Filesuara',
			'estimasipelayanan' => 'Estimasipelayanan',
			'image_mobile' => 'Image Mobile',
			'warnadokrm_id' => 'Warnadokrm',
			'modul_id' => 'Modul',
			'kode_bpjs' => 'Kode Bpjs',
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

		$criteria->compare('action',$this->action,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_namalainnya',$this->ruangan_namalainnya,true);
		$criteria->compare('ruangan_jenispelayanan',$this->ruangan_jenispelayanan,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('ruangan_fasilitas',$this->ruangan_fasilitas,true);
		$criteria->compare('ruangan_lokasi',$this->ruangan_lokasi,true);
		$criteria->compare('ruangan_image',$this->ruangan_image,true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('ruangan_nourut',$this->ruangan_nourut);
		$criteria->compare('ruangan_filesuara',$this->ruangan_filesuara,true);
		$criteria->compare('estimasipelayanan',$this->estimasipelayanan);
		$criteria->compare('image_mobile',$this->image_mobile,true);
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('kode_bpjs',$this->kode_bpjs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}