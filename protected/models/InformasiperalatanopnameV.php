<?php

/**
 * This is the model class for table "informasiperalatanopname_v".
 *
 * The followings are the available columns in table 'informasiperalatanopname_v':
 * @property integer $asetopname_id
 * @property integer $periodeasetopname_id
 * @property string $periodeasetopname_nama
 * @property string $asetopname_tanggal
 * @property integer $invperalatan_id
 * @property string $invperalatan_kode
 * @property integer $barang_id
 * @property string $invperalatan_namabrg
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property string $invperalatan_keadaan
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 */
class InformasiperalatanopnameV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiperalatanopnameV the static model class
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
		return 'informasiperalatanopname_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asetopname_id, periodeasetopname_id, invperalatan_id, barang_id, ruangan_id, lokasi_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('periodeasetopname_nama, invperalatan_namabrg, lokasiaset_namalokasi', 'length', 'max'=>100),
			array('invperalatan_kode, ruangan_nama, invperalatan_keadaan, nama_pegawai', 'length', 'max'=>50),
			array('asetopname_tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asetopname_id, periodeasetopname_id, periodeasetopname_nama, asetopname_tanggal, invperalatan_id, invperalatan_kode, barang_id, invperalatan_namabrg, ruangan_id, ruangan_nama, lokasi_id, lokasiaset_namalokasi, invperalatan_keadaan, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'asetopname_id' => 'Asetopname',
			'periodeasetopname_id' => 'Periodeasetopname',
			'periodeasetopname_nama' => 'Periodeasetopname Nama',
			'asetopname_tanggal' => 'Asetopname Tanggal',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_kode' => 'Invperalatan Kode',
			'barang_id' => 'Barang',
			'invperalatan_namabrg' => 'Invperalatan Namabrg',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'invperalatan_keadaan' => 'Invperalatan Keadaan',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('asetopname_id',$this->asetopname_id);
		$criteria->compare('periodeasetopname_id',$this->periodeasetopname_id);
		$criteria->compare('periodeasetopname_nama',$this->periodeasetopname_nama,true);
		$criteria->compare('asetopname_tanggal',$this->asetopname_tanggal,true);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('invperalatan_kode',$this->invperalatan_kode,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('invperalatan_namabrg',$this->invperalatan_namabrg,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasiaset_namalokasi',$this->lokasiaset_namalokasi,true);
		$criteria->compare('invperalatan_keadaan',$this->invperalatan_keadaan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}