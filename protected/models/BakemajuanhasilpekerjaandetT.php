<?php

/**
 * This is the model class for table "bakemajuanhasilpekerjaandet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'bakemajuanhasilpekerjaandet_t':
 * @property integer $bakemajuanhasilpekerjaandet_id
 * @property integer $bakemajuanhasilpekerjaan_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $nama_barang
 * @property double $volume_barang
 * @property double $harga_satuan
 * @property double $pajak_persen
 * @property double $pajak_jumlah
 * @property double $harga_total
 *
 * The followings are the available model relations:
 * @property BakemajuanhasilpekerjaanT $bakemajuanhasilpekerjaan
 */
class BakemajuanhasilpekerjaandetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BakemajuanhasilpekerjaandetT the static model class
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
		return 'bakemajuanhasilpekerjaandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bakemajuanhasilpekerjaan_id, nama_barang, volume_barang, harga_satuan, pajak_persen, pajak_jumlah, harga_total', 'required'),
			array('bakemajuanhasilpekerjaan_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('volume_barang, harga_satuan, pajak_persen, pajak_jumlah, harga_total', 'numerical'),
			array('jenis_barang', 'length', 'max'=>100),
			array('nama_barang, barang_satuan', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bakemajuanhasilpekerjaandet_id, bakemajuanhasilpekerjaan_id, barang_id, jenis_barang, nama_barang, volume_barang, harga_satuan, pajak_persen, pajak_jumlah, harga_total', 'safe', 'on'=>'search'),
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
			'bakemajuanhasilpekerjaan' => array(self::BELONGS_TO, 'BakemajuanhasilpekerjaanT', 'bakemajuanhasilpekerjaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bakemajuanhasilpekerjaandet_id' => 'Bakemajuanhasilpekerjaandet',
			'bakemajuanhasilpekerjaan_id' => 'Bakemajuanhasilpekerjaan',
			'barang_id' => 'Barang',
			'jenis_barang' => 'Jenis Barang',
			'nama_barang' => 'Nama Barang',
			'volume_barang' => 'Volume Barang',
			'harga_satuan' => 'Harga Satuan',
			'pajak_persen' => 'Pajak Persen',
			'pajak_jumlah' => 'Pajak Jumlah',
			'harga_total' => 'Harga Total',
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

		$criteria->compare('bakemajuanhasilpekerjaandet_id',$this->bakemajuanhasilpekerjaandet_id);
		$criteria->compare('bakemajuanhasilpekerjaan_id',$this->bakemajuanhasilpekerjaan_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenis_barang',$this->jenis_barang,true);
		$criteria->compare('nama_barang',$this->nama_barang,true);
		$criteria->compare('volume_barang',$this->volume_barang);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('pajak_persen',$this->pajak_persen);
		$criteria->compare('pajak_jumlah',$this->pajak_jumlah);
		$criteria->compare('harga_total',$this->harga_total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}