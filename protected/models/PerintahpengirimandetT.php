<?php

/**
 * This is the model class for table "perintahpengirimandet_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'perintahpengirimandet_t':
 * @property integer $perintahpengirimandet_id
 * @property integer $perintahpengiriman_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $barang_nama
 * @property string $barang_spesifikasi
 * @property string $barang_satuan
 * @property double $barang_jumlah
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $pajak_persen
 *
 * The followings are the available model relations:
 * @property PerintahpengirimanT $perintahpengiriman
 */
class PerintahpengirimandetT extends CActiveRecord
{       
    public $sebelum_pajak; 
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerintahpengirimandetT the static model class
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
		return 'perintahpengirimandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_nama, barang_satuan, barang_jumlah, harga_satuan, jumlah_harga', 'required'),
			array('suratperjanjiankerjarincian_id, perintahpengiriman_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('barang_jumlah, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'numerical'),
			array('jenis_barang, barang_satuan', 'length', 'max'=>50),
			array('barang_nama', 'safe'),
			array('barang_spesifikasi', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perintahpengirimandet_id, perintahpengiriman_id, barang_id, jenis_barang, barang_nama, barang_spesifikasi, barang_satuan, barang_jumlah, harga_satuan, jumlah_harga, jumlah_pajak, pajak_persen', 'safe', 'on'=>'search'),
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
			'perintahpengiriman' => array(self::BELONGS_TO, 'PerintahpengirimanT', 'perintahpengiriman_id'),
			'suratperjanjiankerjarincian' => array(self::BELONGS_TO, 'SuratperjanjiankerjarincianT', 'suratperjanjiankerjarincian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perintahpengirimandet_id' => 'Perintahpengirimandet',
			'perintahpengiriman_id' => 'Perintahpengiriman',
			'barang_id' => 'Barang',
			'jenis_barang' => 'Jenis Barang',
			'barang_nama' => 'Barang Nama',
			'barang_spesifikasi' => 'Barang Spesifikasi',
			'barang_satuan' => 'Barang Satuan',
			'barang_jumlah' => 'Barang Jumlah',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'pajak_persen' => 'Pajak Persen',
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

		$criteria->compare('perintahpengirimandet_id',$this->perintahpengirimandet_id);
		$criteria->compare('perintahpengiriman_id',$this->perintahpengiriman_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenis_barang',$this->jenis_barang,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_spesifikasi',$this->barang_spesifikasi,true);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jumlah',$this->barang_jumlah);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('pajak_persen',$this->pajak_persen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}