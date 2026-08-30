<?php

/**
 * This is the model class for table "laporanpengajuanlogistik_v".
 *
 * The followings are the available columns in table 'laporanpengajuanlogistik_v':
 * @property string $tgltransaksi
 * @property string $create_time
 * @property integer $barang_id
 * @property string $barang_nama
 * @property string $barang_type
 * @property double $barang_harganetto
 * @property string $barang_satuan
 * @property double $qtystok
 * @property integer $jenisbarang_id
 * @property string $jenisbarang_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property double $terimabarang
 * @property string $pemakaianbarang
 * @property string $rencanapemesanan
 * @property double $hargabeli
 */
class LaporanpengajuanlogistikV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengajuanlogistikV the static model class
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
		return 'laporanpengajuanlogistik_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, jenisbarang_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('barang_harganetto, qtystok, terimabarang, hargabeli', 'numerical'),
			array('barang_nama', 'length', 'max'=>100),
			array('barang_type, barang_satuan, jenisbarang_nama, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('tgltransaksi, create_time, pemakaianbarang, rencanapemesanan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgltransaksi, create_time, barang_id, barang_nama, barang_type, barang_harganetto, barang_satuan, qtystok, jenisbarang_id, jenisbarang_nama, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, terimabarang, pemakaianbarang, rencanapemesanan, hargabeli', 'safe', 'on'=>'search'),
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
			'tgltransaksi' => 'Tgltransaksi',
			'create_time' => 'Waktu Create',
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang Nama',
			'barang_type' => 'Barang Type',
			'barang_harganetto' => 'Barang Harganetto',
			'barang_satuan' => 'Barang Satuan',
			'qtystok' => 'Qtystok',
			'jenisbarang_id' => 'Jenisbarang',
			'jenisbarang_nama' => 'Jenisbarang Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'terimabarang' => 'Terimabarang',
			'pemakaianbarang' => 'Pemakaianbarang',
			'rencanapemesanan' => 'Rencanapemesanan',
			'hargabeli' => 'Hargabeli',
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

		$criteria->compare('tgltransaksi',$this->tgltransaksi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('qtystok',$this->qtystok);
		$criteria->compare('jenisbarang_id',$this->jenisbarang_id);
		$criteria->compare('jenisbarang_nama',$this->jenisbarang_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('terimabarang',$this->terimabarang);
		$criteria->compare('pemakaianbarang',$this->pemakaianbarang,true);
		$criteria->compare('rencanapemesanan',$this->rencanapemesanan,true);
		$criteria->compare('hargabeli',$this->hargabeli);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}