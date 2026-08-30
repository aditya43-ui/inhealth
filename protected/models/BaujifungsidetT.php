<?php

/**
 * This is the model class for table "baujifungsidet_t".
 * 
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'baujifungsidet_t':
 * @property integer $baujifungsidet_id
 * @property integer $baujifungsi_id
 * @property integer $barang_id
 * @property string $jenis_barang
 * @property string $nama_barang
 * @property string $satuan_barang
 * @property double $jumlah_barang
 * @property string $hasil_uji
 * @property string $keterangan_uji
 *
 * The followings are the available model relations:
 * @property BaujifungsiT $baujifungsi
 */
class BaujifungsidetT extends CActiveRecord
{
        public $hasil;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaujifungsidetT the static model class
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
		return 'baujifungsidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('baujifungsi_id, nama_barang, satuan_barang, jumlah_barang, hasil_uji', 'required'),
			array('baujifungsi_id, barang_id', 'numerical', 'integerOnly'=>true),
			array('jumlah_barang', 'numerical'),
			array('jenis_barang, hasil_uji', 'length', 'max'=>100),
			array('nama_barang, keterangan_uji', 'length', 'max'=>300),
			array('satuan_barang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('baujifungsidet_tanggal, islengkap, isfungsibaik', 'safe'),
			array('baujifungsidet_id, baujifungsi_id, barang_id, jenis_barang, nama_barang, satuan_barang, jumlah_barang, hasil_uji, keterangan_uji, islengkap, isfungsibaik', 'safe', 'on'=>'search'),
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
			'baujifungsi' => array(self::BELONGS_TO, 'BaujifungsiT', 'baujifungsi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'baujifungsidet_id' => 'Baujifungsidet',
			'baujifungsi_id' => 'Baujifungsi',
			'barang_id' => 'Barang',
			'jenis_barang' => 'Jenis Barang',
			'nama_barang' => 'Nama Barang',
			'satuan_barang' => 'Satuan Barang',
			'jumlah_barang' => 'Jumlah Barang',
			'hasil_uji' => 'Hasil Uji',
			'keterangan_uji' => 'Keterangan Uji',
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

		$criteria->compare('baujifungsidet_id',$this->baujifungsidet_id);
		$criteria->compare('baujifungsi_id',$this->baujifungsi_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jenis_barang',$this->jenis_barang,true);
		$criteria->compare('nama_barang',$this->nama_barang,true);
		$criteria->compare('satuan_barang',$this->satuan_barang,true);
		$criteria->compare('jumlah_barang',$this->jumlah_barang);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);
		$criteria->compare('keterangan_uji',$this->keterangan_uji,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}