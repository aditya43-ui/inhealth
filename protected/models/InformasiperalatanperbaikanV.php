<?php

/**
 * This is the model class for table "informasiperalatanperbaikan_v".
 *
 * The followings are the available columns in table 'informasiperalatanperbaikan_v':
 * @property integer $id
 * @property integer $invperalatan_id
 * @property integer $barang_id
 * @property string $invperalatan_namabrg
 * @property string $invperalatan_kode
 * @property string $nomor_transaksi
 * @property string $tanggal_transaksi
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property string $jenis_perbaikan
 * @property string $status
 */
class InformasiperalatanperbaikanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiperalatanperbaikanV the static model class
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
		return 'informasiperalatanperbaikan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, invperalatan_id, barang_id, lokasi_id, ruangan_id, gedung_id', 'numerical', 'integerOnly'=>true),
			array('invperalatan_namabrg, lokasiaset_namalokasi, gedung_nama', 'length', 'max'=>100),
			array('invperalatan_kode, ruangan_nama', 'length', 'max'=>50),
			array('nomor_transaksi, tanggal_transaksi, jenis_perbaikan, status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invperalatan_id, barang_id, invperalatan_namabrg, invperalatan_kode, nomor_transaksi, tanggal_transaksi, lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, jenis_perbaikan, status', 'safe', 'on'=>'search'),
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
			'barang_id' => 'Barang',
			'invperalatan_namabrg' => 'Jenis Peralatan',
			'invperalatan_kode' => 'Kode Aset',
			'nomor_transaksi' => 'Nomor Transaksi',
			'tanggal_transaksi' => 'Tanggal Transaksi',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'jenis_perbaikan' => 'Jenis Perbaikan',
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
                $criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('LOWER(invperalatan_namabrg)', strtolower($this->invperalatan_namabrg),true);
		$criteria->compare('LOWER(invperalatan_kode)',  strtolower($this->invperalatan_kode),true);
		$criteria->compare('LOWER(nomor_transaksi)', strtolower($this->nomor_transaksi),true);
		$criteria->compare('tanggal_transaksi',$this->tanggal_transaksi,true);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('LOWER(lokasiaset_namalokasi)', strtolower($this->lokasiaset_namalokasi),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama),true);
		$criteria->compare('gedung_id',$this->gedung_id);
		$criteria->compare('LOWER(gedung_nama)', strtolower($this->gedung_nama),true);
		$criteria->compare('jenis_perbaikan',$this->jenis_perbaikan);
		$criteria->compare('status',$this->status);
                
                
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}