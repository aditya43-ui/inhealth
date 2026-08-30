<?php

/**
 * This is the model class for table "barangpecahbelahdet_t".
 *
 * The followings are the available columns in table 'barangpecahbelahdet_t':
 * @property integer $barangpecahbelahdet_id
 * @property integer $barangpecahbelah_id
 * @property integer $barang_id
 * @property string $keterangan
 * @property integer $jumlah
 * @property double $harga_satuan
 *
 * The followings are the available model relations:
 * @property BarangpecahbelahT $barangpecahbelah
 * @property BarangM $barang
 */
class BarangpecahbelahdetT extends CActiveRecord
{
    public $barang_nama, $barang_kode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangpecahbelahdetT the static model class
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
		return 'barangpecahbelahdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barangpecahbelah_id, barang_id', 'required'),
			array('barangpecahbelah_id, barang_id, jumlah', 'numerical', 'integerOnly'=>true),
			array('harga_satuan', 'numerical'),
			array('keterangan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barangpecahbelahdet_id, barangpecahbelah_id, barang_id, keterangan, jumlah, harga_satuan', 'safe', 'on'=>'search'),
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
			'barangpecahbelah' => array(self::BELONGS_TO, 'BarangpecahbelahT', 'barangpecahbelah_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barangpecahbelahdet_id' => 'Barangpecahbelahdet',
			'barangpecahbelah_id' => 'Barangpecahbelah',
			'barang_id' => 'Barang',
			'keterangan' => 'Keterangan',
			'jumlah' => 'Jumlah',
			'harga_satuan' => 'Harga Satuan',
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

		$criteria->compare('barangpecahbelahdet_id',$this->barangpecahbelahdet_id);
		$criteria->compare('barangpecahbelah_id',$this->barangpecahbelah_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('harga_satuan',$this->harga_satuan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}