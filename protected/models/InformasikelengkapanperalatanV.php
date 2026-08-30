<?php

/**
 * This is the model class for table "informasikelengkapanperalatan_v".
 *
 * The followings are the available columns in table 'informasikelengkapanperalatan_v':
 * @property integer $id
 * @property integer $invperalatan_id
 * @property string $invperalatan_namabrg
 * @property string $invperalatan_kode
 * @property string $nomor_transaksi
 * @property string $tanggal_transaksi
 * @property string $jatuh_tempo
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property string $jenis_kelengkapan
 * @property string $status
 */
class InformasikelengkapanperalatanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikelengkapanperalatanV the static model class
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
		return 'informasikelengkapanperalatan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, invperalatan_id, lokasi_id, ruangan_id, gedung_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_namabrg, lokasiaset_namalokasi, gedung_nama', 'length', 'max'=>100),
			array('invperalatan_kode, ruangan_nama', 'length', 'max'=>50),
			array('barang_id, nomor_transaksi, tanggal_transaksi, jatuh_tempo, jenis_kelengkapan, status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invperalatan_id, invperalatan_namabrg, invperalatan_kode, nomor_transaksi, tanggal_transaksi, jatuh_tempo, lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, jenis_kelengkapan, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'invperalatan_id' => 'Invperalatan',
			'invperalatan_namabrg' => 'Invperalatan Namabrg',
			'invperalatan_kode' => 'Invperalatan Kode',
			'nomor_transaksi' => 'Nomor Transaksi',
			'tanggal_transaksi' => 'Tanggal Transaksi',
			'jatuh_tempo' => 'Jatuh Tempo',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'jenis_kelengkapan' => 'Jenis Kelengkapan',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('invperalatan_namabrg',$this->invperalatan_namabrg,true);
		$criteria->compare('invperalatan_kode',$this->invperalatan_kode,true);
		$criteria->compare('nomor_transaksi',$this->nomor_transaksi,true);
		$criteria->compare('tanggal_transaksi',$this->tanggal_transaksi,true);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasiaset_namalokasi',$this->lokasiaset_namalokasi,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('gedung_id',$this->gedung_id);
		$criteria->compare('gedung_nama',$this->gedung_nama,true);
		$criteria->compare('jenis_kelengkapan',$this->jenis_kelengkapan,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}