<?php

/**
 * This is the model class for table "fakturpembeliantopembayaran_v".
 *
 * The followings are the available columns in table 'fakturpembeliantopembayaran_v':
 * @property integer $faktur_id
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property double $totalhutangusaha
 * @property string $typefaktur
 */
class FakturpembeliantopembayaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturpembeliantopembayaranV the static model class
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
		return 'fakturpembeliantopembayaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktur_id, ruangan_id, instalasi_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('totalhutangusaha', 'numerical'),
			array('nofaktur, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('supplier_nama', 'length', 'max'=>100),
			array('tglfaktur, tgljatuhtempo, typefaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktur_id, nofaktur, tglfaktur, tgljatuhtempo, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, supplier_id, supplier_nama, totalhutangusaha, typefaktur', 'safe', 'on'=>'search'),
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
			'faktur_id' => 'Faktur',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'totalhutangusaha' => 'Totalhutangusaha',
			'typefaktur' => 'Typefaktur',
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
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('totalhutangusaha',$this->totalhutangusaha);
		$criteria->compare('typefaktur',$this->typefaktur,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}