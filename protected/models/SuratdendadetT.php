<?php

/**
 * This is the model class for table "suratdendadet_t".
 *
 * The followings are the available columns in table 'suratdendadet_t':
 * @property integer $suratdendadet_id
 * @property integer $suratdenda_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $nama_barang
 * @property string $satuan_barang
 * @property double $jumlah_barang
 * @property string $spesifikasi_barang
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $pajak_persen
 * @property double $total_harga
 * @property string $tanggal_pengiriman
 * @property double $keterlambatan
 *
 * The followings are the available model relations:
 * @property SuratdendaT $suratdenda
 */
class SuratdendadetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratdendadetT the static model class
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
		return 'suratdendadet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_barang, satuan_barang, jumlah_barang', 'required'),
			array('suratdenda_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('jumlah_barang, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen, total_harga, keterlambatan', 'numerical'),
			array('jenis_barang', 'length', 'max'=>100),
			array('nama_barang', 'length', 'max'=>300),
			array('satuan_barang', 'length', 'max'=>50),
			array('spesifikasi_barang', 'length', 'max'=>200),
			array('tanggal_pengiriman', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratdendadet_id, suratdenda_id, barang_id, jenis_barang, nama_barang, satuan_barang, jumlah_barang, spesifikasi_barang, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen, total_harga, tanggal_pengiriman, keterlambatan', 'safe', 'on'=>'search'),
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
			'suratdenda' => array(self::BELONGS_TO, 'SuratdendaT', 'suratdenda_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratdendadet_id' => 'Suratdendadet',
			'suratdenda_id' => 'Suratdenda',
			'barang_id' => 'Barang',
			'jenis_barang' => 'Jenis Barang',
			'nama_barang' => 'Nama Barang',
			'satuan_barang' => 'Satuan Barang',
			'jumlah_barang' => 'Jumlah Barang',
			'spesifikasi_barang' => 'Spesifikasi Barang',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'pajak_persen' => 'Pajak Persen',
			'total_harga' => 'Total Harga',
			'tanggal_pengiriman' => 'Tanggal Pengiriman',
			'keterlambatan' => 'Keterlambatan',
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

		$criteria->compare('suratdendadet_id',$this->suratdendadet_id);
		$criteria->compare('suratdenda_id',$this->suratdenda_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenis_barang',$this->jenis_barang,true);
		$criteria->compare('nama_barang',$this->nama_barang,true);
		$criteria->compare('satuan_barang',$this->satuan_barang,true);
		$criteria->compare('jumlah_barang',$this->jumlah_barang);
		$criteria->compare('spesifikasi_barang',$this->spesifikasi_barang,true);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('pajak_persen',$this->pajak_persen);
		$criteria->compare('total_harga',$this->total_harga);
		$criteria->compare('tanggal_pengiriman',$this->tanggal_pengiriman,true);
		$criteria->compare('keterlambatan',$this->keterlambatan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}