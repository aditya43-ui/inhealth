<?php

/**
 * This is the model class for table "ubahfakturbeli_r".
 *
 * The followings are the available columns in table 'ubahfakturbeli_r':
 * @property integer $ubahfakturbeli_id
 * @property integer $fakturpembelian_id
 * @property integer $pegawai_id
 * @property integer $supplier_awal
 * @property integer $supplier_akhir
 * @property string $nofaktur_awal
 * @property string $nofaktur_akhir
 * @property double $totharganetto_awal
 * @property double $totharganetto_akhir
 * @property double $jmldiscount_awal
 * @property double $jmldiscount_akhir
 * @property double $totalpajakppn_awal
 * @property double $totalpajakppn_akhir
 * @property double $totalhargabrutto_awal
 * @property double $totalhargabrutto_akhir
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property FakturpembelianT $fakturpembelian
 */
class UbahfakturbeliR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahfakturbeliR the static model class
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
		return 'ubahfakturbeli_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fakturpembelian_id, pegawai_id, create_time, create_loginpemakai_id', 'required'),
			array('fakturpembelian_id, pegawai_id, supplier_awal, supplier_akhir, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('totharganetto_awal, totharganetto_akhir, jmldiscount_awal, jmldiscount_akhir, totalpajakppn_awal, totalpajakppn_akhir, totalhargabrutto_awal, totalhargabrutto_akhir', 'numerical'),
			array('nofaktur_awal, nofaktur_akhir', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ubahfakturbeli_id, fakturpembelian_id, pegawai_id, supplier_awal, supplier_akhir, nofaktur_awal, nofaktur_akhir, totharganetto_awal, totharganetto_akhir, jmldiscount_awal, jmldiscount_akhir, totalpajakppn_awal, totalpajakppn_akhir, totalhargabrutto_awal, totalhargabrutto_akhir, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'fakturpembelian' => array(self::BELONGS_TO, 'FakturpembelianT', 'fakturpembelian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ubahfakturbeli_id' => 'Ubahfakturbeli',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'pegawai_id' => 'Pegawai',
			'supplier_awal' => 'Supplier Awal',
			'supplier_akhir' => 'Supplier Akhir',
			'nofaktur_awal' => 'Nofaktur Awal',
			'nofaktur_akhir' => 'Nofaktur Akhir',
			'totharganetto_awal' => 'Totharganetto Awal',
			'totharganetto_akhir' => 'Totharganetto Akhir',
			'jmldiscount_awal' => 'Jumlah Keringanan Awal',
			'jmldiscount_akhir' => 'Jumlah Keringanan Akhir',
			'totalpajakppn_awal' => 'Totalpajakppn Awal',
			'totalpajakppn_akhir' => 'Totalpajakppn Akhir',
			'totalhargabrutto_awal' => 'Totalhargabrutto Awal',
			'totalhargabrutto_akhir' => 'Totalhargabrutto Akhir',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('ubahfakturbeli_id',$this->ubahfakturbeli_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('supplier_awal',$this->supplier_awal);
		$criteria->compare('supplier_akhir',$this->supplier_akhir);
		$criteria->compare('nofaktur_awal',$this->nofaktur_awal,true);
		$criteria->compare('nofaktur_akhir',$this->nofaktur_akhir,true);
		$criteria->compare('totharganetto_awal',$this->totharganetto_awal);
		$criteria->compare('totharganetto_akhir',$this->totharganetto_akhir);
		$criteria->compare('jmldiscount_awal',$this->jmldiscount_awal);
		$criteria->compare('jmldiscount_akhir',$this->jmldiscount_akhir);
		$criteria->compare('totalpajakppn_awal',$this->totalpajakppn_awal);
		$criteria->compare('totalpajakppn_akhir',$this->totalpajakppn_akhir);
		$criteria->compare('totalhargabrutto_awal',$this->totalhargabrutto_awal);
		$criteria->compare('totalhargabrutto_akhir',$this->totalhargabrutto_akhir);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}