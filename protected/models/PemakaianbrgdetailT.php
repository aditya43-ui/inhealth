<?php

/**
 * This is the model class for table "pemakaianbrgdetail_t".
 *
 * The followings are the available columns in table 'pemakaianbrgdetail_t':
 * @property integer $pemakaianbrgdetail_t
 * @property integer $pemakaianbarang_id
 * @property integer $barang_id
 * @property integer $jmlpakai
 * @property string $satuanpakai
 * @property double $harganetto
 * @property double $ppn
 * @property double $disc
 * @property double $hpp
 * @property double $hargajual
 * @property string $catatanbrg
 *
 * The followings are the available model relations:
 * @property BarangM $barang
 * @property PemakaianbarangT $pemakaianbarang
 */
class PemakaianbrgdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemakaianbrgdetailT the static model class
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
		return 'pemakaianbrgdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemakaianbarang_id, barang_id, jmlpakai, harganetto, ppn, disc, hpp, hargajual', 'required'),
			array('pemakaianbarang_id, barang_id, jmlpakai', 'numerical', 'integerOnly'=>true),
			array('harganetto, ppn, disc, hpp, hargajual', 'numerical'),
			array('satuanpakai', 'length', 'max'=>50),
			array('catatanbrg', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemakaianbrgdetail_t, pemakaianbarang_id, barang_id, jmlpakai, satuanpakai, harganetto, ppn, disc, hpp, hargajual, catatanbrg', 'safe', 'on'=>'search'),
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
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
			'pemakaianbarang' => array(self::BELONGS_TO, 'PemakaianbarangT', 'pemakaianbarang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemakaianbrgdetail_t' => 'Pemakaian Barang Detail',
			'pemakaianbarang_id' => 'Pemakaian Barang',
			'barang_id' => 'Barang',
			'jmlpakai' => 'Jumlah Pakai',
			'satuanpakai' => 'Satuan Pakai',
			'harganetto' => 'Harga Netto',
			'ppn' => 'PPN',
			'disc' => 'Keringanan',
			'hpp' => 'HPP',
			'hargajual' => 'Harga Jual',
			'catatanbrg' => 'Catatan Barang',
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

		$criteria->compare('pemakaianbrgdetail_t',$this->pemakaianbrgdetail_t);
		$criteria->compare('pemakaianbarang_id',$this->pemakaianbarang_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('jmlpakai',$this->jmlpakai);
		$criteria->compare('satuanpakai',$this->satuanpakai,true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('ppn',$this->ppn);
		$criteria->compare('disc',$this->disc);
		$criteria->compare('hpp',$this->hpp);
		$criteria->compare('hargajual',$this->hargajual);
		$criteria->compare('catatanbrg',$this->catatanbrg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}