<?php

/**
 * This is the model class for table "invbarangdet_t".
 *
 * The followings are the available columns in table 'invbarangdet_t':
 * @property integer $invbarangdet_id
 * @property string $barang_satuan
 * @property integer $invbarang_id
 * @property integer $barang_id
 * @property double $volume_fisik
 * @property double $harga_satuan
 * @property double $jumlah_harga
 * @property double $harga_netto
 * @property double $jumlah_netto
 * @property string $kondisi_barang
 * @property integer $forminvbarangdet_id
 * @property integer $inventarisasi_id
 * @property string $tglperiksafisik
 * @property double $volume_sistem
 * @property double $selisih_sistem
 * @property double $selisih_fisik
 *
 * The followings are the available model relations:
 * @property ForminvbarangdetR $forminvbarangdet
 * @property InvbarangT $invbarang
 * @property InventarisasiruanganT $inventarisasi
 */
class InvbarangdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvbarangdetT the static model class
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
		return 'invbarangdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, volume_fisik, jumlah_harga, harga_netto, jumlah_netto, kondisi_barang, volume_sistem, selisih_sistem, selisih_fisik', 'required'),
			array('invbarang_id, barang_id, forminvbarangdet_id, inventarisasi_id', 'numerical', 'integerOnly'=>true),
			array('volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, volume_sistem, selisih_sistem, selisih_fisik, totalnilaipersediaan', 'numerical'),
			array('barang_satuan, kondisi_barang', 'length', 'max'=>50),
			array('tglperiksafisik', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invbarangdet_id, barang_satuan, invbarang_id, barang_id, volume_fisik, harga_satuan, jumlah_harga, harga_netto, jumlah_netto, kondisi_barang, forminvbarangdet_id, inventarisasi_id, tglperiksafisik, volume_sistem, selisih_sistem, selisih_fisik, totalnilaipersediaan', 'safe', 'on'=>'search'),
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
			'forminvbarangdet' => array(self::BELONGS_TO, 'ForminvbarangdetR', 'forminvbarangdet_id'),
			'invbarang' => array(self::BELONGS_TO, 'InvbarangT', 'invbarang_id'),
			'inventarisasi' => array(self::BELONGS_TO, 'InventarisasiruanganT', 'inventarisasi_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invbarangdet_id' => 'Invbarangdet',
			'barang_satuan' => 'Barang Satuan',
			'invbarang_id' => 'Invbarang',
			'barang_id' => 'Barang',
			'volume_fisik' => 'Volume Fisik',
			'harga_satuan' => 'Harga Satuan',
			'jumlah_harga' => 'Jumlah Harga',
			'harga_netto' => 'Harga Netto',
			'jumlah_netto' => 'Jumlah Netto',
			'kondisi_barang' => 'Kondisi Barang',
			'forminvbarangdet_id' => 'Forminvbarangdet',
			'inventarisasi_id' => 'Inventarisasi',
			'tglperiksafisik' => 'Tglperiksafisik',
			'volume_sistem' => 'Volume Sistem',
			'selisih_sistem' => 'Selisih Sistem',
			'selisih_fisik' => 'Selisih Fisik',
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

		$criteria->compare('invbarangdet_id',$this->invbarangdet_id);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('invbarang_id',$this->invbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('volume_fisik',$this->volume_fisik);
		$criteria->compare('harga_satuan',$this->harga_satuan);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah_netto',$this->jumlah_netto);
		$criteria->compare('kondisi_barang',$this->kondisi_barang,true);
		$criteria->compare('forminvbarangdet_id',$this->forminvbarangdet_id);
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('volume_sistem',$this->volume_sistem);
		$criteria->compare('selisih_sistem',$this->selisih_sistem);
		$criteria->compare('selisih_fisik',$this->selisih_fisik);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
