<?php

/**
 * This is the model class for table "informasiumurhutang_v".
 *
 * The followings are the available columns in table 'informasiumurhutang_v':
 * @property integer $faktur_id
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property integer $syaratbayar_id
 * @property integer $umur_hutang
 * @property double $totalhargabruto
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property double $total_bayar
 * @property double $sisa
 * @property double $sd_0_30
 * @property double $sd_31_60
 * @property double $sd_61_90
 * @property double $sd_91
 */
class InformasiumurhutangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiumurhutangV the static model class
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
		return 'informasiumurhutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktur_id, syaratbayar_id, umur_hutang, supplier_id', 'numerical', 'integerOnly'=>true),
			array('totalhargabruto, total_bayar, sisa, sd_0_30, sd_31_60, sd_61_90, sd_91', 'numerical'),
			array('nofaktur', 'length', 'max'=>50),
			array('supplier_nama', 'length', 'max'=>100),
			array('tglfaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktur_id, nofaktur, tglfaktur, syaratbayar_id, umur_hutang, totalhargabruto, supplier_id, supplier_nama, total_bayar, sisa, sd_0_30, sd_31_60, sd_61_90, sd_91', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faktur_id' => 'Faktur',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'syaratbayar_id' => 'Syaratbayar',
			'umur_hutang' => 'Umur Hutang',
			'totalhargabruto' => 'Totalhargabruto',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'total_bayar' => 'Total Bayar',
			'sisa' => 'Sisa',
			'sd_0_30' => 'Sd 0 30',
			'sd_31_60' => 'Sd 31 60',
			'sd_61_90' => 'Sd 61 90',
			'sd_91' => 'Sd 91',
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

		$criteria->compare('faktur_id',$this->faktur_id);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('umur_hutang',$this->umur_hutang);
		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('total_bayar',$this->total_bayar);
		$criteria->compare('sisa',$this->sisa);
		$criteria->compare('sd_0_30',$this->sd_0_30);
		$criteria->compare('sd_31_60',$this->sd_31_60);
		$criteria->compare('sd_61_90',$this->sd_61_90);
		$criteria->compare('sd_91',$this->sd_91);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}